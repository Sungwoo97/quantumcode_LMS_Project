<?php
require_once __DIR__ . '/../inc/demo_safety.php';
require_once __DIR__ . '/reporting_test.php';
$previous = getenv('DEMO_MODE');
putenv('DEMO_MODE=1');
foreach (['mail', 'account', 'baseline', 'management'] as $action) {
    check_same(false, demo_action_allowed($action));
}
foreach (['purchase', 'learning', 'refund', 'board'] as $action) {
    check_same(true, demo_action_allowed($action));
}
putenv('DEMO_MODE=0');
check_same(true, demo_action_allowed('mail'));
$previous === false ? putenv('DEMO_MODE') : putenv('DEMO_MODE=' . $previous);
echo "demo safety: OK\n";