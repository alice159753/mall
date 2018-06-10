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
    include_once(INCLUDE_DIR. "/ProductAttr.php");
    include_once(INCLUDE_DIR. "/UserCarts.php");
    include_once(INCLUDE_DIR. "/UserFootPrint.php");
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
    $myProductAttr = new ProductAttr($myMySQL);
    $myUserCarts = new UserCarts($myMySQL);
    $myUserFootPrint = new UserFootPrint($myMySQL);


    $product_no = !empty($_REQUEST["product_no"]) ? $_REQUEST["product_no"] : 0;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;

    if( empty($product_no) )
    {
        Output::error('该宝贝不存在', '1');

    }

    $condition = "no = $product_no AND is_online = 1 AND is_delete = 0";
    
    $row = $myProduct->getRow("*", $condition);

    if( empty($row) )
    {
        Output::error('该宝贝已经下线', '2');
    }

    $result = $myProduct->getDataClean($row);

    $result['sales_num'] = ceil($result['sales_num']/10000); //展示单位为万

    if( !empty($user_no) && $user_no != 'undefined' )
    {
        $userCollectRow = $myUserCollect->getRow("*","user_no = ".$user_no." AND collect_no = $product_no AND collect_type = 1");
    }

    //判断是否收藏
    $result['is_collect'] = empty($userCollectRow) ? 0 : 1;

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


    //获取商品规格
    $rows = $myProductAttr->getRows("*", "product_no = $product_no");
    $productAttrMap1 = array();
    $productAttrMap2 = array();
    $productAttrMap3 = array();

    //获取最低的价格和最高的价格
    $price_min = 999999999999;
    $price_max = 0;

    for($i = 0; isset($rows[$i]); $i++)
    {
        $sale_price = $rows[$i]['sale_price'];

        if( $sale_price > $price_max )
        {
            $price_max = $sale_price;
        }

        if( $sale_price < $price_min )
        {
            $price_min = $sale_price;
        }

        $specification_no1 = $rows[$i]['specification_no1'];
        $specification_title1 = $rows[$i]['specification_title1'];
        $specification_value1 = $rows[$i]['specification_value1'];

        $productAttrMap1['no'] = $specification_no1;
        $productAttrMap1['title'] = $specification_title1;
        $productAttrMap1['value'][ $specification_value1 ] = $specification_value1;

        $specification_no2 = $rows[$i]['specification_no2'];
        $specification_title2 = $rows[$i]['specification_title2'];
        $specification_value2 = $rows[$i]['specification_value2'];

        if( !empty($specification_no2) )
        {
            $productAttrMap2['no'] = $specification_no2;
            $productAttrMap2['title'] = $specification_title2;
            $productAttrMap2['value'][ $specification_value2 ] = $specification_value2;
        }

        $specification_no3 = $rows[$i]['specification_no3'];
        $specification_title3 = $rows[$i]['specification_title3'];
        $specification_value3 = $rows[$i]['specification_value3'];

        if( !empty($specification_no3) )
        {
            $productAttrMap3['no'] = $specification_no3;
            $productAttrMap3['title'] = $specification_title3;
            $productAttrMap3['value'][ $specification_value3 ] = $specification_value3;
        }

        $rows[$i] = $myProductAttr->getDataClean($rows[$i]);
    }

    $result['product_attr']['title1'] = $productAttrMap1;
    $result['product_attr']['title2'] = $productAttrMap2;
    $result['product_attr']['title3'] = $productAttrMap3;

    $result['product_attr']['lists'] = $rows;

    $result['product_specification_pic'] = $result['pic'];
    $result['product_specification_title'] = $result['title'];
    $result['product_specification_price'] = $price_min."-".$price_max;

    //如果规格为空
    if( empty($rows) )
    {
        $result['product_specification_price'] = $result['sale_price'];
    }

    $result['product_specification_repertory_num'] = $result['repertory_num'];

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
    if( !empty($row['category_no_1']) )
    {
        $condition = "is_online = 1 and category_no_1 = ".$row['category_no_1']." ORDER BY rand() DESC LIMIT 6";
    }
    else
    {
        $condition = "is_online = 1 ORDER BY rand() DESC LIMIT 6";
    }
    
    $rows = $myProduct->getRows("*",  $condition);

    for($i = 0; isset($rows[$i]); $i++)
    {
        $dataArray = $myProduct->getDataClean($rows[$i]);

        $result['likeLists'][] = $dataArray;
    }

    //获取用户购物车数量
    if( !empty($user_no) )
    {
        $count = $myUserCarts->getRow("sum(buy_num) as sum_buy_num", "user_no = ".$user_no." AND product_no = $product_no");
        $result['user_carts_num'] = $count['sum_buy_num'];
    }


    //用户足迹
    $count = $myUserFootPrint->getCount("user_no = $user_no AND product_no = $product_no");
    if( $count <= 0 )
    {
        $dataArray = array();
        $dataArray['user_no'] = $user_no;
        $dataArray['product_no'] = $product_no;
        $dataArray['add_time'] = 'now()';

        $myUserFootPrint->addRow($dataArray);
    }

    Output::succ('', $result);
    


?>