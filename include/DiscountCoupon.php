<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/DiscountCouponRecord.php");
    ob_clean();

	class DiscountCoupon extends Table
	{
	    function DiscountCoupon($myMySQL, $table = "discount_coupon")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getCouponType()
        {
            return array('1' => '指定金额', '2' => '折扣');
        }

        function getUseType()
        {
            return array('1' => '无限制', '2' => '满$$元可使用');
        }

        function getDateType()
        {
            return array('1' => '固定日期: start~end', '2' => '领到券当日开始$$天内有效', '3' => '领到券次日开始$$天有效');
        }

        function getUseProductType()
        {
            return array('1' => '全店商品', '2' => '指定商品');
        }

        function getData($row)
        {

            $couponTypeMap = $this->getCouponType();
            $useTypeMap = $this->getUseType();
            $dateTypeMap = $this->getDateType();
            $useProductTypeMap = $this->getUseProductType();

            $dataArray = array();
            $dataArray['{no}']                 = $row['no'];
            $dataArray['{title}']              = $row['title'];
            $dataArray['{send_num}']           = $row['send_num'];
            $dataArray['{coupon_type}']        = $row['coupon_type'];
            $dataArray['{coupon_price}']       = $row['coupon_price'];
            $dataArray['{discount}']           = $row['discount'];
            $dataArray['{use_type}']           = $row['use_type'];
            $dataArray['{full_price}']         = $row['full_price'];
            $dataArray['{limit_num}']          = $row['limit_num'];
            $dataArray['{limit_num_title}']    = $row['limit_num'] == 0 ? '不限张': $row['limit_num'];
            $dataArray['{user_label_no}']      = $row['user_label_no'];
            $dataArray['{date_type}']          = $row['date_type'];
            $dataArray['{start_date}']         = $row['start_date'];
            $dataArray['{end_date}']           = $row['end_date'];
            $dataArray['{valid_day_today}']    = $row['valid_day_today'];
            $dataArray['{valid_day_tomorrow}'] = $row['valid_day_tomorrow'];
            $dataArray['{use_product_type}']   = $row['use_product_type'];
            $dataArray['{product_no}']         = $row['product_no'];
            $dataArray['{note}']               = $row['note'];
            $dataArray['{add_time}']           = $row['add_time'];
            $dataArray['{update_time}']        = $row['update_time'];
            $dataArray['{get_num}']            = $row['get_num'];
            $dataArray['{use_num}']            = $row['use_num'];

            $dataArray['{coupon_type_title}']      = $couponTypeMap[ $row['coupon_type'] ];
            $dataArray['{use_type_title}']         = $useTypeMap[ $row['use_type'] ];
            $dataArray['{date_type_title}']        = $dateTypeMap[ $row['date_type'] ];
            $dataArray['{use_product_type_title}'] = $useProductTypeMap[ $row['use_product_type'] ];

            $dataArray['{use_type_title}']         = str_replace("$$", $row['full_price'], $dataArray['{use_type_title}']);

            if(  $row['date_type'] == 1 )
            {
                $dataArray['{date_type_title}'] = str_replace("start", $row['start_date'], $dataArray['{date_type_title}']);
                $dataArray['{date_type_title}'] = str_replace("end", $row['end_date'], $dataArray['{date_type_title}']);
            }

            if(  $row['date_type'] == 2 )
            {
                $dataArray['{date_type_title}'] = str_replace("$$", $row['valid_day_today'], $dataArray['{date_type_title}']);
            }

            if(  $row['date_type'] == 3 )
            {
                $dataArray['{date_type_title}'] = str_replace("$$", $row['valid_day_tomorrow'], $dataArray['{date_type_title}']);
            }


            return $dataArray;
        }

        function getDataClean($row)
        {
            $couponTypeMap = $this->getCouponType();
            $useTypeMap = $this->getUseType();
            $dateTypeMap = $this->getDateType();
            $useProductTypeMap = $this->getUseProductType();

            $dataArray = array();
            $dataArray['no']                 = $row['no'];
            $dataArray['title']              = $row['title'];
            $dataArray['send_num']           = $row['send_num'];
            $dataArray['coupon_type']        = $row['coupon_type'];
            $dataArray['coupon_price']       = $row['coupon_price'];
            $dataArray['discount']           = $row['discount'];
            $dataArray['use_type']           = $row['use_type'];
            $dataArray['full_price']         = $row['full_price'];
            $dataArray['limit_num']          = $row['limit_num'];
            $dataArray['limit_num_title']    = $row['limit_num'] == 0 ? '不限张': $row['limit_num'];
            $dataArray['user_label_no']      = $row['user_label_no'];
            $dataArray['date_type']          = $row['date_type'];
            $dataArray['start_date']         = $row['start_date'];
            $dataArray['end_date']           = $row['end_date'];
            $dataArray['valid_day_today']    = $row['valid_day_today'];
            $dataArray['valid_day_tomorrow'] = $row['valid_day_tomorrow'];
            $dataArray['use_product_type']   = $row['use_product_type'];
            $dataArray['product_no']         = $row['product_no'];
            $dataArray['note']               = $row['note'];
            $dataArray['add_time']           = $row['add_time'];
            $dataArray['update_time']        = $row['update_time'];
            $dataArray['get_num']            = $row['get_num'];
            $dataArray['use_num']            = $row['use_num'];

            $dataArray['coupon_type_title']      = $couponTypeMap[ $row['coupon_type'] ];
            $dataArray['use_type_title']         = $useTypeMap[ $row['use_type'] ];
            $dataArray['date_type_title']        = $dateTypeMap[ $row['date_type'] ];
            $dataArray['use_product_type_title'] = $useProductTypeMap[ $row['use_product_type'] ];

            $dataArray['use_type_title']         = str_replace("$$", $row['full_price'], $dataArray['use_type_title']);

            if(  $row['date_type'] == 1 )
            {
                $dataArray['date_type_title'] = str_replace("start", $row['start_date'], $dataArray['date_type_title']);
                $dataArray['date_type_title'] = str_replace("end", $row['end_date'], $dataArray['date_type_title']);
            }

            if(  $row['date_type'] == 2 )
            {
                $dataArray['date_type_title'] = str_replace("$$", $row['valid_day_today'], $dataArray['date_type_title']);
            }

            if(  $row['date_type'] == 3 )
            {
                $dataArray['date_type_title'] = str_replace("$$", $row['valid_day_tomorrow'], $dataArray['date_type_title']);
            }

            if( $row['coupon_type'] == 1 )
            {
                $dataArray['picker_title'] = $dataArray['title']."-".$dataArray['use_type_title']."-减".$dataArray['coupon_price']."元";
            }

            if( $row['coupon_type'] == 2 )
            {
                $dataArray['picker_title'] = $dataArray['title']."-".$dataArray['use_type_title']."-打".$dataArray['discount']."折";
            }

            return $dataArray;
        }


        //计算优惠价格
        function computerPrice($discount_coupon_no, $product_fee, $is_update_status = true)
        {
            $myDiscountCouponRecord = new DiscountCouponRecord($this->myMySQL);

            $discountCouponRecordRow = $myDiscountCouponRecord->getRow("*", "no = ".$discount_coupon_no." AND is_use = 0 AND is_past = 0");

            if( empty($discountCouponRecordRow) )
            {
                return $product_fee;
            }

            $discountCouponRow = $this->getRow("*", "no = ".$discountCouponRecordRow['discount_coupon_no']."");

            if( empty($discountCouponRow) )
            {
                return $product_fee;
            }

            //无限制, 满减
            if( $discountCouponRow['use_type'] == 1 || 
                ($discountCouponRow['use_type'] == 2 && $discountCouponRow['full_price'] < $product_fee) )
            {
                //1指定金额，2折扣
                if( $discountCouponRow['coupon_type'] == 1 )
                {
                    $product_fee = $product_fee - $discountCouponRow['coupon_price'];
                }

                if( $discountCouponRow['coupon_type'] == 2 )
                {
                    $product_fee = ($product_fee * $discountCouponRow['discount'])/10;
                }
            }

            //更新优惠券状态
            if( $is_update_status )
            {
                $dataArray = array();
                $dataArray['use_num'] = $discountCouponRow['use_num'] + 1;
                $this->update($dataArray, "no = ".$discountCouponRecordRow['discount_coupon_no']."");

                $dataArray = array();
                $dataArray['is_use'] = 1;
                $myDiscountCouponRecord->update($dataArray, "no = ".$discount_coupon_no."");
            }

            return $product_fee;
        }

}
?>