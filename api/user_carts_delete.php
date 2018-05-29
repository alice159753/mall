<?php

    //删除购物车
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $user_carts_no = !empty($_REQUEST["user_carts_no"]) ? trim($_REQUEST["user_carts_no"]) : "0";


    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    if( empty($user_carts_no) )
    {
        Output::error('购物车no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);

    $myUserCarts->remove("user_no = $user_no AND no = $user_carts_no");

    Output::succ('删除成功','');

?>