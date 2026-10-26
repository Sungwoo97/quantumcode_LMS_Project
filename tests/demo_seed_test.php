<?php
require_once __DIR__ . '/../inc/demo_seed.php';
require_once __DIR__ . '/reporting_test.php';
$plan = demo_seed_plan('2026-10-26');
check_same(30, $plan['learners']);
check_same(5, $plan['teachers']);
check_same(12, $plan['courses']);
check_same(120, count($plan['orders']));
check_same($plan, demo_seed_plan('2026-10-26'));
$months = [];
$statuses = [];
foreach ($plan['orders'] as $order) {
    check_same($order['total'], array_sum(array_column($order['items'], 'paid_price')));
    check_same(true, $order['date'] <= '2026-10-26 23:59:59');
    $months[substr($order['date'], 0, 7)] = true;
    $statuses[$order['status']] = true;
}
check_same(12, count($months));
check_same(5, count($statuses));
check_same(true, count(array_filter($plan['orders'], static fn($order) => $order['learner'] === 1 && $order['status'] === 1)) > 0);
check_same(true, count(array_filter($plan['orders'], static fn($order) => $order['learner'] === 1 && $order['status'] === 1 && $order['date'] >= '2026-10-19 00:00:00')) > 0);
echo "demo seed plan: OK\n";