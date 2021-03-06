<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/SystemConfig.php");
    include_once(INCLUDE_DIR. "/FileTools.php");
    ob_clean();

    // request
    $no = isset($_REQUEST["no"]) ? $_REQUEST["no"] : 0;

    $site_name = !empty($_REQUEST["site_name"]) ? trim($_REQUEST["site_name"]) : "" ;
    $site_title = !empty($_REQUEST["site_title"]) ? trim($_REQUEST["site_title"]) : "" ;
    $site_keyword = !empty($_REQUEST["site_keyword"]) ? $_REQUEST["site_keyword"] : "" ;
    $site_description = !empty($_REQUEST["site_description"]) ? trim($_REQUEST["site_description"]) : "" ;
    $comany_address = !empty($_REQUEST["comany_address"]) ? trim($_REQUEST["comany_address"]) : "" ;
    $phone = !empty($_REQUEST["phone"]) ? $_REQUEST["phone"] : "" ;
    $qq = !empty($_REQUEST["qq"]) ? trim($_REQUEST["qq"]) : "" ;
    $skype = !empty($_REQUEST["skype"]) ? trim($_REQUEST["skype"]) : "" ;
    $wechat = !empty($_REQUEST["wechat"]) ? $_REQUEST["wechat"] : "" ;
    $email = !empty($_REQUEST["email"]) ? trim($_REQUEST["email"]) : "" ;
    $site_logo = !empty($_REQUEST["site_logo"]) ? trim($_REQUEST["site_logo"]) : "" ;
    $wechat_logo = !empty($_REQUEST["wechat_logo"]) ? trim($_REQUEST["wechat_logo"]) : "" ;
    $longitude = !empty($_REQUEST["longitude"]) ? trim($_REQUEST["longitude"]) : "" ;
    $latitude = !empty($_REQUEST["latitude"]) ? trim($_REQUEST["latitude"]) : "" ;
    $copyright = !empty($_REQUEST["copyright"]) ? trim($_REQUEST["copyright"]) : "" ;

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySystemConfig = new SystemConfig($myMySQL);

    $dataArray = array();
    $dataArray['site_name']        = $site_name;
    $dataArray['site_title']       = $site_title;
    $dataArray['site_keyword']     = $site_keyword;
    $dataArray['site_description'] = $site_description;
    $dataArray['comany_address']   = $comany_address;
    $dataArray['phone']            = $phone;
    $dataArray['qq']               = $qq;
    $dataArray['skype']            = $skype;
    $dataArray['wechat']           = $wechat;
    $dataArray['email']            = $email;
    $dataArray['longitude']        = $longitude;
    $dataArray['latitude']         = $latitude;
    $dataArray['copyright']        = $copyright;

    if( !empty($site_logo) )
    {
        $dataArray['site_logo'] = $site_logo;
    }

    if( !empty($wechat_logo) )
    {
        $dataArray['wechat_logo'] = $wechat_logo;
    }

    if( !empty($no) )
    {
        $dataArray['update_time'] = 'now()';
        $mySystemConfig->update($dataArray, "no = ". $no);
    }
    else
    {
        $dataArray['add_time'] = 'now()';
        $mySystemConfig->addRow($dataArray);
    }

    Output::succ('修改成功', array());

?>