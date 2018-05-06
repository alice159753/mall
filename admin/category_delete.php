<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Category.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $_REQUEST["no"] == 0 )
    {
        Output::error('无数据！',array(), 1);
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myCategory = new Category($myMySQL);
    $myProduct = new Product($myMySQL);

    if( $myProduct->getCount("category_no_1 = $no OR category_no_2 = $no") >= 1 )
    {
        Output::error('该分类下面有商品不能删除',array(), 1);
    }

    $myCategory->remove("no = ". $no);

    Output::succ('删除成功！',array());

?>