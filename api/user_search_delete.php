<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Search.php");
    ob_clean();


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySearch = new Search($myMySQL);

    $search_no = !empty($_REQUEST["search_no"]) ? $_REQUEST["search_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($search_no) )
    {
        Output::error('search_no不能为空', array());
    }

    if( empty($user_no) )
    {
        Output::error('user_no不能为空', array());
    }

    $dataArray = array();
    $dataArray['is_display'] = 0;

    $mySearch->update($dataArray, "no = $search_no and user_no = $user_no");

    Output::succ('', array());
    


?>