<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
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

        function getIsShipping()
        {
            return array('Y' => '是', 'N' => '否');
        }

        function getIsIndex()
        {
            return array('Y' => '是', 'N' => '否');
        }


        function getData($row)
        {
            $isOnlineMap = $this->getIsOnline();
            $isShipping = $this->getIsShipping();
            $isIndex = $this->getIsIndex();

            $myCategory = new Category($this->myMySQL);

            $dataArray = array();
            $dataArray['{no}']                = $row['no'];
            $dataArray['{title}']             = $row['title'];
            $dataArray['{pic}']               = $row['pic'];
            $dataArray['{shop_price}']        = $row['shop_price'] /100;
            $dataArray['{market_price}']      = $row['market_price'] /100;
            $dataArray['{real_sales}']        = $row['real_sales'];
            $dataArray['{virtual_sales}']     = $row['virtual_sales'];
            $dataArray['{sales_num}']         = $row['real_sales'] + $row['virtual_sales'];
            $dataArray['{content}']           = $row['content'];
            $dataArray['{is_online}']         = $row['is_online'];
            $dataArray['{is_online_title}']   = $isOnlineMap[ $row['is_online'] ];
            $dataArray['{add_time}']          = $row['add_time'];
            $dataArray['{update_time}']       = $row['update_time'];
            $dataArray['{label}']             = $row['label'];
            $dataArray['{category_no}']       = $row['category_no'];
            $dataArray['{repertory_num}']     = $row['repertory_num'];
            $dataArray['{click_num}']         = $row['click_num'];
            $dataArray['{goods_weight}']      = $row['goods_weight'];
            $dataArray['{is_shipping_title}'] = $isShipping[ $row['is_shipping'] ];
            $dataArray['{is_shipping}']       = $row['is_shipping'];
            $dataArray['{sales_start_date}']  = $row['sales_start_date'];
            $dataArray['{sales_end_date}']    = $row['sales_end_date'];
            $dataArray['{buy_num_shipping}']  = $row['buy_num_shipping'];
            $dataArray['{is_index_title}']    = $isIndex[ $row['is_index'] ];

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

            if( !empty($row['category_no']) )
            {
                $categoryRow = $myCategory->getRow("*", "no = ". $row['category_no']);

                $dataArray['{category_title}'] = $categoryRow['title'];
            }   

            $dataArray['{product_url}'] = URL."/product_detail.php?no=".$row['no'];

            $dataArray['{add_time_f}'] = date('Y.m.d', strtotime($row['add_time']));

            return $dataArray;
        }


	}

   

?>