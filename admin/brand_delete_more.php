<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    $no_list = isset($_REQUEST["no_list"]) ? $_REQUEST["no_list"] : 0;

    if( empty($no_list) )
    {
        Output::error('无数据！',array(), 1);
        exit;
    }

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myBrand = new Brand($myMySQL);
    $myProduct = new Product($myMySQL);

    $noList = explode(",", $no_list);

    for($i = 0; isset($noList[$i]); $i++)
    {
        if( empty($noList[$i]) )
        {
            continue;
        }

        if( $myProduct->getCount("brand_no = ".$noList[$i]) >= 1 )
        {
            Output::error('该品牌下面有商品不能删除',array(), 1);
        }

        $myBrand->remove("no = ". $noList[$i]);
    }

    Output::succ('删除成功！',array());

?>