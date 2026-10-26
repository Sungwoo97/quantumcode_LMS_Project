<?php
// 각 엔드포인트가 DB 연결이나 SMTP 접속 이전에 403으로 끝나는지 실제 PHP 프로세스로 확인한다.
$root = dirname(__DIR__);
$files = ['account/mailer.php', 'account/usePhpMailer.php', 'account/signUp_ok.php', 'account/signUp_ok2.php', 'account/signUp_prepare.php', 'account/send_password_reset.php', 'account/process_reset_password.php', 'account/active_account.php', 'account/verify.php', 'account/oauth.php', 'account/kakao_login_ok.php', 'users/users_update_ok.php', 'users/users_delete_ok.php', 'admin/members/member_insert_ok.php', 'admin/teachers/members/member_insert_ok.php', 'admin/teachers/teacher_insert_ok.php', 'admin/teachers/teacher_update_ok.php', 'admin/teachers/teacher/teacher_insert_ok.php', 'admin/teachers/teacher/teacher_update_ok.php', 'admin/lecture/lecture_delete.php', 'admin/lecture/video_delete.php', 'admin/lecture/category_delete.php', 'admin/teachers/lecture/lecture_delete.php', 'admin/teachers/lecture/video_delete.php', 'admin/teachers/lecture/category_delete.php', 'admin/coupon/coupon_del.php', 'admin/coupon/coupon_bulk_delete.php', 'admin/teachers/coupon/coupon_del.php'];
$files = array_merge($files, ['admin/board/board_modify.php', 'admin/board/board_modify_ok.php', 'admin/board/board_reply_modify_ok.php', 'admin/board/board_reply_ok.php', 'admin/board/board_re_reply_ok.php', 'admin/board/board_write.php', 'admin/board/board_write_ok.php', 'admin/board/check_delete.php', 'admin/board/delete.php', 'admin/board/like_up.php', 'admin/board/reply_delete.php', 'admin/board/re_reply_delete.php', 'admin/board/re_reply_modify_ok.php', 'admin/coupon/coupon_edit_ok.php', 'admin/coupon/coupon_regis_ok.php']);
$files = array_merge($files, ['admin/lecture/category_modify.php', 'admin/lecture/lecture_add_video.php', 'admin/lecture/lecture_insert_ok.php', 'admin/lecture/lecture_modify.php', 'admin/lecture/lecture_modify_ok.php', 'admin/lecture/lecture_reply_delete.php', 'admin/lecture/lecture_reply_modify.php', 'admin/members/send_message.php', 'admin/members/send_message2.php', 'admin/teachers/send_message.php', 'admin/teachers/board/board_modify.php', 'admin/teachers/board/board_modify_ok.php', 'admin/teachers/board/board_reply_modify_ok.php', 'admin/teachers/board/board_reply_ok.php', 'admin/teachers/board/board_write.php', 'admin/teachers/board/board_write_ok.php', 'admin/teachers/board/check_delete.php', 'admin/teachers/board/delete.php', 'admin/teachers/board/like_up.php', 'admin/teachers/board/reply_delete.php', 'admin/teachers/board/t_board_re_reply_ok.php', 'admin/teachers/board/t_re_reply_delete.php', 'admin/teachers/board/t_re_reply_modify_ok.php', 'admin/teachers/coupon/coupon_edit_ok.php', 'admin/teachers/coupon/coupon_regis_ok.php', 'admin/teachers/lecture/category_modify.php', 'admin/teachers/lecture/lecture_add_video.php', 'admin/teachers/lecture/lecture_insert_ok.php', 'admin/teachers/lecture/lecture_modify.php', 'admin/teachers/lecture/lecture_modify_ok.php', 'admin/teachers/lecture/lecture_reply_delete.php', 'admin/teachers/lecture/lecture_reply_modify.php', 'admin/teachers/members/send_message.php', 'admin/teachers/messages/sendMessage.php', 'admin/teachers/messages/send_message.php']);
$files = array_merge($files, ['admin/board/board_answer_cancel.php', 'admin/board/board_answer_ok.php', 'admin/coupon/toggle_status.php', 'admin/lecture/category_insert.php', 'admin/lecture/lecture_reply.php', 'admin/teachers/lecture/category_insert.php', 'admin/teachers/lecture/lecture_reply.php', 'admin/teachers/messages/update_is_read.php']);
foreach ($files as $file) {
    $code = 'putenv("DEMO_MODE=1"); register_shutdown_function(function() { echo "STATUS=" . http_response_code(); }); require ' . var_export($root . '/' . $file, true) . ';';
    $process = proc_open([PHP_BINARY, '-r', $code], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    if (!is_resource($process)) {
        throw new RuntimeException('PHP 프로세스 실행 실패');
    }
    $output = stream_get_contents($pipes[1]);
    $errors = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exit = proc_close($process);
    if ($exit !== 0 || $errors !== '' || !str_contains($output, 'STATUS=403')) {
        throw new RuntimeException($file . ': ' . $output . $errors);
    }
}
echo 'demo endpoints: ' . count($files) . " OK\n";