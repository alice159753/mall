<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Admin.php");
    ob_clean();

    $no_list = isset($_REQUEST["no_list"]) ? $_REQUEST["no_list"] : 0;

    if( empty($no_list) )
    {
        Output::error('无数据！',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myAdmin = new Admin($myMySQL);

    $noList = explode(",", $no_list);

    $error_flag = 0;

    for($i = 0; isset($noList[$i]); $i++)
    {
        if( $noList[$i] == 1 )
        {
            $error_flag = 1;

            continue;
        }

        if( empty($noList[$i]) )
        {
            continue;
        }

        $myAdmin->remove("no = ". $noList[$i]);
    }

    if( $error_flag == 1 )
    {
        Output::error('系统管理员不能删除！',array(), 1);
    }
    else
    {
        Output::succ('删除成功！',array());
    }


?>