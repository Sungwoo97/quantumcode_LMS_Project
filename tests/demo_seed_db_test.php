<?php
if (PHP_SAPI !== 'cli' || getenv('DEMO_MODE') !== '1' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '')) {
    exit("로컬 qc_demo_*verify DB 전용입니다.\n");
}
ob_start();
require_once __DIR__ . '/reporting_test.php';
ob_end_clean();
require_once __DIR__ . '/../inc/demo_seed.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require __DIR__ . '/../admin/inc/dbcon.php';
$options = getopt('', ['date:']);
$plan = demo_seed_plan($options['date'] ?? date('Y-m-d'));
$password = getenv('DEMO_PASSWORD') ?: '';
if (strlen($password) < 4) {
    throw new RuntimeException('검증용 DEMO_PASSWORD가 필요합니다.');
}
demo_seed_run($mysqli, $plan, $password);
$before = [];
foreach (['admins', 'teachers', 'memberskakao', 'lecture_category', 'lecture_list', 'lecture_video', 'lecture_order', 'lecture_order_item', 'lecture_watch', 'lecture_review', 'coupons', 'coupons_usercp'] as $table) {
    $before[$table] = $mysqli->query("SELECT * FROM `$table` ORDER BY 1")->fetch_all(MYSQLI_ASSOC);
}
demo_seed_run($mysqli, $plan, $password);
foreach ($before as $table => $rows) {
    check_same($rows, $mysqli->query("SELECT * FROM `$table` ORDER BY 1")->fetch_all(MYSQLI_ASSOC));
}
check_same(120, (int) $mysqli->query("SELECT COUNT(*) FROM lecture_order WHERE order_id REGEXP '^portfolio-seed-[0-9]{3}$'")->fetch_row()[0]);
check_same(0, (int) $mysqli->query("SELECT COUNT(*) FROM (SELECT o.odid FROM lecture_order o JOIN lecture_order_item oi ON oi.odid=o.odid WHERE o.order_id REGEXP '^portfolio-seed-[0-9]{3}$' GROUP BY o.odid,o.total_price HAVING SUM(oi.paid_price) <> o.total_price) mismatch")->fetch_row()[0]);
check_same(0, (int) $mysqli->query("SELECT COUNT(*) FROM lecture_order WHERE order_id REGEXP '^portfolio-seed-[0-9]{3}$' AND (pay_method <> 'DEMO' OR payment_key IS NOT NULL)")->fetch_row()[0]);
check_same(12, (int) $mysqli->query("SELECT COUNT(DISTINCT DATE_FORMAT(createdate,'%Y-%m')) FROM lecture_order WHERE order_id REGEXP '^portfolio-seed-[0-9]{3}$'")->fetch_row()[0]);
check_same(true, (int) $mysqli->query("SELECT COUNT(*) FROM lecture_order o JOIN lecture_order_item oi ON oi.odid=o.odid WHERE o.mid='portfolio01@example.com' AND oi.status=1")->fetch_row()[0] > 0);
foreach (['A9001', 'B9001', 'C9001'] as $category_code) {
    $filter = $mysqli->prepare("SELECT COUNT(*) FROM lecture_list l JOIN lecture_category c ON c.code=? WHERE l.title LIKE '[체험]%' AND l.category LIKE CONCAT('%', c.code, '%')");
    $filter->execute([$category_code]);
    check_same(12, (int) $filter->get_result()->fetch_row()[0]);
}
check_same(12, (int) $mysqli->query("SELECT COUNT(*) FROM lecture_list l JOIN teachers t ON t.id=l.t_id JOIN lecture_category c ON c.lcid=l.lcid WHERE l.title LIKE '[체험]%' AND c.code='C9001'")->fetch_row()[0]);
$login=$mysqli->prepare('SELECT COUNT(*) FROM admins WHERE userid=? AND passwd=? AND level=10');
$login->execute(['portfolio_demo',hash('sha512',$password)]);
check_same(1,(int)$login->get_result()->fetch_row()[0]);
$login=$mysqli->prepare('SELECT COUNT(*) FROM memberskakao WHERE memEmail=? AND memPassword=? AND account_activation_token IS NULL');
$login->execute(['portfolio01@example.com',hash('sha512',$password)]);
check_same(1,(int)$login->get_result()->fetch_row()[0]);
$period = reporting_period();
$start = $period['start'];
$end = $period['end'];
$expected = (int) $mysqli->query("SELECT COALESCE(SUM(oi.paid_price),0) FROM lecture_order_item oi JOIN lecture_order o ON o.odid=oi.odid WHERE oi.status IN (1,4) AND o.createdate >= '$start' AND o.createdate < '$end'")->fetch_row()[0];
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__DIR__));
ob_start();
require __DIR__ . '/../admin/sales/sales_data.php';
$months = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
check_same(12, count($months));
check_same($expected, array_sum(array_column($months, 'sales')));
check_same(substr($start, 0, 7), $months[0]['month']);
check_same($period['month'], $months[11]['month']);
ob_start();
require __DIR__ . '/../admin/sales/sales_course.php';
$courses = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
$course_totals = [];
foreach ($courses as $row) {
    $course_totals[$row['lid']] = ($course_totals[$row['lid']] ?? 0) + $row['sales'];
}
foreach ($course_totals as $course_id => $sales) {
    $total = (int) $mysqli->query("SELECT COALESCE(SUM(oi.paid_price),0) FROM lecture_order_item oi JOIN lecture_order o ON o.odid=oi.odid WHERE oi.status IN (1,4) AND oi.lid=" . (int) $course_id . " AND o.createdate >= '$start' AND o.createdate < '$end'")->fetch_row()[0];
    check_same($total, $sales);
}
echo "database seed: repeat-safe; 120 orders; item totals equal; monthly total=$expected; course totals: OK\n";