<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    include_once(INCLUDE_DIR. "/Output.php");
    ob_clean();

    $title = !empty($_REQUEST["title"]) ? trim($_REQUEST["title"]) : "" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myPostageConfig = new PostageConfig($myMySQL);

    $dataArray = $_REQUEST;
    $dataArray['add_time'] = 'now()';
    $dataArray['first_price'] = $_REQUEST['first_price'] * 100;
    $dataArray['continue_price'] = $_REQUEST['continue_price'] * 100;

    $myPostageConfig->addRow($dataArray);

    Output::succ('添加成功！', array());

?>