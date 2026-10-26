<?php
// 공용 체험 계정과 기준 데이터를 보호하고 실제 외부 메일 발송을 막는다.
function demo_action_allowed(string $action) {
    return getenv('DEMO_MODE') !== '1' || !in_array($action, ['mail', 'account', 'baseline', 'management'], true);
}

// 메뉴나 요청 메서드와 무관하게 실제 처리 전에 차단한다.
function demo_require_safe_action(string $action) {
    if (!demo_action_allowed($action)) {
        http_response_code(403);
        exit('공개 데모에서는 계정·기준 데이터 변경과 외부 메일 발송을 사용할 수 없습니다.');
    }
}

// 한 잠금 파일에서 IP별 시간창을 갱신해 동시 요청과 파일 무한 생성을 막는다.
function demo_rate_allow($path, $key, $limit, $window, $now = null) {
    $now = $now === null ? time() : $now;
    $handle = @fopen($path, 'c+');
    if (!$handle) throw new RuntimeException('요청 제한 저장소를 열지 못했습니다.');
    try {
        if (!flock($handle, LOCK_EX)) throw new RuntimeException('요청 제한 잠금 실패');
        $json = stream_get_contents($handle, 262145);
        if ($json === false || strlen($json) > 262144) throw new RuntimeException('요청 제한 저장소 크기 오류');
        $entries = $json === '' ? array() : json_decode($json, true);
        if (!is_array($entries)) throw new RuntimeException('요청 제한 저장소 형식 오류');
        foreach ($entries as $entry_key => $entry) {
            if (!isset($entry['until'], $entry['count'])) throw new RuntimeException('요청 제한 항목 오류');
            if ($entry['until'] <= $now) unset($entries[$entry_key]);
        }
        $key = hash('sha256', $key);
        if (!isset($entries[$key])) {
            if (count($entries) >= 1024) return false;
            $entries[$key] = array('until'=>$now + $window, 'count'=>0);
        }
        if ($entries[$key]['count'] >= $limit) return false;
        $entries[$key]['count']++;
        $encoded = json_encode($entries);
        rewind($handle);
        if (fwrite($handle, $encoded) !== strlen($encoded) || !ftruncate($handle, strlen($encoded)) || !fflush($handle)) throw new RuntimeException('요청 제한 저장 실패');
        return true;
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}

// 허용된 로그인·주문·환불 처리 경계에서만 실제 클라이언트 IP를 제한한다.
function require_demo_rate(string $action) {
    if (getenv('DEMO_MODE') !== '1') {
        return;
    }
    $limit = $action === 'login' ? 10 : 30;
    $key = $action . ':' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $path = sys_get_temp_dir() . '/qc-demo-rate-' . sha1(__DIR__) . '.json';
    try {
        if (demo_rate_allow($path, $key, $limit, 60)) {
            return;
        }
        http_response_code(429);
        header('Retry-After: 60');
        exit(json_encode(['status'=>'error','message'=>'요청이 많습니다. 1분 후 다시 시도해주세요.'], JSON_UNESCAPED_UNICODE));
    } catch (RuntimeException $error) {
        http_response_code(503);
        exit(json_encode(['status'=>'error','message'=>'요청 제한 저장소를 사용할 수 없습니다.'], JSON_UNESCAPED_UNICODE));
    }
}