<?php

    //用户足迹
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserFootPrint.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : 'no desc';  //综合将序
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $page_size = !empty($_REQUEST["page_size"]) ? $_REQUEST["page_size"] : 2;

    if( empty($user_no) )
    {
        Output::error('用户no不能为空',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myProduct = new Product($myMySQL);
    $myUserFootPrint = new UserFootPrint($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);

    $condition = "user_no = $user_no";

    $total_page = $myUserFootPrint->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $default_field = "*";
    $rows = $myUserFootPrint->getPage($default_field, $page, $page_size, $condition ." ORDER BY $order");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserFootPrint->getDataClean($rows[$i]);
        
        $productRow = $myProduct->getRow("*", "no = ". $rows[$i]['product_no']);

        $dataArray['product'] = $myProduct->getDataClean($productRow);

        $result[] = $dataArray;
    }

    Output::succ('', $result);
    

?>