<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Suggest.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $content = !empty($_REQUEST["content"]) ? trim($_REQUEST["content"]) : "";
    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";

    if( empty($content) )
    {
        Output::error('建议内容不能为空！',array(), 1);
    }

    $mySuggest = new Suggest($myMySQL);

    $dataArray = array();
    $dataArray['user_no']  = $user_no;
    $dataArray['content']  = $content;
    $dataArray['add_time'] = 'now()';

    $mySuggest->addRow($dataArray);

    Output::succ('提交成功',array());

?>