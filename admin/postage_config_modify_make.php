<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: search.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myPostageConfig= new PostageConfig($myMySQL);

     // check no
    $row = $myPostageConfig->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';

    $myPostageConfig->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>