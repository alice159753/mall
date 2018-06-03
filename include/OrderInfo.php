<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/Product.php");
    include_once(INCLUDE_DIR. "/PostageConfig.php");
    include_once(INCLUDE_DIR. "/OrderProduct.php");
    ob_clean();

	class OrderInfo extends Table
	{
	    function OrderInfo($myMySQL, $table = "order_info")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        //订单的状态;0未确认,1已确认,2已取消,3无效,4退货
        function getOrderStatus()
        {
            return array('0' => '未确认', '1' => '已确认', '2'=>'已取消','3' => '无效', '4' =>'已退货', '5' =>'已分单', '6' =>'申请退款');
        }


        //商品配送情况，0未发货，1已发货，2已收货，4退货
        function getShippingStatus()
        {
            return array('0' => '未发货', '1' => '已发货', '2'=>'已收货','3' =>'配货', '4' =>'退货');
        }

        //支付状态;0未付款;1付款中;2已付款
        function getPayStatus()
        {
            return array('0' => '未付款', '1' => '付款中', '2'=>'已付款', '3' => '已退款');
        }

        //是否评价，0未评价，1已评价
        function getCommentStatus()
        {
            return array('0' => '未评价', '1' => '已评价');
        }

        //获得支付类型
        function getPayType()
        {
            return array('1' => '微信公众号');
        }

        //待付款
        function getDaifukuan()
        {
            $count = $this->getCount("user_no = ".$_SESSION['user_no']. " AND pay_status = 0 AND order_status in(0,1)");

            return $count;
        }

        //待发货
        function getDaifahuo()
        {
            $count = $this->getCount("user_no = ".$_SESSION['user_no']. " AND pay_status = 2 AND order_status in(0,1) AND shipping_status = 0");

            return $count;
        }


        //待收货
        function getDaishouhuo()
        {
            $count = $this->getCount("user_no = ".$_SESSION['user_no']. " AND pay_status = 2 AND order_status in(0,1) AND shipping_status = 1");

            return $count;
        }

        //待评价
        function getDaipinglun()
        {
            $count = $this->getCount("user_no = ".$_SESSION['user_no']. " AND pay_status = 2  AND order_status in(0,1) AND shipping_status = 2 AND comment_status = 0");

            return $count;
        }


        function getData($row)
        {
            $orderStatusMap    = $this->getOrderStatus();
            $shippingStatusMap = $this->getShippingStatus();
            $payStatusMap      = $this->getPayStatus();
            $commentStatusMap  = $this->getCommentStatus();
            $payTypeMap        = $this->getPayType();

            $myUser = new User($this->myMySQL);

            $dataArray = array();
            $dataArray['{no}']                    = $row['no'];
            $dataArray['{postage_config_no}']     = $row['postage_config_no'];
            $dataArray['{order_sn}']              = $row['order_sn'];
            $dataArray['{user_no}']               = $row['user_no'];
            $dataArray['{order_status_title}']    = $orderStatusMap[ $row['order_status'] ];
            $dataArray['{shipping_status_title}'] = $shippingStatusMap[ $row['shipping_status'] ];
            $dataArray['{pay_status_title}']      = $payStatusMap[ $row['pay_status'] ];
            $dataArray['{comment_status_title}']  = $commentStatusMap[ $row['comment_status'] ];
            $dataArray['{pay_type_title}']        = $payTypeMap[ $row['pay_type'] ];
            $dataArray['{order_status}']          = $row['order_status'];
            $dataArray['{shipping_status}']       = $row['shipping_status'];
            $dataArray['{pay_status}']            = $row['pay_status'];
            $dataArray['{comment_status}']        = $row['comment_status'];
            $dataArray['{pay_type}']              = $row['pay_type'];
            $dataArray['{consignee}']             = $row['consignee'];
            $dataArray['{country}']               = $row['country'];
            $dataArray['{province}']              = $row['province'];
            $dataArray['{city}']                  = $row['city'];
            $dataArray['{district}']              = $row['district'];
            $dataArray['{address}']               = $row['address'];
            $dataArray['{zipcode}']               = $row['zipcode'];
            $dataArray['{tel}']                   = $row['tel'];
            $dataArray['{mobile}']                = $row['mobile'];
            $dataArray['{email}']                 = $row['email'];
            $dataArray['{best_time}']             = $row['best_time'];
            $dataArray['{sign_building}']         = $row['sign_building'];
            $dataArray['{postscript}']            = $row['postscript']; //订单附言,由用户提交订单前填写
            $dataArray['{total_fee}']             = $row['total_fee']/100;
            $dataArray['{order_fee}']             = $row['order_fee']/100;
            $dataArray['{shipping_fee}']          = $row['shipping_fee']/100;
            $dataArray['{insure_fee}']            = $row['insure_fee']/100;
            $dataArray['{pay_note}']              = $row['pay_note']; //付款备注, 在订单管理编辑修改
            $dataArray['{to_buyer}']              = $row['to_buyer'];  //商家给客户留言
            $dataArray['{add_time}']              = $row['add_time'];
            $dataArray['{confirm_time}']          = $row['confirm_time'];
            $dataArray['{pay_time}']              = $row['pay_time'];
            $dataArray['{shipping_time}']         = $row['shipping_time'];
            $dataArray['{lastmodify}']            = $row['lastmodify'];
            $dataArray['{channel_id}']            = $row['channel_id'];
            $dataArray['{invoice_no}']            = $row['invoice_no'];
            $dataArray['{sales_return_note}']     = $row['sales_return_note'];
            $dataArray['{pay_content}']           = str_replace(";", ";<br/>", $row['pay_content']);

            $dataArray['{nickname}'] = '';
            if( !empty($row['user_no']) )
            {
                $userRow = $myUser->getRow("*", "no = ". $row['user_no']);
                $dataArray['{nickname}'] = $userRow['nickname'];
            }

            $dataArray['{order_type}'] = '';
            $dataArray['{show_order_status_title}'] = '';

            //待付款
            if( $row['pay_status'] == 0 && ($row['order_status'] == 0 || $row['order_status'] == 1) )
            {
                $dataArray['{order_type}'] = 'daifukuan';
                $dataArray['{show_order_status_title}'] = '等待买家付款';
            }

            //待发货
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status']  == 0 )
            {
                $dataArray['{order_type}'] = 'daifahuo';
                $dataArray['{show_order_status_title}'] = '等待卖家发货';
            }

            //待收货
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 1 )
            {
                $dataArray['{order_type}'] = 'daishouhuo';
                $dataArray['{show_order_status_title}'] = '等待买家收货';
            }

            //待评价
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 2 && $row['comment_status'] == 0 )
            {
                $dataArray['{order_type}'] = 'daipingjia';
                $dataArray['{show_order_status_title}'] = '等待买家评论';
            }

            //已取消
            if( $row['order_status'] == 2 )
            {
                $dataArray['{order_type}'] = 'yiquxiao';
                $dataArray['{show_order_status_title}'] = '已取消';
            }

            //已退货
            if( $row['order_status'] == 4 )
            {
                $dataArray['{order_type}'] = 'yituihuo';
                $dataArray['{show_order_status_title}'] = '已退货';
            }

            //已评价
            if( $row['pay_status'] == 1 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 2 && $row['comment_status'] == 1 )
            {
                $dataArray['{order_type}'] = 'yipingjia';
                $dataArray['{show_order_status_title}'] = '交易成功';
            }

            //申请退款
            if( $row['order_status'] == 6 )
            {
                $dataArray['{order_type}'] = 'shenqingtuikuan';
                $dataArray['{show_order_status_title}'] = '申请退款';
            }

            if( $row['pay_status'] == 3 )
            {
                $dataArray['{order_type}'] = 'yituikuan';
                $dataArray['{show_order_status_title}'] = '已退款';
            }

            return $dataArray;
        }

        function getDataClean($row)
        {
            $orderStatusMap    = $this->getOrderStatus();
            $shippingStatusMap = $this->getShippingStatus();
            $payStatusMap      = $this->getPayStatus();
            $commentStatusMap  = $this->getCommentStatus();
            $payTypeMap        = $this->getPayType();

            $myUser = new User($this->myMySQL);

            $dataArray = array();
            $dataArray['no']                    = $row['no'];
            $dataArray['postage_config_no']     = $row['postage_config_no'];
            $dataArray['order_sn']              = $row['order_sn'];
            $dataArray['user_no']               = $row['user_no'];
            $dataArray['order_status_title']    = $orderStatusMap[ $row['order_status'] ];
            $dataArray['shipping_status_title'] = $shippingStatusMap[ $row['shipping_status'] ];
            $dataArray['pay_status_title']      = $payStatusMap[ $row['pay_status'] ];
            $dataArray['comment_status_title']  = $commentStatusMap[ $row['comment_status'] ];
            $dataArray['pay_type_title']        = $payTypeMap[ $row['pay_type'] ];
            $dataArray['order_status']          = $row['order_status'];
            $dataArray['shipping_status']       = $row['shipping_status'];
            $dataArray['pay_status']            = $row['pay_status'];
            $dataArray['comment_status']        = $row['comment_status'];
            $dataArray['pay_type']              = $row['pay_type'];
            $dataArray['consignee']             = $row['consignee'];
            $dataArray['country']               = $row['country'];
            $dataArray['province']              = $row['province'];
            $dataArray['city']                  = $row['city'];
            $dataArray['district']              = $row['district'];
            $dataArray['address']               = $row['address'];
            $dataArray['zipcode']               = $row['zipcode'];
            $dataArray['tel']                   = $row['tel'];
            $dataArray['mobile']                = $row['mobile'];
            $dataArray['email']                 = $row['email'];
            $dataArray['best_time']             = $row['best_time'];
            $dataArray['sign_building']         = $row['sign_building'];
            $dataArray['postscript']            = $row['postscript']; //订单附言,由用户提交订单前填写
            $dataArray['total_fee']             = $row['total_fee']/100;
            $dataArray['order_fee']             = $row['order_fee']/100;
            $dataArray['shipping_fee']          = $row['shipping_fee']/100;
            $dataArray['insure_fee']            = $row['insure_fee']/100;
            $dataArray['pay_note']              = $row['pay_note']; //付款备注, 在订单管理编辑修改
            $dataArray['to_buyer']              = $row['to_buyer'];  //商家给客户留言
            $dataArray['add_time']              = $row['add_time'];
            $dataArray['confirm_time']          = $row['confirm_time'];
            $dataArray['pay_time']              = $row['pay_time'];
            $dataArray['shipping_time']         = $row['shipping_time'];
            $dataArray['lastmodify']            = $row['lastmodify'];
            $dataArray['channel_id']            = $row['channel_id'];
            $dataArray['invoice_no']            = $row['invoice_no'];
            $dataArray['sales_return_note']     = $row['sales_return_note'];
            $dataArray['pay_content']           = str_replace(";", ";<br/>", $row['pay_content']);

            $dataArray['nickname'] = '';
            if( !empty($row['user_no']) )
            {
                $userRow = $myUser->getRow("*", "no = ". $row['user_no']);
                $dataArray['nickname'] = $userRow['nickname'];
            }

            $dataArray['order_type'] = '';
            $dataArray['show_order_status_title'] = '';

            //待付款
            if( $row['pay_status'] == 0 && ($row['order_status'] == 0 || $row['order_status'] == 1) )
            {
                $dataArray['order_type'] = 'daifukuan';
                $dataArray['show_order_status_title'] = '等待买家付款';
            }

            //待发货
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status']  == 0 )
            {
                $dataArray['order_type'] = 'daifahuo';
                $dataArray['show_order_status_title'] = '等待卖家发货';
            }

            //待收货
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 1 )
            {
                $dataArray['order_type'] = 'daishouhuo';
                $dataArray['show_order_status_title'] = '等待买家收货';
            }

            //待评价
            if( $row['pay_status'] == 2 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 2 && $row['comment_status'] == 0 )
            {
                $dataArray['order_type'] = 'daipingjia';
                $dataArray['show_order_status_title'] = '等待买家评论';
            }

            //已取消
            if( $row['order_status'] == 2 )
            {
                $dataArray['order_type'] = 'yiquxiao';
                $dataArray['show_order_status_title'] = '已取消';
            }

            //已退货
            if( $row['order_status'] == 4 )
            {
                $dataArray['order_type'] = 'yituihuo';
                $dataArray['show_order_status_title'] = '已退货';
            }

            //已评价
            if( $row['pay_status'] == 1 && ($row['order_status'] == 1 || $row['order_status'] == 0 ) && $row['shipping_status'] == 2 && $row['comment_status'] == 1 )
            {
                $dataArray['order_type'] = 'yipingjia';
                $dataArray['show_order_status_title'] = '交易成功';
            }

            //申请退款
            if( $row['order_status'] == 6 )
            {
                $dataArray['order_type'] = 'shenqingtuikuan';
                $dataArray['show_order_status_title'] = '申请退款';
            }

            if( $row['pay_status'] == 3 )
            {
                $dataArray['order_type'] = 'yituikuan';
                $dataArray['show_order_status_title'] = '已退款';
            }

            return $dataArray;
        }

        //计算商品价格
        function orderFee($userCartsRows)
        {
            $myProduct = new Product($this->myMySQL);
            $myProductAttr = new ProductAttr($this->myMySQL);

            $product_fee = 0;
            for($i = 0; isset($userCartsRows[$i]); $i++)
            {
                $product_no = $userCartsRows[$i]['product_no'];
                $productRow = $myProduct->getRow("*", "no = $product_no");

                if( !empty($userCartsRows[$i]['product_attr_no']) )
                {
                    $productAttrRow = $myProductAttr->getRow("*", "no = ". $userCartsRows[$i]['product_attr_no']);

                    $productRow['sale_price'] = $productAttrRow['sale_price'];
                }

                $product_fee += $userCartsRows[$i]['buy_num'] * $productRow['sale_price'];
            }

            return $product_fee;
        }


        //商品运费
        function orderCarriageFee($userCartsRows, $userAddressRow)
        {
            $myProduct = new Product($this->myMySQL);
            $myPostageConfig = new PostageConfig($this->myMySQL);
            $myProductAttr = new ProductAttr($this->myMySQL);

            //获取默认地址配置
            $defaultPostageConfig = $myPostageConfig->getRow("*", "no = 1");

            $province = isset($userAddressRow['province']) ? $userAddressRow['province'] : '';
            $province = str_replace('省', "", $province);

            $city = isset($userAddressRow['city']) ? $userAddressRow['city'] : '';
            $city = str_replace('市', "", $city);

            $district = isset($userAddressRow['district']) ? $userAddressRow['district'] : '';
            $district = str_replace('区', "", $district);

            $postageConfig = array();
            if( !empty($province) )
            {
                $condition = "province like '%$province%'";

                $rows = $myPostageConfig->getRows("*", $condition);
                for($i = 0; isset($rows[$i]); $i++)
                {
                    //如果市和区为空，则满足要求
                    if( empty($rows[$i]['city']) && empty($rows[$i]['district']) )
                    {
                        $postageConfig = $rows[$i];
                    }

                    //判断市
                    if( !empty($rows[$i]['city']) && empty($rows[$i]['district']) )
                    {
                        if( strstr($rows[$i]['city'], $city) )
                        {
                            $postageConfig = $rows[$i];
                        }
                    }

                    //判断区
                    if( !empty($rows[$i]['city']) && !empty($rows[$i]['district']) )
                    {
                        if( strstr($rows[$i]['city'], $city) && strstr($rows[$i]['district'], $district) )
                        {
                            $postageConfig = $rows[$i];
                        }
                    }
                }
            }

            $finalConfig = $defaultPostageConfig;
            if( !empty($postageConfig) )
            {
                $finalConfig = $postageConfig;
            }

            $result = array();
            $result['postage_config_no'] = $finalConfig['no'];

            $fee = 0;
            $goods_weight = 0;
            for($i = 0; isset($userCartsRows[$i]); $i++)
            {
                $product_no = $userCartsRows[$i]['product_no'];
                $productRow = $myProduct->getRow("*", "no = $product_no");

                //判断这个商品是否免邮费
                if( $productRow['is_shipping'] == 'Y' )
                {
                    continue; 
                }

                //省内包邮，省外不包邮
                if( $province == '四川' )
                {
                    if( !empty($productRow['buy_num_shipping']) && $productRow['buy_num_shipping'] < $userCartsRows[$i]['buy_num'] )
                    {
                        continue;
                    }
                }

                if( !empty($userCartsRows[$i]['product_attr_no']) )
                {
                    $productAttrRow = $myProductAttr->getRow("*", "no = ". $userCartsRows[$i]['product_attr_no']);

                    $productRow['goods_weight'] = $productAttrRow['product_weight'];
                }

                $goods_weight += $productRow['goods_weight'] * $userCartsRows[$i]['buy_num']; //千克 
            }

            //判断是否超过20kg
            if( $goods_weight > 20 )
            {
                $h = ceil($goods_weight / 20);

                $fee = $h * $finalConfig['first_price'];

                $fee += ($h - 1) * (20 - $finalConfig['first_weight']) / $finalConfig['continue_weight'] * $finalConfig['continue_price'];

                $fee += ($goods_weight % 20 - $finalConfig['first_weight']) / $finalConfig['continue_weight'] * $finalConfig['continue_price'];
            }
            else if( $goods_weight == 0 )
            {
                $fee = 0;
            }
            else
            {
                $fee += $finalConfig['first_price'];

                if( $goods_weight > $finalConfig['first_weight'] )
                {
                    $weight = ($goods_weight - $finalConfig['first_weight'])  / $finalConfig['continue_weight'];

                    $fee += $weight * $finalConfig['continue_price'];
                }
            }


            if( $fee == 0 )
            {
                $result['postage_config_no'] = 0;
            }

            $result['carriage_fee'] = $fee;

            return $result;
        }

        function createOrder($user_no, $userAddressRow, $userCartsRows, $product_fee, $carriageFee, $postscript, $pay_type = 1)
        {
            $order_sn = date('YmdHis').rand(10000, 99999);

            $myUser = new User($this->myMySQL);
            $myOrderProduct = new OrderProduct($this->myMySQL);
            $myProduct = new Product($this->myMySQL);
            $myProductAttr = new ProductAttr($this->myMySQL);

            $userRow = $myUser->getRow("*", "no = $user_no");

            $dataArray                      = array();
            $dataArray['postage_config_no'] = $carriageFee['postage_config_no'];
            $dataArray['order_sn']          = $order_sn;
            $dataArray['user_no']           = $user_no;
            $dataArray['order_status']      = 0;
            $dataArray['shipping_status']   = 0;
            $dataArray['pay_status']        = 0;
            $dataArray['comment_status']    = 0;
            $dataArray['pay_type']          = $pay_type;
            $dataArray['consignee']         = $userAddressRow['consignee'];
            $dataArray['country']           = $userAddressRow['country'];
            $dataArray['province']          = $userAddressRow['province'];
            $dataArray['city']              = $userAddressRow['city'];
            $dataArray['district']          = $userAddressRow['district'];
            $dataArray['address']           = $userAddressRow['address'];
            $dataArray['mobile']            = $userAddressRow['mobile'];
            $dataArray['postscript']        = $postscript;
            $dataArray['total_fee']         = $product_fee + $carriageFee['carriage_fee'];
            $dataArray['order_fee']         = $product_fee;
            $dataArray['shipping_fee']      = $carriageFee['carriage_fee'];
            $dataArray['channel_id']        = $userRow['channel_id'];
            $dataArray['add_time']          = 'now()';

            $this->addRow($dataArray);
            $insert_id = $this->getInsertID();

            //添加商品信息
            for($i = 0; isset($userCartsRows[$i]); $i++)
            {
                $product_no = $userCartsRows[$i]['product_no'];
                $productRow = $myProduct->getRow("*", "no = $product_no");

                $dataArray = array();
                $dataArray['user_no']         = $user_no;
                $dataArray['order_no']        = $insert_id;
                $dataArray['order_sn']        = $order_sn;
                $dataArray['product_no']      = $product_no;
                $dataArray['product_title']   = $productRow['title'];
                $dataArray['product_pic']     = $productRow['pic'];
                $dataArray['shop_price']      = $productRow['shop_price'];
                $dataArray['market_price']    = $productRow['market_price'];
                $dataArray['product_weight']  = $productRow['goods_weight'];
                $dataArray['buy_num']         = $userCartsRows[$i]['buy_num'];
                $dataArray['add_time']        = 'now()';
                $dataArray['channel_id']      = $userRow['channel_id'];
                $dataArray['product_attr_no'] = $userCartsRows[$i]['product_attr_no'];

                if( !empty($dataArray['product_attr_no']) )
                {
                    $productAttrRow = $myProductAttr->getRow("*", "no = ". $dataArray['product_attr_no']);

                    $dataArray['product_title']   = $productRow['title'].", 规格：".$productAttrRow['title'];
                    $dataArray['product_pic']     = $productAttrRow['img_url'];
                    $dataArray['shop_price']      = $productAttrRow['price'];
                    $dataArray['product_weight']  = $productAttrRow['product_weight'];
                }

                $myOrderProduct->addRow($dataArray);
            }

            return $insert_id;
        }

}

?>