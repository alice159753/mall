<?php

    //添加用户地址
    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserAddress.php");
    ob_clean();

    $user_no   = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : 0;
    $consignee = !empty($_REQUEST["consignee"]) ? $_REQUEST["consignee"] : '';
    $zipcode   = !empty($_REQUEST["zipcode"]) ? $_REQUEST["zipcode"] : '';
    $province  = !empty($_REQUEST["province"]) ? $_REQUEST["province"] : '';
    $city      = !empty($_REQUEST["city"]) ? $_REQUEST["city"] : '';
    $district  = !empty($_REQUEST["district"]) ? $_REQUEST["district"] : '';
    $address   = !empty($_REQUEST["address"]) ? $_REQUEST["address"] : '';
    $country   = !empty($_REQUEST["country"]) ? $_REQUEST["country"] : '';
    $tel       = !empty($_REQUEST["tel"]) ? $_REQUEST["tel"] : '';

    $country = $country == 510000  ? '中国' : $country;

    if( empty($user_no) )
    {
        Output::error('用户不能为空', '1');
    }


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserAddress = new UserAddress($myMySQL);

    $row = $myUserAddress->getRow("*", "user_no = $user_no AND consignee = '".$consignee."' AND zipcode = '".$zipcode."' AND 
                                 province = '".$province."' AND city = '".$city."' AND district = '".$district."' AND 
                                 address = '".$address."' AND country = '".$country."' AND tel = '".$tel."'
                                 ");

    if( empty($row) )
    {
        $dataArray = array();
        $dataArray['user_no']   = $user_no;
        $dataArray['consignee'] = $consignee;
        $dataArray['zipcode']   = $zipcode;
        $dataArray['province']  = $province;
        $dataArray['city']      = $city;
        $dataArray['district']  = $district;
        $dataArray['address']   = $address;
        $dataArray['country']   = $country;
        $dataArray['tel']       = $tel;
        $dataArray['add_time']  = 'now()';

        $myUserAddress->addRow($dataArray);
    }


    Output::succ('', $result);

?>