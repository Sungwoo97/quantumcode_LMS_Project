<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

    $lid = $_POST['lid'];
    $mid = $_POST['mid'];
    $eventType = $_POST['eventType'];
    $timestamp = $_POST['timestamp'];

   
    $sql = "INSERT INTO lecture_watch (lid, mid, event_type, timestamp) 
    VALUES ($lid, '$mid', '$eventType', $timestamp)";
    $result = $mysqli->qeury($sql);

    if($result){
      echo json_encode(['status' => 'success']);
    }