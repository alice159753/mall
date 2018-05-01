<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Admin.php");
    ob_clean();

    $account = !empty($_REQUEST["account"]) ? trim($_REQUEST["account"]) : "" ;
    $password = !empty($_REQUEST["password"]) ? trim($_REQUEST["password"]) : "" ;
    $role_no = !empty($_REQUEST["role_no"]) ? $_REQUEST["role_no"] : 0 ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myAdmin = new Admin($myMySQL);

    $condition = "account = '". $account ."'";

    if( $myAdmin->getCount($condition) >= 1 )
    {
        Output::error('帐号不能重复！',array(), 1);
    }

    $dataArray = array();
    $dataArray['account']  = $account;
    $dataArray['password'] = md5($password);
    $dataArray['role_no']  = $role_no;
    $dataArray['add_time'] = 'now()';

    $myAdmin->addRow($dataArray);

    Output::succ('添加成功！', array());

?>