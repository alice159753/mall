<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $_REQUEST["no"] == 0 )
    {
        Output::error('无数据！',array(), 1);
        exit;
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myUserLabel = new UserLabel($myMySQL);
    $myUser = new User($myMySQL);

    if( $myUser->getCount("user_label_no = $no") >= 1 )
    {
        Output::error('该标签下面有用户不能删除',array(), 1);
    }

    $myUserLabel->remove("no = ". $no);

    Output::succ('删除成功！',array());

?>