<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR ."/Tools.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myDiscountCouponRecord = new DiscountCouponRecord($myMySQL);

    $dataArray = $_REQUEST;
    $dataArray['add_time']    = 'now()';

    $myDiscountCouponRecord->addRow($dataArray);

    Output::succ('添加成功！',array());

?>