<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);

    unset($_REQUEST["fileList"]);

    $dataArray = $_REQUEST;
    $dataArray['add_time'] = 'now()';
    $dataArray['pic'] = $fileList;
    $dataArray['shop_price'] = $_REQUEST['shop_price'] * 100;
    $dataArray['market_price'] = $_REQUEST['market_price'] * 100;

    $myProduct->addRow($dataArray);

    Output::succ('添加成功！', array());

?>