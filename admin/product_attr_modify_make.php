<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    include_once(INCLUDE_DIR. "/Specification.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;
    $specification_no = !empty($_REQUEST["specification_no"]) ? trim($_REQUEST["specification_no"]) : "0" ;
    $product_weight = !empty($_REQUEST["product_weight"]) ? trim($_REQUEST["product_weight"]) : "0" ;
    $product_weight_ceil = !empty($_REQUEST["product_weight_ceil"]) ? trim($_REQUEST["product_weight_ceil"]) : "" ;

    if ( $no == 0 )
    {
        header("Location: product_attr.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProductAttr = new ProductAttr($myMySQL);
    $mySpecification = new Specification($myMySQL);

     // check no
    $row = $myProductAttr->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    unset($_REQUEST["no"]);
    unset($_REQUEST["fileList"]);
    unset($_REQUEST['product_weight']);
    unset($_REQUEST['product_weight_ceil']);

    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';

    $specification_title = $mySpecification->getValue("title", "no = $specification_no");
    $dataArray['specification_title'] = $specification_title;

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }

    if( $product_weight_ceil == 'kg' )
    {
        $dataArray['product_weight_kg'] = $product_weight;
        $dataArray['product_weight_g'] = 0;
    }

    if( $product_weight_ceil == 'g' )
    {
        $dataArray['product_weight_kg'] = 0;
        $dataArray['product_weight_g'] = $product_weight;
    }

    $myProductAttr->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>