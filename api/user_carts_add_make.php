<?php
    //添加购物车
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $product_attr_no = !empty($_REQUEST["product_attr_no"]) ? trim($_REQUEST["product_attr_no"]) : "0";
    $buy_num = !empty($_REQUEST["buy_num"]) ? $_REQUEST["buy_num"] : 0;
    $product_no = !empty($_REQUEST["product_no"]) ? $_REQUEST["product_no"] : 0;

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    if( empty($product_no) )
    {
        Output::error('产品no不能为空',array(), 1);
    }

    if( empty($buy_num) )
    {
        Output::error('购买数量不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);

    //检验库存数量是否够
    $productRow = $myProduct->getRow("*", "no = ". $product_no .' AND is_delete = 0 AND is_online = 1');

    if( empty($productRow) )
    {
        Output::error('产品不存在',array(), 1);
    }

    $repertory_num = $productRow['repertory_num'];

    if( !empty($product_attr_no) )
    {
        $productAttrRow = $myProductAttr->getRow("*", "no = $product_attr_no");

        if( empty($productAttrRow) )
        {
            Output::error('产品属性不存在',array(), 1);
        }

        $repertory_num = $productAttrRow['repertory_num'];
    }

    if( $repertory_num < $buy_num )
    {
        Output::error('库存数量不够，请重新选择购买数量',array(), 1);
    }

    //判断是否到预售时间
    $today = date('Y-m-d', strtotime('now'));
    $today = strtotime($today);
    if(  !empty($productRow['sales_start_date']) && $productRow['sales_start_date'] != '0000-00-00' && $today <  strtotime($productRow['sales_start_date']) )
    {
        Output::error('还没有到预售时间哟！',array(), 1);
        exit;
    }

    if(  !empty($productRow['sales_end_date']) && $productRow['sales_end_date'] != '0000-00-00' && $today >  strtotime($productRow['sales_end_date']) )
    {
        Output::error('预售时间已结束！',array(), 1);
        exit;
    }

    //判断改产品是否已经加入购物车
    $userCarsRow = $myUserCarts->getRow("*", "user_no = ".$user_no." AND product_no = $product_no AND is_buy = 0 AND product_attr_no = $product_attr_no");

    if( !empty($userCarsRow) )
    {
        $dataArray = array();
        $dataArray['buy_num'] = $userCarsRow['buy_num'] + $buy_num;

        $myUserCarts->update($dataArray, "no = ". $userCarsRow['no']);
    }
    else
    {
        $dataArray                    = array();
        $dataArray['user_no']         = $user_no;
        $dataArray['product_no']      = $product_no;
        $dataArray['buy_num']         = $buy_num;
        $dataArray['is_buy']          = '0';
        $dataArray['add_time']        = 'now()';
        $dataArray['product_attr_no'] = $product_attr_no;

        $dataArray['product_title']   = $productRow['title'];
        $dataArray['product_pic']     = $productRow['pic'];
        $dataArray['sale_price']      = $productRow['sale_price'];
        $dataArray['lineation_price'] = $productRow['lineation_price'];
        $dataArray['member_price']    = $productRow['member_price'];
        $dataArray['cost_price']      = $productRow['cost_price'];
        $dataArray['product_weight_kg']      = $productRow['product_weight_kg'];
        $dataArray['product_weight_g']      = $productRow['product_weight_g'];

        if( !empty($product_attr_no) )
        {
            $dataArray['product_pic']     = !empty($productAttrRow['pic']) ? $productAttrRow['pic'] : $productRow['pic'];
            $dataArray['sale_price']      = $productAttrRow['sale_price'];
            $dataArray['lineation_price'] = $productAttrRow['lineation_price'];
            $dataArray['member_price']    = $productAttrRow['member_price'];
            $dataArray['cost_price']      = $productAttrRow['cost_price'];
            $dataArray['product_attr_text'] = $productAttrRow['specification_value1']." ".$productAttrRow['specification_value2']." ".$productAttrRow['specification_value3'];

            $dataArray['product_weight_kg']      = $productAttrRow['product_weight_kg'];
            $dataArray['product_weight_g']      = $productAttrRow['product_weight_g'];
        }

        $myUserCarts->addRow($dataArray);
    }
    
    $count = $myUserCarts->getRow("sum(buy_num) as sum_buy_num", "user_no = ".$user_no." AND product_no = $product_no AND is_buy = 0");
    $count = $count['sum_buy_num'];

    Output::succ('添加成功',$count);

?>