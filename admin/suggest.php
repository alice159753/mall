<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/Suggest.php");
    include_once(INCLUDE_DIR. "/User.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : "";
    $content = !empty($_REQUEST["content"]) ? $_REQUEST["content"] : "";
    $reply_content = !empty($_REQUEST["reply_content"]) ? $_REQUEST["reply_content"] : "";
    $add_time_min = !empty($_REQUEST["add_time_min"]) ? $_REQUEST["add_time_min"] : "";
    $add_time_max = !empty($_REQUEST["add_time_max"]) ? $_REQUEST["add_time_max"] : "";


    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $mySuggest = new Suggest($myMySQL);
    $myUser = new User($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/suggest.html");

    include_once("common.inc.php");

    // search
    $searchArray = array( "{order}" => $order );

    $searchArray['{user_no}']       = $user_no;
    $searchArray['{content}']       = $content;
    $searchArray['{reply_content}'] = $reply_content;
    $searchArray['{add_time_max}']  = $add_time_max;
    $searchArray['{add_time_min}']  = $add_time_min;

    $myTemplate->setReplace("search", $searchArray);

    $condition = " 1=1 ";

    if( !empty($user_no) )
    {
        $condition .= " AND user_no = $user_no";
    }

    if( !empty($content) )
    {
        $condition .= " AND content like '%$content%'";
    }

    if( !empty($reply_content) )
    {
        $condition .= " AND reply_content like '%$reply_content%'";
    }

    if( !empty($add_time_min) )
    {
        $condition .= " AND add_time >= '$add_time_min'";
    }

    if( !empty($add_time_max) )
    {
        $condition .= " AND add_time <= '$add_time_max 23:59:59'";
    }

    // page
    $page_size = 50;

    $total_count = $mySuggest->getCount($condition);
    $total_page = $mySuggest->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $mySuggest->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = array();
        $dataArray["{no}"]              = $rows[$i]['no'];
        $dataArray["{user_no}"]         = $rows[$i]['user_no'];
        
        $one                            = $myUser->getRow("*", "no =".$rows[$i]['user_no']);
        $dataArray["{nickname}"]        = $one['nickname'];
        
        $dataArray["{content}"]         = $rows[$i]['content'];
        $dataArray["{reply_content}"]   = $rows[$i]['reply_content'];
        $dataArray["{add_time}"]        = $rows[$i]['add_time'];
        $dataArray["{update_time}"]     = $rows[$i]['update_time'];
        $dataArray["{user_message_no}"] = $rows[$i]['user_message_no'];

        unset($_REQUEST['no']);
        $dataArray["{get}"] = isset($_REQUEST) ? http_build_query($_REQUEST) : "";

        $myTemplate->setReplace("list", $dataArray);
    }

    // page list
    $previous_page = $page - 1 < 1 ? 1 : $page - 1;
    $next_page = $page + 1 > $total_page ? $total_page : $page + 1;

    unset($_REQUEST["page"]);

    $dataArray = array( "{get}"           => isset($_REQUEST) ? http_build_query($_REQUEST) : "",
                        "{total_count}"   => $total_count,
                        "{total_page}"    => $total_page,
                        "{page}"          => $page,
                        "{previous_page}" => $previous_page,
                        "{next_page}"     => $next_page,
                        "{last_page}"     => $total_page );

    $myTemplate->setReplace("page_list", $dataArray);

    for($i = 4; $i > 0; $i--)
    {
        if ( $page - $i >= 1 )
        {
            $myTemplate->setReplace("previous", array("{previous}" => $page - $i), 2);
        }
    }

    for($i = 1; $i <= 4; $i++)
    {
        if ( $page + $i <= $total_page )
        {
            $myTemplate->setReplace("next", array("{next}" => $page + $i), 2);
        }
    }

    $myTemplate->process();
    $myTemplate->output();

?>