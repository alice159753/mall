<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Category.php");
    ob_clean();
    

	class ProductAttr extends Table
	{
	    function ProductAttr($myMySQL, $table = "product_attr")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getData($row)
        {
            $dataArray = array();
            $dataArray['{no}']                   = $row['no'];
            $dataArray['{product_no}']           = $row['product_no'];
            $dataArray['{specification_no}']     = $row['specification_no'];
            $dataArray['{specification_title}']  = $row['specification_title'];
            $dataArray['{specification_value}']  = $row['specification_value'];
            $dataArray['{sale_price}']           = $row['sale_price'];
            $dataArray['{lineation_price}']      = $row['lineation_price'];
            $dataArray['{cost_price}']           = $row['cost_price'];
            $dataArray['{member_price}']         = $row['member_price'];
            $dataArray['{repertory_num}']        = $row['repertory_num'];
            $dataArray['{product_sn}']           = $row['product_sn'];
            $dataArray['{give_integral}']        = $row['give_integral'];
            $dataArray['{add_time}']             = $row['add_time'];
            $dataArray['{update_time}']          = $row['update_time'];
            $dataArray['{pic}']                  = $row['pic'];
            $dataArray['{product_weight_kg}']    = $row['product_weight_kg'];
            $dataArray['{product_weight_g}']     = $row['product_weight_g'];
            $dataArray['{product_weight}']       = !empty($row['product_weight_kg']) ? $row['product_weight_kg']: $row['product_weight_g'];
            $dataArray['{product_weight_title}'] = !empty($row['product_weight_kg']) ? $row['product_weight_kg'].'kg' : $row['product_weight_g'].'g';

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray['no']                   = $row['no'];
            $dataArray['product_no']           = $row['product_no'];
            $dataArray['specification_no']     = $row['specification_no'];
            $dataArray['specification_title']  = $row['specification_title'];
            $dataArray['specification_value']  = $row['specification_value'];
            $dataArray['sale_price']           = $row['sale_price'];
            $dataArray['lineation_price']      = $row['lineation_price'];
            $dataArray['cost_price']           = $row['cost_price'];
            $dataArray['member_price']         = $row['member_price'];
            $dataArray['repertory_num']        = $row['repertory_num'];
            $dataArray['product_sn']           = $row['product_sn'];
            $dataArray['give_integral']        = $row['give_integral'];
            $dataArray['add_time']             = $row['add_time'];
            $dataArray['update_time']          = $row['update_time'];
            $dataArray['pic']                  = $row['pic'];
            $dataArray['product_weight_kg']    = $row['product_weight_kg'];
            $dataArray['product_weight_g']     = $row['product_weight_g'];
            $dataArray['product_weight']       = !empty($row['product_weight_kg']) ? $row['product_weight_kg']: $row['product_weight_g'];
            $dataArray['product_weight_title'] = !empty($row['product_weight_kg']) ? $row['product_weight_kg'].'kg' : $row['product_weight_g'].'g';

            return $dataArray;
        }

	}

   

?>