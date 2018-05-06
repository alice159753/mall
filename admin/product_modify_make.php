<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/ProductImg.php");
    include_once(INCLUDE_DIR. "/ProductImgDetail.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $product_weight = !empty($_REQUEST["product_weight"]) ? trim($_REQUEST["product_weight"]) : "0" ;
    $product_weight_ceil = !empty($_REQUEST["product_weight_ceil"]) ? trim($_REQUEST["product_weight_ceil"]) : "kg" ;
    $product_img_detail = !empty($_REQUEST["product_img_detail"]) ? $_REQUEST["product_img_detail"] : array() ;
    $product_img = !empty($_REQUEST["product_img"]) ? $_REQUEST["product_img"] : array() ;
    $postage_price_type = !empty($_REQUEST["postage_price_type"]) ? trim($_REQUEST["postage_price_type"]) : 1;


    if ( $no == 0 )
    {
        header("Location: product.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myProductImg = new ProductImg($myMySQL);
    $myProductImgDetail = new ProductImgDetail($myMySQL);

     // check no
    $row = $myProduct->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    unset($_REQUEST["no"]);
    unset($_REQUEST["fileList"]);
    unset($_REQUEST['product_weight']);
    unset($_REQUEST['product_weight_ceil']);
    unset($_REQUEST['postage_price_type']);
    unset($_REQUEST['product_img']);
    unset($_REQUEST['product_img_detail']);


    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

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

    $myProduct->update($dataArray, "no = ". $no);


    $myProductImg->remove("product_no = $no");
    $myProductImgDetail->remove("product_no = $no");

    foreach ($product_img_detail as $key => $value) 
    {
        $dataArray = array();
        $dataArray['product_no'] = $no;
        $dataArray['img_url'] = $value;
        $dataArray['sort'] = $key+1;
        $dataArray['add_time'] = 'now()';

        $myProductImgDetail->addRow($dataArray);
    }

    foreach ($product_img as $key => $value) 
    {
        $dataArray = array();
        $dataArray['product_no'] = $no;
        $dataArray['img_url'] = $value;
        $dataArray['sort'] = $key+1;
        $dataArray['add_time'] = 'now()';

        $myProductImg->addRow($dataArray);
    }

    Output::succ('修改成功',array());

?>