<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/SystemConfig.php");
    ob_clean();

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $mySystemConfig = new SystemConfig($myMySQL);

    $row = $mySystemConfig->getRow("*", "1=1 ORDER BY no DESC");

    $result = $mySystemConfig->getDataClean($row);

    Output::succ('', $result);

?>