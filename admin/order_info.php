<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/OrderInfo.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $add_time_min = !empty($_REQUEST["add_time_min"]) ? $_REQUEST["add_time_min"] : "";
    $add_time_max = !empty($_REQUEST["add_time_max"]) ? $_REQUEST["add_time_max"] : "";
    $channel_id = !empty($_REQUEST["channel_id"]) ? $_REQUEST["channel_id"] : "";
    $order_sn = !empty($_REQUEST["order_sn"]) ? $_REQUEST["order_sn"] : "";
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : "";
    $consignee = !empty($_REQUEST["consignee"]) ? $_REQUEST["consignee"] : "";
    $mobile = !empty($_REQUEST["mobile"]) ? $_REQUEST["mobile"] : "";
    $order_status = isset($_REQUEST["order_status"]) ? $_REQUEST["order_status"] : "";
    $shipping_status = isset($_REQUEST["shipping_status"]) ? $_REQUEST["shipping_status"] : "";
    $pay_status = isset($_REQUEST["pay_status"]) ? $_REQUEST["pay_status"] : "";
    $comment_status = isset($_REQUEST["comment_status"]) ? $_REQUEST["comment_status"] : "";
    $pay_type = isset($_REQUEST["pay_type"]) ? $_REQUEST["pay_type"] : "";


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myOrderInfo = new OrderInfo($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/order_info.html");

    include_once("common.inc.php");

    // search
    $searchArray = array( "{order}" => $order );

    $searchArray['{add_time_max}']    = $add_time_max;
    $searchArray['{add_time_min}']    = $add_time_min;
    $searchArray['{channel_id}']      = $channel_id;
    $searchArray['{order_sn}']        = $order_sn;
    $searchArray['{user_no}']         = $user_no;
    $searchArray['{consignee}']       = $consignee;
    $searchArray['{mobile}']          = $mobile;
    $searchArray['{order_status}']    = $order_status;
    $searchArray['{shipping_status}'] = $shipping_status;
    $searchArray['{pay_status}']      = $pay_status;
    $searchArray['{comment_status}']  = $comment_status;
    $searchArray['{pay_type}']        = $pay_type;

    $myTemplate->setReplace("search", $searchArray);

    $condition = " 1=1 ";

    if( !empty($add_time_min) )
    {
        $condition .= " AND add_time >= '$add_time_min'";
    }

    if( !empty($add_time_max) )
    {
        $condition .= " AND add_time <= '$add_time_max 23:59:59'";
    }

    if( !empty($channel_id) )
    {
        $condition .= " AND channel_id = '$channel_id'";
    }

    if( !empty($order_sn) )
    {
        $condition .= " AND order_sn = '$order_sn'";
    }

    if( !empty($user_no) )
    {
        $condition .= " AND user_no = $user_no";
    }

    if( !empty($consignee) )
    {
        $condition .= " AND consignee like '%$consignee%' ";
    }

    if( !empty($mobile) )
    {
        $condition .= " AND mobile = '$mobile' ";
    }

    if( is_numeric($order_status) )
    {
        $condition .= " AND order_status = $order_status ";
    }

    if( is_numeric($shipping_status) )
    {
        $condition .= " AND shipping_status = $shipping_status ";
    }

    if( is_numeric($pay_status) )
    {
        $condition .= " AND pay_status = $pay_status ";
    }

    if( is_numeric($comment_status) )
    {
        $condition .= " AND comment_status = $comment_status ";
    }

    if( is_numeric($pay_type) )
    {
        $condition .= " AND pay_type = $pay_type ";
    }


    // page
    $page_size = 50;

    $total_count = $myOrderInfo->getCount($condition);
    $total_page = $myOrderInfo->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $myOrderInfo->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myOrderInfo->getData($rows[$i]);

        unset($_REQUEST['no']);
        $dataArray["{get}"] = isset($_REQUEST) ? http_build_query($_REQUEST) : "";

        $myTemplate->setReplace("list", $dataArray);
    }

    // page list
    $previous_page = $page - 1 < 1 ? 1 : $page - 1;
    $next_page = $page + 1 > $total_page ? $total_page : $page + 1;

    unset($_REQUEST["page"]);

    $dataArray = array( "{get}"           => isset($_REQUEST) ? http_build_query($_REQUEST) : "",
                        "{total_count}"   => $total_count,
                        "{total_page}"    => $total_page,
                        "{page}"          => $page,
                        "{previous_page}" => $previous_page,
                        "{next_page}"     => $next_page,
                        "{last_page}"     => $total_page );

    $myTemplate->setReplace("page_list", $dataArray);

    for($i = 4; $i > 0; $i--)
    {
        if ( $page - $i >= 1 )
        {
            $myTemplate->setReplace("previous", array("{previous}" => $page - $i), 2);
        }
    }

    for($i = 1; $i <= 4; $i++)
    {
        if ( $page + $i <= $total_page )
        {
            $myTemplate->setReplace("next", array("{next}" => $page + $i), 2);
        }
    }

    $myTemplate->process();
    $myTemplate->output();

?>