<?php
// 월말의 날짜 넘침 없이 현재·이전 기간과 최근 12개월 경계를 계산한다.
function reporting_period(?DateTimeImmutable $today = null) {
    $month = ($today ?? new DateTimeImmutable('today'))->modify('first day of this month')->setTime(0, 0);
    return [
        'month' => $month->format('Y-m'),
        'previous_month' => $month->modify('-1 month')->format('Y-m'),
        'year' => (int) $month->format('Y'),
        'previous_year' => (int) $month->format('Y') - 1,
        'start' => $month->modify('-11 months')->format('Y-m-d'),
        'end' => $month->modify('+1 month')->format('Y-m-d'),
    ];
}

// 조회 결과를 시간순으로 정렬하고 매출이 없는 달도 0으로 반환한다.
function reporting_months(array $rows, array $period) {
    $sales = [];
    foreach ($rows as $row) {
        $sales[$row['month']] = (int) $row['sales'];
    }
    $months = [];
    $month = new DateTimeImmutable($period['start']);
    for ($offset = 0; $offset < 12; $offset++) {
        $label = $month->modify("+$offset months")->format('Y-m');
        $months[] = ['month' => $label, 'sales' => $sales[$label] ?? 0];
    }
    return $months;
}

// 기준값이 0인 증감률을 실제 0%와 구별한다.
function reporting_change($current, $previous) {
    return $previous > 0 ? round(($current - $previous) / $previous * 100, 2) . '%' : '계산 불가';
}