<?php

    include_once("config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Curl.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myCurl = new Curl();
    $myUser = new User($myMySQL);

    $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
    $nickName = isset($_REQUEST['nickName']) ? $_REQUEST['nickName'] : '';

    if( empty($code) )
    {
        Output::error('code 不能为空', array());
    }

    if( empty($nickName) )
    {
        Output::error('nickName 不能为空', array());
    }


    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".WEIXIN_APPID."&secret=".WEIXIN_APPSECRECT."&js_code=$code&grant_type=authorization_code";
    $response = $myCurl->getContent($url);

    $response = json_decode($response, true);

    if( isset($response['errcode']) && $response['errcode'] != 0 )
    {
        Output::error('登录失败请重新登录1！'.print_r($response, true), array());
    }

//{
//"session_key": "B3rnIBVcFBEzyDM9cAMdjg==",
//"openid": "o_kkl0TwZH3oQ_44ttLR6n5L2ckM"
//}

    $openid = $response['openid'];


    $user = $_REQUEST;
    $user['openid'] = $openid;

    $userRow = $myUser->getRow("*", "openid = '".$openid."'");

    if( !empty($userRow) )
    {
    }
    else
    {
        $userRow = $myUser->register2($user, 'xiaochengxu');
    }

    Output::succ('', $userRow);




?>