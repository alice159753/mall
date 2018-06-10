<?php

    //产品收藏
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Article.php");
    include_once(INCLUDE_DIR. "/UserCollect.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $product_no = !empty($_REQUEST["product_no"]) ? $_REQUEST["product_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($product_no) )
    {
        Output::error('product_no不能为空',array(), 1);
    }

    if( empty($user_no) )
    {
        Output::error('user_no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myUserCollect = new UserCollect($myMySQL);

    //已经收藏则删除
    $result = array();
    $result['is_collect'] = 0;

    $condition = "user_no = $user_no AND collect_no = $product_no AND collect_type = 1";
    if( $myUserCollect->getCount($condition) >= 1 )
    {
        $myUserCollect->remove($condition);

        $result['is_collect'] = 0;
    }
    else
    {
        $dataArray = array();
        $dataArray['user_no']      = $user_no;
        $dataArray['collect_no']   = $product_no;
        $dataArray['collect_type'] = 1;
        $dataArray['add_time']     = 'now()';

        $myUserCollect->addRow($dataArray);

        $result['is_collect'] = 1;
    }

    Output::succ('', $result);
    


?>