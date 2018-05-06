<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    if( empty($no) )
    {
        Output::error('error: no not empty',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);

    $categoryRow = $myProduct->getRow("*", "no = $no");

    $dataArray = array();
    $dataArray['is_online'] = $categoryRow['is_online'] == '1' ? '0' : '1';
    $dataArray['update_time'] = 'now()';

    $myProduct->update($dataArray, "no = ". $no);

    Output::succ('修改成功！',array());

?>