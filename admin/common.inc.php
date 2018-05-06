<?php

    include_once("permission_config.php");

    $basename = basename($_SERVER['SCRIPT_NAME']);

    $converName = array();

    $come_from = isset($_REQUEST["come_from"]) ? $_REQUEST["come_from"] : '';
    $come_from = empty($come_from) ? $basename : $come_from;

    //navigation
    $myTemplateNavigation = new Template(TEMPLATE_DIR ."/navigation.html");
    $myTemplateNavigation->setClearTag(true);
    $myTemplateNavigation->setNothing("nav");
    $dataArray = array();
    $dataArray['{account}'] = $_SESSION['account'];
    $myTemplateNavigation->setReplace("admin", $dataArray, 2);
    $myTemplateNavigation->process();
    $myTemplate->setReplaceSegment("nav", $myTemplateNavigation->getContent());

    //menu
    $myTemplateMenu = new Template(TEMPLATE_DIR ."/menu.html");
    $myTemplateMenu->setClearTag(true);

    $flag_index = 0;
    foreach ($permission_config as $key => $permission) 
    {
        $dataArray = array();
        $dataArray['{title}'] = $permission['title'];
        $dataArray['{index}'] = $flag_index++;

        //提取里面的php，判断是否该框展示
        $phpList = array();
        foreach ($permission['data'] as $index => $item) 
        {
            $phpList[] = $item['php'];
        }

        if( in_array($basename, $phpList) )
        {
            //打开
            $dataArray['{am-collapsed}'] = '';
            $dataArray['{am-in}'] = 'am-in';
            $dataArray['{height}'] = '';
        }
        else
        {
            //关闭
            $dataArray['{am-collapsed}'] = 'am-collapsed';
            $dataArray['{am-in}'] = '';
            $dataArray['{height}'] = 'height:0px';
        }

        $myTemplateMenu->setReplace("$key", $dataArray);

        foreach ($permission['data'] as $index => $item) 
        {
            if( $item['display'] == 'none' )
            {
                continue;
            }

            if(  !in_array($item['php'], $adminRow['permissionList']) && $adminRow['no'] != 1 )
            {
                continue;
            }

            $dataArray = array();
            $dataArray['{title}'] = $item['title'];
            $dataArray['{php}'] = $item['php'];

            $myTemplateMenu->setReplace("list", $dataArray, 2);
        }
    }

    $myTemplateMenu->process();
    $myTemplate->setReplaceSegment("menu", $myTemplateMenu->getContent());

    //footer
    $myTemplateFooter = new Template(TEMPLATE_DIR ."/footer.html");
    $myTemplateFooter->setClearTag(true);
    $myTemplateFooter->setAutoBrackets(true);
    $myTemplateFooter->setNothing("footer");

    $myTemplateFooter->process();
    $myTemplate->setReplaceSegment("footer", $myTemplateFooter->getContent());

?>    


