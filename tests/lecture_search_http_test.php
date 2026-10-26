<?php
if (PHP_SAPI !== 'cli' || empty($argv[1])) exit("사용법: php tests/lecture_search_http_test.php 검색화면URL\n");
// 실제 검색 화면에서 반사 스크립트·인용부호·배열 입력을 검증한다.
foreach ([['search_keyword'=>'<script>window.__portfolio_search_xss=1</script>'],
    ['search_keyword'=>"' OR 1=1 -- "], ['cate'=>"' OR 1=1 -- "], ['search_keyword'=>['invalid']],
    ['page'=>['invalid']], ['page'=>-1], ['page'=>'999999999999999999999999']] as $query) {
    $request = curl_init($argv[1].'?'.http_build_query($query));
    curl_setopt_array($request, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_TIMEOUT=>15]);
    $body = curl_exec($request);
    $status = curl_getinfo($request, CURLINFO_HTTP_CODE);
    if ($status !== 200 || !is_string($body)) throw new RuntimeException('검색 요청 처리 실패: HTTP '.$status);
    if (str_contains($body, '<script>window.__portfolio_search_xss=1</script>')) throw new RuntimeException('검색어가 스크립트로 출력됨');
    if (str_contains($body, 'SQL syntax') || str_contains($body, 'Fatal error')) throw new RuntimeException('검색어 SQL 처리 오류');
}
echo "PASS 검색 화면 HTML·인용부호·배열 입력\n";
