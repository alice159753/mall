<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/Category.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    include_once(INCLUDE_DIR. "/ProductImg.php");
    include_once(INCLUDE_DIR. "/ProductImgDetail.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    if ( $no == 0 )
    {
        header("Location: product.php?r=".time());
        exit;
    }
   
    $myTemplate = new Template(TEMPLATE_DIR ."/product_modify.html");
    
    include_once("common.inc.php");

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myCategory = new Category($myMySQL);
    $myBrand = new Brand($myMySQL);
    $myPostageConfig = new PostageConfig($myMySQL);
    $myProductImg = new ProductImg($myMySQL);
    $myProductImgDetail = new ProductImgDetail($myMySQL);

    $row = $myProduct->get("*", "no = $no");
    
    $dataArray = $myProduct->getData($row);

    $myTemplate->setReplace("data", $dataArray);

    //商品图
    $rows = $myProductImg->getRows("*", "product_no = $no order by sort asc");
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProductImg->getData($rows[$i]);

        $myTemplate->setReplace("product_img", $dataArray, 2);
    }

    //商品详情图
    $rows = $myProductImgDetail->getRows("*", "product_no = $no order by sort asc");
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProductImgDetail->getData($rows[$i]);

        $myTemplate->setReplace("product_img_detail", $dataArray, 2);
    }



    //获得一级分类
    $rows = $myCategory->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myCategory->getData($rows[$i]);

        $myTemplate->setReplace("category", $dataArray, 2);
    }

    //获得商品品牌
    $rows = $myBrand->getRows("*", "1=1 ORDER BY sort ASC");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myBrand->getData($rows[$i]);

        $myTemplate->setReplace("brand", $dataArray, 2);
    }

    //获得运费模版
    $rows = $myPostageConfig->getRows("*", "1=1");

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myPostageConfig->getData($rows[$i]);

        $myTemplate->setReplace("postage_config", $dataArray, 2);
    }

    $myTemplate->process();
    $myTemplate->output();
?>