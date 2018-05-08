<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
    include_once(INCLUDE_DIR. "/Brand.php");
    ob_clean();
    

	class Product extends Table
	{
	    function Product($myMySQL, $table = "product")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsOnline()
        {
            return array('Y' => '是', 'N' => '否');
        }

        //商品类型：1实物商品，2虚拟商品，3电子卡券，4酒店商品，5蛋糕烘培
        function getProductType()
        {
            return array('1' => '实物商品', '2' => '虚拟商品','3' => '电子卡券','4' => '酒店商品','5' => '蛋糕烘培');
        }

        function getData($row)
        {
            $isOnlineMap = $this->getIsOnline();
            $productTypeMap = $this->getProductType();

            $myCategory = new Category($this->myMySQL);
            $myBrand = new Brand($this->myMySQL);

            $dataArray = array();
            $dataArray['{no}']                 = $row['no'];
            $dataArray['{title}']              = $row['title'];
            $dataArray['{pic}']                = $row['pic'];
            $dataArray['{product_type}']       = $row['product_type'];
            $dataArray['{product_type_title}'] = $productTypeMap[ $row['product_type'] ];
            $dataArray['{share_content}']      = $row['share_content'];
            $dataArray['{product_sn}']         = $row['product_sn'];
            $dataArray['{real_sales}']         = $row['real_sales'];
            $dataArray['{virtual_sales}']      = $row['virtual_sales'];
            $dataArray['{sales_num}']          = $row['real_sales'] + $row['virtual_sales'];
            $dataArray['{content}']            = $row['content'];
            $dataArray['{is_online}']          = $row['is_online'];
            $dataArray['{is_online_title}']    = $isOnlineMap[ $row['is_online'] ];
            $dataArray['{add_time}']           = $row['add_time'];
            $dataArray['{update_time}']        = $row['update_time'];
            $dataArray['{label}']              = $row['label'];
            $dataArray['{sales_start_date}']   = $row['sales_start_date'];
            $dataArray['{sales_end_date}']     = $row['sales_end_date'];
            $dataArray['{repertory_num}']      = $row['repertory_num'];
            $dataArray['{description}']        = $row['description'];
            $dataArray['{selling_points}']     = $row['selling_points'];
            $dataArray['{sale_price}']         = $row['sale_price'];
            $dataArray['{lineation_price}']    = $row['lineation_price'];
            $dataArray['{member_price}']       = $row['member_price'];
            $dataArray['{cost_price}']         = $row['cost_price'];
            $dataArray['{postage_no}']         = $row['postage_no'];
            $dataArray['{postage_price}']      = $row['postage_price'];
            $dataArray['{product_weight_kg}']  = $row['product_weight_kg'];
            $dataArray['{product_weight_g}']   = $row['product_weight_g'];
            $dataArray['{total_click_num}']    = $row['total_click_num'];
            $dataArray['{give_integral}']      = $row['give_integral'];
            $dataArray['{category_no_1}']      = $row['category_no_1'];
            $dataArray['{category_no_2}']      = $row['category_no_2'];
            $dataArray['{brand_no}']           = $row['brand_no'];

            $dataArray['{product_weight}']   = empty($row['product_weight_kg']) ? $row['product_weight_g'] :$row['product_weight_kg'];

            $dataArray['{product_weight_ceil}']   = empty($row['product_weight_kg']) ? 'g' : 'kg';


            $dataArray['{sales_start_date_short}'] = '';
            $dataArray['{sales_end_date_short}'] = '';
            
            if( !empty($row['sales_start_date']) && $row['sales_start_date'] != '0000-00-00' )
            {
                $dataArray['{sales_start_date_short}'] = date('m.d', strtotime($row['sales_start_date']));
            }

            if( !empty($row['sales_end_date']) && $row['sales_end_date'] != '0000-00-00' )
            {
                $dataArray['{sales_end_date_short}'] = date('m.d', strtotime($row['sales_end_date']));
            }

            $dataArray['{category_no_1_title}'] = '';
            if( !empty($row['category_no_1']) )
            {
                $categoryRow = $myCategory->getRow("*", "no = ". $row['category_no_1']);

                $dataArray['{category_no_1_title}'] = $categoryRow['title'];
            }   

            $dataArray['{category_no_2_title}'] = '';
            if( !empty($row['category_no_2']) )
            {
                $categoryRow = $myCategory->getRow("*", "no = ". $row['category_no_2']);

                $dataArray['{category_no_2_title}'] = $categoryRow['title'];
            }

            $dataArray['{brand_title}'] = '';
            if( !empty($row['brand_no']) )
            {
                $brandRow = $myCategory->getRow("*", "no = ". $row['brand_no']);

                $dataArray['{brand_title}'] = $brandRow['title'];
            }

            $dataArray['{product_url}'] = URL."/product_detail.php?no=".$row['no'];

            $dataArray['{add_time_f}'] = date('Y.m.d', strtotime($row['add_time']));

            $dataArray['{online_checkbox}'] = $row['is_online'] ==1 ? 'checked' :'';

            return $dataArray;
        }


        function getDataClean($row)
        {
            $isOnlineMap = $this->getIsOnline();
            $productTypeMap = $this->getProductType();

            $myCategory = new Category($this->myMySQL);
            $myBrand = new Brand($this->myMySQL);

            $dataArray = array();
            $dataArray['no']                 = $row['no'];
            $dataArray['title']              = $row['title'];
            $dataArray['pic']                = $row['pic'];
            $dataArray['product_type']       = $row['product_type'];
            $dataArray['product_type_title'] = $productTypeMap[ $row['product_type'] ];
            $dataArray['share_content']      = $row['share_content'];
            $dataArray['product_sn']         = $row['product_sn'];
            $dataArray['real_sales']         = $row['real_sales'];
            $dataArray['virtual_sales']      = $row['virtual_sales'];
            $dataArray['sales_num']          = $row['real_sales'] + $row['virtual_sales'];
            $dataArray['content']            = $row['content'];
            $dataArray['is_online}']          = $row['is_online'];
            $dataArray['is_online_title']    = $isOnlineMap[ $row['is_online'] ];
            $dataArray['add_time']           = $row['add_time'];
            $dataArray['update_time']        = $row['update_time'];
            $dataArray['label']              = $row['label'];
            $dataArray['sales_start_date']   = $row['sales_start_date'];
            $dataArray['sales_end_date']     = $row['sales_end_date'];
            $dataArray['repertory_num}']      = $row['repertory_num'];
            $dataArray['description']        = $row['description'];
            $dataArray['selling_points']     = $row['selling_points'];
            $dataArray['sale_price']         = $row['sale_price'];
            $dataArray['lineation_price']    = $row['lineation_price'];
            $dataArray['member_price']       = $row['member_price'];
            $dataArray['cost_price']         = $row['cost_price'];
            $dataArray['postage_no']         = $row['postage_no'];
            $dataArray['postage_price']      = $row['postage_price'];
            $dataArray['product_weight_kg']  = $row['product_weight_kg'];
            $dataArray['product_weight_g']   = $row['product_weight_g'];
            $dataArray['total_click_num']    = $row['total_click_num'];
            $dataArray['give_integral']      = $row['give_integral'];
            $dataArray['category_no_1']      = $row['category_no_1'];
            $dataArray['category_no_2']      = $row['category_no_2'];
            $dataArray['brand_no']           = $row['brand_no'];

            $dataArray['product_weight']   = empty($row['product_weight_kg']) ? $row['product_weight_g'] :$row['product_weight_kg'];

            $dataArray['product_weight_ceil']   = empty($row['product_weight_kg']) ? 'g' : 'kg';


            $dataArray['sales_start_date_short'] = '';
            $dataArray['sales_end_date_short'] = '';
            
            if( !empty($row['sales_start_date']) && $row['sales_start_date'] != '0000-00-00' )
            {
                $dataArray['sales_start_date_short'] = date('m.d', strtotime($row['sales_start_date']));
            }

            if( !empty($row['sales_end_date']) && $row['sales_end_date'] != '0000-00-00' )
            {
                $dataArray['sales_end_date_short'] = date('m.d', strtotime($row['sales_end_date']));
            }

            $dataArray['category_no_1_title'] = '';
            if( !empty($row['category_no_1']) )
            {
                $categoryRow = $myCategory->getRow("*", "no = ". $row['category_no_1']);

                $dataArray['category_no_1_title'] = $categoryRow['title'];
            }   

            $dataArray['category_no_2_title'] = '';
            if( !empty($row['category_no_2']) )
            {
                $categoryRow = $myCategory->getRow("*", "no = ". $row['category_no_2']);

                $dataArray['category_no_2_title'] = $categoryRow['title'];
            }

            $dataArray['brand_title'] = '';
            if( !empty($row['brand_no']) )
            {
                $brandRow = $myCategory->getRow("*", "no = ". $row['brand_no']);

                $dataArray['brand_title'] = $brandRow['title'];
            }

            $dataArray['product_url'] = URL."/product_detail.php?no=".$row['no'];

            $dataArray['add_time_f'] = date('Y.m.d', strtotime($row['add_time']));

            $dataArray['online_checkbox'] = $row['is_online'] ==1 ? 'checked' :'';

            return $dataArray;
        }







	}

   

?>