<?php

 ob_start();
 include_once(INCLUDE_DIR. "/Curl.php");
 ob_clean();

class OrderExpressage
{

    static function query1($order, $kuaidi_name = 'shunfeng')
    {
        $myCurl = new Curl();

        $response = $myCurl->getContent('http://www.kuaidi.com/index-ajaxselectcourierinfo-'.$order.'-'.$kuaidi_name.'.html');
        $response = json_decode($response, true);

        return $response;
    }

    //快递100
    static function query2($order, $kuaidi_name = 'shunfeng')
    {
        $myCurl = new Curl();

        $response = $myCurl->getContent('http://www.kuaidi100.com/query?type='.$kuaidi_name.'&postid='.$order.'&id=1&valicode=&temp='.microtime(true));
        $response = json_decode($response, true);

        return $response;
    }


    //快递100，根据订单编号获取快递公司名称
    function getName($order)
    {
        $myCurl = new Curl();

        $response = $myCurl->getContent("http://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=".$order);

        $response = json_decode($response, true);

        return $response;
    }

}




?>