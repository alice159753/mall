<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

    $no_list = isset($_REQUEST["no_list"]) ? $_REQUEST["no_list"] : 0;

    if( empty($no_list) )
    {
        Output::error('无数据！',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myRole = new Role($myMySQL);

    $noList = explode(",", $no_list);

    for($i = 0; isset($noList[$i]); $i++)
    {
        if( empty($noList[$i]) )
        {
            continue;
        }

        $myRole->remove("no = ". $noList[$i]);
    }

    Output::succ('删除成功！', array());

?>