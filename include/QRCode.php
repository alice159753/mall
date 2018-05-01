<?php

class QRCode 
{ 
	
	public static function makeWithUrl($url, $width = 300, $height = 300, $ec_level = 'L', $margin = 0)
	{
 		$url = urlencode($url); 

 		$result = "http://chart.apis.google.com/chart?chs=".$width."x".$height."&cht=qr&chld=".$ec_level."".
 				  "|".$margin."&chl=".$url."";

 		return $result;
	}

    
    //http://www.liantu.com/pingtai/
    public static function make2($url, $logo = '')
    {
        $url = urlencode($url); 

        $result = "http://qr.liantu.com/api.php?text=". $url;

        if( !empty($logo) )
        {
            $result = "http://qr.liantu.com/api.php?text=". $url."&logo=". $logo;
        }

        return $result;
    }

    
}


?>