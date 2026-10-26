<?php
// 기준일에 따라 동일한 수량·상태·안분 금액의 가상 주문 계획을 만든다.
function demo_seed_plan(string $date) {
    $today = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
    if (!$today || $today->format('Y-m-d') !== $date) {
        throw new InvalidArgumentException('기준일은 YYYY-MM-DD 형식이어야 합니다.');
    }
    $first = $today->modify('first day of this month')->modify('-11 months');
    $orders = [];
    for ($index = 0; $index < 120; $index++) {
        $course = $index % 12;
        $course_ids = $index % 4 === 0 ? [$course, ($course + 1) % 12] : [$course];
        $prices = [];
        foreach ($course_ids as $course_id) {
            $prices[$course_id] = 30000 + $course_id * 1000;
        }
        $sum = array_sum($prices);
        $total = $index % 5 === 0 ? (int) ($sum * 0.9) : $sum;
        $paid = [];
        foreach ($prices as $course_id => $price) {
            $paid[$course_id] = (int) floor($price * $total / $sum);
        }
        $paid[array_search(max($prices), $prices)] += $total - array_sum($paid);
        $items = [];
        foreach ($prices as $course_id => $price) {
            $items[] = ['course' => $course_id, 'price' => $price, 'paid_price' => $paid[$course_id]];
        }
        $status = [0, 2, 3, 4, 1, 1, 1, 1, 1, 1][($index + intdiv($index, 10)) % 10];
        $orders[] = ['key' => sprintf('portfolio-seed-%03d', $index + 1), 'learner' => $index === 119 ? 1 : $index % 30 + 1,
            'date' => ($index === 119 ? $today : $first->modify('+' . intdiv($index, 10) . ' months'))->format('Y-m-d') . ' 09:00:00',
            'status' => $index === 119 ? 1 : $status, 'total' => $total, 'discount' => $sum - $total, 'items' => $items];
    }
    return ['learners' => 30, 'teachers' => 5, 'courses' => 12, 'orders' => $orders];
}

// 전용 샘플 키가 이미 있으면 내용을 변경하지 않고 기존 PK만 돌려준다.
function demo_seed_insert(mysqli $db, string $table, string $primary, array $key, array $values) {
    $where = implode(' AND ', array_map(static fn($column) => "`$column` = ?", array_keys($key)));
    $statement = $db->prepare("SELECT `$primary` FROM `$table` WHERE $where");
    $statement->execute(array_values($key));
    $existing = $statement->get_result()->fetch_assoc();
    if ($existing) {
        return (int) $existing[$primary];
    }
    $row = array_merge($key, $values);
    $columns = '`' . implode('`,`', array_keys($row)) . '`';
    $placeholders = implode(',', array_fill(0, count($row), '?'));
    $statement = $db->prepare("INSERT INTO `$table` ($columns) VALUES ($placeholders)");
    $statement->execute(array_values($row));
    return (int) $db->insert_id;
}

// 하나의 트랜잭션에서 부모부터 자식까지 보완하며 사용자 체험 데이터는 덮어쓰지 않는다.
function demo_seed_run(mysqli $db, array $plan, string $password) {
    $tables = ['admins', 'memberskakao', 'teachers', 'lecture_category', 'lecture_list', 'lecture_video', 'lecture_order', 'lecture_order_item', 'lecture_watch', 'lecture_review', 'coupons', 'coupons_usercp'];
    foreach ($tables as $table) {
        $statement = $db->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?');
        $statement->execute([$table]);
        $row = $statement->get_result()->fetch_assoc();
        if (!$row || $row['ENGINE'] !== 'InnoDB') {
            throw new RuntimeException($table . ': InnoDB 테이블이 필요합니다.');
        }
    }
    $hash = hash('sha512', $password);
    $existing = $db->query("SELECT passwd FROM admins WHERE userid='portfolio_demo'")->fetch_assoc();
    if ($existing && !hash_equals($existing['passwd'], $hash)) {
        throw new RuntimeException('공개 계정 비밀번호가 DEMO_PASSWORD와 다릅니다. 기존 계정은 덮어쓰지 않습니다.');
    }
    $db->begin_transaction();
    try {
        demo_seed_insert($db, 'admins', 'idx', ['userid' => 'portfolio_demo'], ['email' => 'portfolio-admin@example.com', 'username' => '공개체험관리자', 'passwd' => $hash, 'level' => 10]);
        for ($number = 1; $number <= 30; $number++) {
            demo_seed_insert($db, 'memberskakao', 'memId', ['memEmail' => sprintf('portfolio%02d@example.com', $number)], ['memName' => '체험학습자' . $number, 'memPassword' => $hash, 'account_activation_token' => null, 'is_verified' => 1, 'is_email_verified' => 1, 'memCreatedAt' => $plan['orders'][($number - 1) * 4]['date']]);
        }
        for ($number = 1; $number <= 5; $number++) {
            demo_seed_insert($db, 'teachers', 'tid', ['id' => 'portfolio_teacher' . $number], ['name' => '체험강사' . $number, 'birth' => '1990-01-01', 'password' => $hash, 'email' => 'portfolio-teacher' . $number . '@example.com', 'number' => 0, 'grade' => 'Silver', 'main' => '개발', 'reg_date' => $plan['orders'][($number - 1) * 10]['date']]);
        }
        demo_seed_insert($db, 'lecture_category', 'lcid', ['code' => 'A9001'], ['pcode' => '', 'ppcode' => '', 'name' => '[체험] 개발', 'step' => 1]);
        demo_seed_insert($db, 'lecture_category', 'lcid', ['code' => 'B9001'], ['pcode' => 'A9001', 'ppcode' => '', 'name' => '[체험] 웹 개발', 'step' => 2]);
        $category_id = demo_seed_insert($db, 'lecture_category', 'lcid', ['code' => 'C9001'], ['pcode' => 'B9001', 'ppcode' => 'A9001', 'name' => '[체험] 실습', 'step' => 3]);
        $courses = [];
        $videos = [];
        for ($index = 0; $index < 12; $index++) {
            $teacher = 'portfolio_teacher' . ($index % 5 + 1);
            $courses[$index] = demo_seed_insert($db, 'lecture_list', 'lid', ['title' => sprintf('[체험] 개발 실습 %02d', $index + 1)], ['category' => 'A9001,B9001,C9001', 'lcid' => $category_id, 't_id' => $teacher, 'isfree' => 0, 'ispremium' => 0, 'ispopular' => 1, 'isrecom' => 1, 'tuition' => 30000 + $index * 1000, 'regist_day' => substr($plan['orders'][0]['date'], 0, 10), 'expiration_day' => '2099-12-31', 'description' => '가상 학습 데이터로 진행하는 개발 실습입니다.', 'difficult' => '초급', 'lecture_status' => 1, 'cover_image' => '/qc/dummy/lecture_test_img.png']);
            $videos[$index] = demo_seed_insert($db, 'lecture_video', 'lvid', ['lid' => $courses[$index], 'video_title' => '체험 실습 영상'], ['t_id' => $teacher, 'video_lecture' => '/qc/dummy/lecture_test_video1.mp4', 'video_duration' => '00:02:00']);
        }
        $coupon = demo_seed_insert($db, 'coupons', 'cid', ['coupon_name' => '[체험] 학습 응원 10%'], ['coupon_image' => '/qc/dummy/coupon_test_img.png', 'coupon_content' => '가상 주문의 10% 할인 사례', 'coupon_type' => 'percentage', 'coupon_ratio' => 10, 'status' => 1, 'enddate' => '2099-12-31', 'userid' => 'portfolio_demo']);
        foreach ($plan['orders'] as $order) {
            $email = sprintf('portfolio%02d@example.com', $order['learner']);
            $coupon_id = null;
            if ($order['discount'] > 0) {
                $coupon_id = demo_seed_insert($db, 'coupons_usercp', 'ucid', ['userid' => $email, 'reason' => $order['key']], ['couponid' => $coupon, 'status' => $order['status'] === 1 || $order['status'] === 4 ? 0 : 1, 'use_max_date' => '2099-12-31', 'regdate' => $order['date']]);
            }
            $lids = array_map(static fn($item) => $courses[$item['course']], $order['items']);
            $order_id = demo_seed_insert($db, 'lecture_order', 'odid', ['order_id' => $order['key']], ['mid' => $email, 'lid' => implode(',', $lids), 'cid' => $coupon_id, 'payment_key' => null, 'pay_method' => 'DEMO', 'total_price' => $order['total'], 'status' => $order['status'], 'createdate' => $order['date'], 'refund_date' => $order['status'] === 3 ? $order['date'] : null]);
            foreach ($order['items'] as $item) {
                $course_id = $courses[$item['course']];
                demo_seed_insert($db, 'lecture_order_item', 'oiid', ['odid' => $order_id, 'lid' => $course_id], ['price' => $item['price'], 'paid_price' => $item['paid_price'], 'status' => $order['status'], 'refund_reason' => $order['status'] >= 3 ? '가상 환불 사례' : null, 'refund_date' => $order['status'] === 3 ? $order['date'] : null]);
                if ($order['status'] === 1 && $order['learner'] % 2 === 0) {
                    demo_seed_insert($db, 'lecture_watch', 'id', ['mid' => $email, 'lid' => $course_id, 'lvid' => $videos[$item['course']], 'event_type' => 'completed'], ['timestamp' => $order['date']]);
                    demo_seed_insert($db, 'lecture_review', 'lrid', ['lid' => $course_id, 'username' => '체험학습자' . $order['learner']], ['profile_image' => '/qc/dummy/teacher_test_img.png', 'regist_day' => $order['date'], 'review' => 4 + $order['learner'] % 2, 'comment' => '실습으로 학습 흐름을 확인했습니다.']);
                }
            }
        }
        $db->commit();
    } catch (Throwable $error) {
        $db->rollback();
        throw $error;
    }
}