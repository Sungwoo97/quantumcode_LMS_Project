<?php
require_once __DIR__ . '/../inc/demo_safety.php';
require_once __DIR__ . '/reporting_test.php';
$path = tempnam(sys_get_temp_dir(), 'qc-rate-test-');
try {
    for ($count=0; $count<10; $count++) {
        check_same(true, demo_rate_allow($path,'login:192.0.2.1',10,60,100));
    }
    check_same(false,demo_rate_allow($path,'login:192.0.2.1',10,60,100));
    check_same(true,demo_rate_allow($path,'login:192.0.2.2',10,60,100));
    check_same(true,demo_rate_allow($path,'login:192.0.2.1',10,60,160));
    $entries=[];
    for ($count=0; $count<1024; $count++) {
        $entries[hash('sha256',(string)$count)]=['until'=>1000,'count'=>1];
    }
    file_put_contents($path,json_encode($entries));
    check_same(false,demo_rate_allow($path,'new-client',10,60,900));
    check_same(true,demo_rate_allow($path,'new-client',10,60,1000));
    echo "demo rate: limit/window/IP/bounded entries: OK\n";
} finally {
    unlink($path);
}