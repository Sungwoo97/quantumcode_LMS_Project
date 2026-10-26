<?php
// 기존 주문은 보존하고 취소 응답 유실 복구에 필요한 열만 추가한다.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI 전용입니다.');
}
$options = getopt('', ['database:']);
if (getenv('DEMO_MODE') !== '1' || empty($options['database']) || $options['database'] !== getenv('DB_NAME')) {
    fwrite(STDERR, "DEMO_MODE=1과 --database=DB_NAME 확인값이 필요합니다.\n");
    exit(1);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require __DIR__.'/../admin/inc/dbcon.php';
if (!$mysqli->query("SHOW COLUMNS FROM lecture_order LIKE 'cancel_request'")->num_rows) {
    $mysqli->query('ALTER TABLE lecture_order ADD COLUMN cancel_request TEXT NULL');
}
echo "PASS 취소 요청 복구용 마이그레이션\n";
