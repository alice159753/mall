<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    include_once(INCLUDE_DIR. "/Password.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $password = !empty($_REQUEST["password"]) ? trim($_REQUEST["password"]) : "" ;
    $phone = !empty($_REQUEST["phone"]) ? trim($_REQUEST["phone"]) : "" ;


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUser = new User($myMySQL);

    if( !empty($phone) )
    {
        $condition = "phone = '". $phone ."'";

        if( $myUser->getCount($condition) >= 1 )
        {
            Output::error('电话不能重复！', array(), 1);
        }
    }

    unset($_REQUEST['fileList']);

    $dataArray = $_REQUEST;
    $dataArray['add_time']   = 'now()';
    $dataArray['headimgurl'] = $fileList;

    $salt = Password::getSlat(32);
    $dataArray["password_salt"] = $salt;
    $dataArray["password"] = Password::encrypt($password, $salt);

    $myUser->addRow($dataArray);

    Output::succ('添加成功！', array());

?>