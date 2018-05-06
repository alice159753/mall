<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductImg.php");
    include_once(INCLUDE_DIR. "/ProductImgDetail.php");
    ob_clean();

    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $product_weight = !empty($_REQUEST["product_weight"]) ? trim($_REQUEST["product_weight"]) : "0" ;
    $product_weight_ceil = !empty($_REQUEST["product_weight_ceil"]) ? trim($_REQUEST["product_weight_ceil"]) : "kg" ;
    $product_img_detail = !empty($_REQUEST["product_img_detail"]) ? $_REQUEST["product_img_detail"] : array() ;
    $product_img = !empty($_REQUEST["product_img"]) ? $_REQUEST["product_img"]: array() ;
    $postage_price_type = !empty($_REQUEST["postage_price_type"]) ? trim($_REQUEST["postage_price_type"]) : 1;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myProductImg = new ProductImg($myMySQL);
    $myProductImgDetail = new ProductImgDetail($myMySQL);

    unset($_REQUEST["fileList"]);
    unset($_REQUEST['product_weight']);
    unset($_REQUEST['product_weight_ceil']);
    unset($_REQUEST['postage_price_type']);
    unset($_REQUEST['product_img']);
    unset($_REQUEST['product_img_detail']);

    $dataArray = $_REQUEST;
    $dataArray['add_time'] = 'now()';
    $dataArray['pic'] = $fileList;

    if( $product_weight_ceil == 'kg' )
    {
        $dataArray['product_weight_kg'] = $product_weight;
    }

    if( $product_weight_ceil == 'g' )
    {
        $dataArray['product_weight_g'] = $product_weight;
    }

    if( $postage_price_type == 1 )
    {
        $dataArray['postage_no'] = 0;
    }

    if( $postage_price_type == 2 )
    {
        $dataArray['postage_price'] = 0;
    }

    $myProduct->addRow($dataArray);
    $product_no = $myProduct->getInsertID();

    foreach ($product_img_detail as $key => $value) 
    {
        $dataArray = array();
        $dataArray['product_no'] = $product_no;
        $dataArray['img_url'] = $value;
        $dataArray['sort'] = $key+1;
        $dataArray['add_time'] = 'now()';

        $myProductImgDetail->addRow($dataArray);
    }

    foreach ($product_img as $key => $value) 
    {
        $dataArray = array();
        $dataArray['product_no'] = $product_no;
        $dataArray['img_url'] = $value;
        $dataArray['sort'] = $key+1;
        $dataArray['add_time'] = 'now()';

        $myProductImg->addRow($dataArray);
    }

    Output::succ('添加成功！', array());

?>