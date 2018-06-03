<?php

    //评价订单
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");    
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/ProductComment.php");
    ob_clean();

    $order_info_no = isset($_REQUEST["order_info_no"]) ? $_REQUEST["order_info_no"] : "0";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $contents = isset($_REQUEST["contents"]) ? $_REQUEST["contents"] : array();
    $stars = isset($_REQUEST["stars"]) ? $_REQUEST["stars"] : array();
    $isanons = isset($_REQUEST["isanons"]) ? $_REQUEST["isanons"] : array();
    $productnos = isset($_REQUEST["productnos"]) ? $_REQUEST["productnos"] : array();

    $contents = explode(",", $contents);
    $stars = explode(",", $stars);
    $isanons = explode(",", $isanons);
    $productnos = explode(",", $productnos);

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);
    $myOrderProduct = new OrderProduct($myMySQL);
    $myUser = new User($myMySQL);
    $myProductComment = new ProductComment($myMySQL);

    if( empty($order_info_no) )
    {
        Output::error('订单不能为空',array(), 1);
    }

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    //获取用户昵称
    $userRow = $myUser->getRow("nickname", "no = $user_no");

    for($i = 0; isset($stars[$i]); $i++)
    {
        $dataArray = array();
        $dataArray['user_no']       = $user_no;
        $dataArray['nickname']      = $userRow['nickname'];
        $dataArray['product_no']    = $productnos[$i];
        $dataArray['order_info_no'] = $order_info_no;
        $dataArray['content']       = $contents[$i] == 'undefined' ? '' : $contents[$i];
        $dataArray['is_anonymity']  = $isanons[$i] == 'undefined' || !$isanons[$i] ? 0 : 1;
        $dataArray['comment_type']  = $stars[$i];
        $dataArray['add_time']      = 'now()';

        $myProductComment->addRow($dataArray);
    }

    //更新订单状态
    $dataArray = array();
    $dataArray['comment_status'] = 1;
    $dataArray["lastmodify"]     = 'now()';

    $myOrderInfo->update($dataArray, "no = $order_info_no");

    Output::succ('提交成功',array());

