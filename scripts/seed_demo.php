<?php
// 웹 호출과 대상 DB 오입력을 거절하는 수동 실행 전용 시드다.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI 전용입니다.');
}
require_once __DIR__ . '/../inc/demo_seed.php';
$options = getopt('', ['database:', 'date:']);
if (getenv('DEMO_MODE') !== '1' || empty($options['database']) || $options['database'] !== getenv('DB_NAME')
    || empty($options['date']) || strlen(getenv('DEMO_PASSWORD') ?: '') < 8) {
    fwrite(STDERR, "DEMO_MODE=1, 8자 이상의 DEMO_PASSWORD와 --database=DB_NAME --date=YYYY-MM-DD가 필요합니다.\n");
    exit(1);
}
$plan = demo_seed_plan($options['date']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require __DIR__ . '/../admin/inc/dbcon.php';
$lock_name = 'portfolio-demo-seed:' . getenv('DB_NAME');
$lock = $mysqli->prepare('SELECT GET_LOCK(?, 0) AS acquired');
$lock->execute([$lock_name]);
if ((int) $lock->get_result()->fetch_assoc()['acquired'] !== 1) {
    throw new RuntimeException('다른 시드가 실행 중입니다.');
}
try {
    demo_seed_run($mysqli, $plan, getenv('DEMO_PASSWORD'));
    echo "demo seed: OK (학습자30, 강사5, 강의12, 가상주문120; 기존 샘플 보존)\n";
} finally {
    $release = $mysqli->prepare('SELECT RELEASE_LOCK(?)');
    $release->execute([$lock_name]);
}