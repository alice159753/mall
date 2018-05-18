<?php

    //商品详情
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

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myProduct = new Product($myMySQL);
    $myUserCollect = new UserCollect($myMySQL);
    $myProductImg = new ProductImg($myMySQL);
    $myProductImgDetail = new ProductImgDetail($myMySQL);
    $myBrand = new Brand($myMySQL);
    $myPostageConfig = new PostageConfig($myMySQL);
    $myCategory = new Category($myMySQL);


    $product_no = !empty($_REQUEST["product_no"]) ? $_REQUEST["product_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($product_no) )
    {
        Output::error('1', '该宝贝不存在');

    }

    $condition = "no = $product_no AND is_online = 1";
    
    $row = $myProduct->getRow("*", $condition);

    if( empty($row) )
    {
        Output::error('1', '该宝贝已经下线');
    }

    $result = $myProduct->getDataClean($row);

    $result['sales_num'] = ceil($result['sales_num']/10000); //展示单位为万

    if( !empty($user_no) )
    {
        $userCollectRow = $myUserCollect->getRow("*","user_no = ".$user_no." AND product_no = $product_no");
    }

    //判断是否收藏
    $result['is_collect'] = empty($userCollectRow) ? 'N' : 'Y';


    //商品图
    $rows = $myProductImg->getRows("*", "product_no = $product_no order by sort asc");
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProductImg->getDataClean($rows[$i]);

        $result['product_img'][] = $dataArray;
    }

    //商品详情图
    $rows = $myProductImgDetail->getRows("*", "product_no = $product_no order by sort asc");
    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProductImgDetail->getDataClean($rows[$i]);

        $result['product_img_detail'][] = $dataArray;
    }

    //获得商品品牌
    // $row = $myBrand->getRow("*", "no = ". $row['brand_no']);
    // $result['brand'] = $myBrand->getDataClean($rows[$i]);


    //邮费
    if( !empty($row['postage_no']) )
    {
        $row = $myPostageConfig->getRow("*", "no = ". $row['postage_no']);
        $result['postage_config'] = $myPostageConfig->getDataClean($rows[$i]);

        $result['postage_config']['postage_price'] = $row['first_price'];
    }
    else
    {
        $result['postage_config']['postage_price'] = $row['postage_price'];
    }

    //标签
    $labelList = explode(",", $row['label']);

    for($i = 0; isset($labelList[$i]); $i++)
    {
        if( empty($labelList[$i]) )
        {
            continue;
        }

        $dataArray = array(); 
        $dataArray['label'] = $labelList[$i];
        $dataArray['color'] = 'color'.($i+1);

        $result['labelLists'][] = $dataArray;
    }


    //like
    $condition = "is_online = 1 and category_no_1 = ".$row['category_no_1']." ORDER BY rand() DESC LIMIT 6";
    
    $rows = $myProduct->getRows("*",  $condition);

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProduct->getDataClean($rows[$i]);

        $result['likeLists'][] = $dataArray;
    }

    Output::succ('', $result);
    


?>