<?php
require_once __DIR__ . '/../inc/reporting.php';

// assert 비활성화 설정에서도 회귀 실패를 놓치지 않는다.
function check_same($expected, $actual) {
    if ($expected !== $actual) {
        throw new RuntimeException(var_export([$expected, $actual], true));
    }
}

$period = reporting_period(new DateTimeImmutable('2026-03-31'));
check_same('2026-02', $period['previous_month']);
check_same('2025-04-01', $period['start']);
check_same('2026-04-01', $period['end']);
check_same(2026, $period['year']);
check_same(2025, $period['previous_year']);
check_same('2023-12', reporting_period(new DateTimeImmutable('2024-01-31'))['previous_month']);
check_same('2024-02', reporting_period(new DateTimeImmutable('2024-03-31'))['previous_month']);
$months = reporting_months([['month' => '2026-02', 'sales' => '1500'], ['month' => '2024-01', 'sales' => 999]], $period);
check_same(12, count($months));
check_same(['month' => '2025-04', 'sales' => 0], $months[0]);
check_same(['month' => '2026-02', 'sales' => 1500], $months[10]);
check_same(['month' => '2026-03', 'sales' => 0], $months[11]);
check_same('계산 불가', reporting_change(10, 0));
check_same('50%', reporting_change(15, 10));
check_same('-50%', reporting_change(5, 10));
echo "reporting: OK\n";