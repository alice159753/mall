<?php

    mb_internal_encoding("UTF-8");

    if ( function_exists("date_default_timezone_set") )
    {
        date_default_timezone_set('Asia/Taipei');
    }

    $home_dir = dirname(__FILE__);

    define("DB_HOST", "localhost");
    define("DB_USER", 'root');
    define("DB_PASS", 'root');
    define("DB_NAME", 'mall');
    define("DB_PORT", '3306');
    define("DB_PRE",   "ml_");

    define("URL", "https://mall.huaban1314.com");
    define("DOMAIN", "https://mall.huaban1314.com");
    define("HOME_DIR", $home_dir);
    define("LOGS_DIR", $home_dir."/../logs");
    define("DATA_DIR", $home_dir."/../data/admin");
    define("INCLUDE_DIR", $home_dir ."/../include");
    define("TEMPLATE_DIR", $home_dir ."/../template");
    define("FILE_URL", "https://mall.huaban1314.com");

    //微信配置
    define("WEIXIN_APPID", "wx4a3c9a890bf83384");
    define("WEIXIN_APPSECRECT", "66475268e92dfb1f4b1a5d8c3d1df970");
    define("WEIXIN_TOKEN", "");
    define("MERCHANT_NUMBER", "1494738062");
    define("WEIXIN_PAY_KEY", "zhanghui19890721zhangnan19900509");

    ob_start();
    include_once(INCLUDE_DIR ."/MySQL.php");
    include_once(INCLUDE_DIR ."/Template.php");
    include_once(INCLUDE_DIR ."/Table.php");
    include_once(INCLUDE_DIR ."/Admin.php");
    include_once(INCLUDE_DIR ."/JavaScript.php");
    include_once(INCLUDE_DIR ."/Role.php");
    include_once(INCLUDE_DIR ."/Output.php");
    include_once(INCLUDE_DIR ."/StringFormat.php");
    include_once(INCLUDE_DIR ."/FileTools.php");
    ob_clean();


?>