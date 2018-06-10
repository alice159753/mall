<?php

    //清除用户购物处  立即购买数据
    include_once("../api/config.cmd.php");

    ob_start();
    include_once(INCLUDE_DIR. "/UserCarts.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $myUserCarts = new UserCarts($myMySQL);

    $today = date('Y-m-d');
    $myUserCarts->remove("is_display = 1 and add_time < '".$today."'");


?>

