<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    ob_clean();

    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    if( empty($no) )
    {
        Output::error('error: no not empty',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myBrand = new Brand($myMySQL);

    $categoryRow = $myBrand->getRow("*", "no = $no");

    $dataArray = array();
    $dataArray['is_show'] = $categoryRow['is_show'] == 'Y' ? 'N' : 'Y';
    $dataArray['update_time'] = 'now()';

    $myBrand->update($dataArray, "no = ". $no);

    Output::succ('修改成功！',array());

?>