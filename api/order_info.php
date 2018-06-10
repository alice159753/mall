<?php
    //订单列表
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/OrderInfo.php");    
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $order_type = !empty($_REQUEST["order_type"]) ? $_REQUEST["order_type"] : 'all';
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $page_size = !empty($_REQUEST["page_size"]) ? $_REQUEST["page_size"] : 20;

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUser = new User($myMySQL);
    $myOrderInfo = new OrderInfo($myMySQL);
    $myOrderProduct = new OrderProduct($myMySQL);

    //全部
    if( $order_type == 'all' )
    {
        $condition = "user_no = ". $user_no."";
    }

    //待付款
    if( $order_type == 'daifukuan' )
    {
        $condition = "user_no = ".$user_no. " AND pay_status = 0 AND order_status in(0,1) ";
    }

    //待发货
    if( $order_type == 'daifahuo' )
    {
        $condition = "user_no = ".$user_no. " AND pay_status = 2 AND order_status in(0,1) AND shipping_status = 0";
    }

    //待收货
    if( $order_type == 'daishouhuo' )
    {
        $condition = "user_no = ".$user_no. " AND pay_status = 2 AND order_status in(0,1) AND shipping_status = 1";
    }

    //待评价
    if( $order_type == 'daipingjia' )
    {
        $condition = "user_no = ".$user_no. " AND order_status in(0,1) AND pay_status = 2 AND shipping_status = 2 AND comment_status = 0";
    }

    $total_page = $myOrderInfo->getPageCount($page_size, $condition);
    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $orderInfoRows = $myOrderInfo->getPage("*", $page, $page_size, $condition ." ORDER BY no DESC");

    $result = array();

    for($i = 0; isset($orderInfoRows[$i]); $i++)
    {
        $order_no = $orderInfoRows[$i]['no'];

        $dataArray = $myOrderInfo->getDataClean($orderInfoRows[$i]);

        //获取商品信息
        $orderProductRows = $myOrderProduct->getRows("*", "user_no = ". $user_no." AND order_no = $order_no");

        foreach ($orderProductRows as $index => $product) 
        {
            $orderProduct = $myOrderProduct->getDataClean($product);

            $dataArray['product'][] = $orderProduct;
        }

        $result[] = $dataArray;
    }

    Output::succ('', $result);

?>