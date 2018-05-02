<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    ob_clean();

    // request
    $no    = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;
    $fileList = !empty($_REQUEST["fileList"]) ? trim($_REQUEST["fileList"]) : "" ;

    if ( $no == 0 )
    {
        header("Location: product.php?r=".time());
        exit;
    }
   
    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct= new Product($myMySQL);

     // check no
    $row = $myProduct->get("*", "no = $no");

    if ( !isset($row["no"]) )
    {
        Output::error('无数据',array(), 1);
    }

    unset($_REQUEST["no"]);
    unset($_REQUEST["fileList"]);

    $dataArray = $_REQUEST;
    $dataArray['update_time'] = 'now()';
    $dataArray['shop_price'] = $_REQUEST['shop_price'] * 100;
    $dataArray['market_price'] = $_REQUEST['market_price'] * 100;

    if( !empty($fileList) )
    {
        $dataArray['pic'] = $fileList;
    }


    $myProduct->update($dataArray, "no = ". $no);

    Output::succ('修改成功',array());

?>