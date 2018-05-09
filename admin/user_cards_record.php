<?php

    include_once("config.php");

    ob_start();
    include_once(INCLUDE_DIR. "/JavaScript.php");
    include_once(INCLUDE_DIR. "/UserCardsRecord.php");
    include_once(INCLUDE_DIR. "/User.php");
    include_once(INCLUDE_DIR. "/UserCards.php");
    ob_clean();

    $order = !empty($_REQUEST["order"]) ? $_REQUEST["order"] : "no desc";
    $page = !empty($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
    $user_no = !empty($_REQUEST["user_no"]) ? $_REQUEST["user_no"] : "0";

    $myMySQL = new MySQL();
    $myMySQL->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
    $myUserCardsRecord = new UserCardsRecord($myMySQL);
    $myUser = new User($myMySQL);
    $myUserCards = new UserCards($myMySQL);

    $myTemplate = new Template(TEMPLATE_DIR ."/user_cards_record.html");

    include_once("common.inc.php");

    // search
    $searchArray = array( "{order}" => $order );

    $searchArray['{user_no}'] = $user_no;

    $myTemplate->setReplace("search", $searchArray);

    $condition = " 1=1 ";

    if ( !empty($user_no) )
    {
        $condition .= " AND user_no =  '$user_no' ";
    }

    // page
    $page_size = 50;

    $total_count = $myUserCardsRecord->getCount($condition);
    $total_page = $myUserCardsRecord->getPageCount($page_size, $condition);

    $total_page = ($total_page == 0) ? 1 : $total_page;
    $page = ($total_page < $page) ? $total_page : $page;

    // list
    $rows = $myUserCardsRecord->getPage("*", $page, $page_size, $condition ." ORDER BY ". str_replace("-", " ", $order));

    $random = time();

    for($i = 0; isset($rows[$i]); $i++)
    {   
        $dataArray = $myUserCardsRecord->getData($rows[$i]);
        $dataArray['{nickname}'] = $myUser->getValue("nickname", "no = ".$rows[$i]['user_no']);

        $dataArray['{title}'] = $myUserCards->getValue("title", "no = ".$rows[$i]['user_cards_no']);

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