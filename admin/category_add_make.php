<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Category.php");
    include_once(INCLUDE_DIR. "/Output.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "";
    
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myCategory = new Category($myMySQL);

    $condition = "title = '". $title ."' AND parent_no = $parent_no";

    if( $myCategory->getCount($condition) >= 1 )
    {
       Output::error('标题不能重复！',array(), 1);
    }

    unset($_REQUEST['fileList']);

    $dataArray = $_REQUEST;
    $dataArray['add_time'] = 'now()';
    $dataArray['pic']      = $fileList;

    $myCategory->addRow($dataArray);

    Output::succ('添加成功！', array());

?>