<?php

    //用户收藏
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCollect.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    include_once(INCLUDE_DIR. "/Article.php");
    ob_clean();

    $user_no = !empty($_REQUEST["user_no"]) ? trim($_REQUEST["user_no"]) : "0";
    $collect_type = !empty($_REQUEST["collect_type"]) ? trim($_REQUEST["collect_type"]) : "1";
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
    $myUserCollect = new UserCollect($myMySQL);
    $myProductAttr = new ProductAttr($myMySQL);
    $myArticle = new Article($myMySQL);

    $condition = "user_no = $user_no AND collect_type = $collect_type";

    $total_page = $myUserCollect->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;

    if( $page > $total_page )
    {
        Output::succ('', array());
    }

    $default_field = "*";
    $rows = $myUserCollect->getPage($default_field, $page, $page_size, $condition ." ORDER BY $order");

    $result = array();
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myUserCollect->getDataClean($rows[$i]);
        
        if( $collect_type == 1 )
        {
            $productRow = $myProduct->getRow("*", "no = ". $rows[$i]['collect_no']);
            $dataArray['product'] = $myProduct->getDataClean($productRow);
        }

        if( $collect_type == 2 )
        {
            $articleRow = $myArticle->getRow("*", "no = ". $rows[$i]['collect_no']);
            $dataArray['article'] = $myArticle->getDataClean($articleRow);
        }
        
        $result[] = $dataArray;
    }

    Output::succ('', $result);
    

?>