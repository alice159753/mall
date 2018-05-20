<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/UserCollect.php");
    include_once(INCLUDE_DIR. "/ProductImg.php");
    include_once(INCLUDE_DIR. "/ProductImgDetail.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    ob_clean();

    $myProduct = new Product($myMySQL);

    $category_no_1 = !empty($_REQUEST["category_no_1"]) ? $_REQUEST["category_no_1"] : 0;  //一级分类
    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : 'sale_num desc';  //综合将序
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $page_size = !empty($_REQUEST["page_size"]) ? $_REQUEST["page_size"] : 20;

    $condition = "is_online = 1 AND is_delete = 0";

    if( !empty($category_no_1) )
    {
        $condition .= " AND category_no_1 = $category_no_1";
    }

    $total_page = $myProduct->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $default_field = "*";
    $rows = $myProduct->getPage($default_field, $page, $page_size, $condition ." ORDER BY $order");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProduct->getDataClean($rows[$i]);
        
        $result[] = $dataArray;
    }

    Output::succ('', $result);
    


?>