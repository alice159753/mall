<?php

	include_once("Table.php");

    ob_start();
    ob_clean();

	class UserAddress extends Table
	{
	    function UserAddress($myMySQL, $table = "user_address")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getIsDefault()
        {
            return  array(0 => '否', 1 => '是');
        }

        function getData($row)
        {
            $isDefault = $this->getIsDefault();

            $dataArray = array();
            $dataArray['{no}']                = $row['no'];
            $dataArray['{address_name}']      = $row['address_name'];
            $dataArray['{user_no}']           = $row['user_no'];
            $dataArray['{consignee}']         = $row['consignee'];
            $dataArray['{email}']             = $row['email'];
            $dataArray['{country}']           = $row['country'];
            $dataArray['{province}']          = empty($row['province']) ? '省' : $row['province'];
            $dataArray['{city}']              = empty($row['city']) ? '市' : $row['city'];
            $dataArray['{district}']          = empty($row['district']) ? '区' : $row['district'];
            $dataArray['{address}']           = $row['address'];
            $dataArray['{zipcode}']           = $row['zipcode'];
            $dataArray['{tel}']               = $row['tel'];
            $dataArray['{mobile}']            = $row['mobile'];
            $dataArray['{sign_building}']     = $row['sign_building'];
            $dataArray['{best_time}']         = $row['best_time'];
            $dataArray['{add_time}']          = $row['add_time'];
            $dataArray['{update_time}']       = $row['update_time'];
            $dataArray['{is_default}']        = $row['is_default'];
            $dataArray['{is_default_title}']  = isset($isDefault[$row['is_default']]) ? $isDefault[$row['is_default']] : '';
            $dataArray['{is_default_active}'] = $row['is_default'] == 1 ? 'active' : '';
            $dataArray['{default_checked}']   = $row['is_default'] == 1 ? 'checked' : '';

            return $dataArray;
        }


	}

?>