<?php

    //购物车列表
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);

    $rows = $myUserCarts->getRows("*", "user_no = ".$user_no." AND is_display = 1");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserCarts->getDataClean($rows[$i]);

        //检验库存数量是否够
        $productRow = $myProduct->getRow("*", "no = ". $rows[$i]['product_no'] .' AND is_delete = 0 AND is_online = 1');

        if( empty($productRow) )
        {
            continue;
        }

        $repertory_num = $productRow['repertory_num'];

        //获得这个商品的库存
        if( !empty($rows[$i]['product_attr_no']) )
        {
            $productAttrRow = $myProductAttr->getRow("*", "no = ".$rows[$i]['product_attr_no']);

            if( empty($productAttrRow) )
            {
                continue;
            }

            $repertory_num = $productAttrRow['repertory_num'];
        }

        $dataArray['repertory_num'] = $repertory_num;

        $result[] = $dataArray;
    }

    Output::succ('',$result);

?>