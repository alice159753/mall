<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserLabel.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $no_list = isset($_REQUEST["no_list"]) ? $_REQUEST["no_list"] : 0;

    if( empty($no_list) )
    {
        Output::error('无数据！',array(), 1);
        exit;
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myUserLabel = new UserLabel($myMySQL);
    $myUser = new User($myMySQL);

    $noList = explode(",", $no_list);

    for($i = 0; isset($noList[$i]); $i++)
    {
        if( empty($noList[$i]) )
        {
            continue;
        }

        if( $myUser->getCount("user_label_no = ". $noList[$i]) >= 1 )
        {
            Output::error('该标签下面有用户不能删除',array(), 1);
        }

        $myUserLabel->remove("no = ". $noList[$i]);
    }

    Output::succ('删除成功！',array());

?>