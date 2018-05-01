<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Admin.php");
    ob_clean();

    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $_REQUEST["no"] == 0 )
    {
        Output::error('无数据！',array(), 1);
    }

    if( $no == 1 )
    {
        Output::error('系统管理员不能删除！',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myAdmin = new Admin($myMySQL);

    $myAdmin->remove("no = ". $no);

    Output::succ('删除成功！',array());


?>