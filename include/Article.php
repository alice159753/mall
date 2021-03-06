<?php

	include_once("Table.php");

    ob_start();
    include_once(INCLUDE_DIR. "/Role.php");
    ob_clean();

	class Article extends Table
	{
	    function Article($myMySQL, $table = "article")
	    {
	        $this->myMySQL = $myMySQL;
	        $this->table = DB_PRE.$table;
	    }

        function getArticleTypeMap()
        {
            return  array(0 => '通用', 1 => '首页');
        }

        function getData($row)
        {
            $dataArray = array();
            $dataArray["{no}"]          = $row['no'];
            $dataArray["{title}"]       = $row['title'];
            $dataArray["{author}"]      = $row['author'];
            $dataArray['{content}']     = $row['content'];
            $dataArray["{view_count}"]  = $row['view_count'];
            $dataArray["{pubdate}"]     = $row['pubdate'];
            $dataArray["{is_through}"]  = $row['is_through'] == 'Y' ? '通过' : '未通过';
            $dataArray["{top}"]         = $row['top'];
            $dataArray["{thumb_pic}"]   = $row['thumb_pic'];
            $dataArray["{add_time}"]    = $row['add_time'];
            $dataArray["{description}"] = $row['description'];
            $dataArray["{pic_lists}"]   = $row['pic_lists'];

            $dataArray["{url}"] = URL."/article.php?no=".$row['no'];

            return $dataArray;
        }

        function getDataClean($row)
        {
            $dataArray = array();
            $dataArray["no"]          = $row['no'];
            $dataArray["title"]       = $row['title'];
            $dataArray["author"]      = $row['author'];
            $dataArray['content']     = $row['content'];

            $dataArray['content'] = str_replace("<br/>", "<p></p>", $dataArray['content']);
            $dataArray['content'] = str_replace("<br>", "<p></p>", $dataArray['content']);

            //替换图片地址
            $dataArray['content'] = str_replace('src="/ueditor/', 'src="'.FILE_URL.'/ueditor/', $dataArray['content']);

            $dataArray["view_count"]  = $row['view_count'];
            $dataArray["pubdate}"]    = $row['pubdate'];
            $dataArray["is_through"]  = $row['is_through'] == 'Y' ? '通过' : '未通过';
            $dataArray["top"]         = $row['top'];
            $dataArray["thumb_pic"]   = FILE_URL.$row['thumb_pic'];
            $dataArray["add_time"]    = $row['add_time'];
            $dataArray["description"] = $row['description'];
            $dataArray["pic_lists"]   = $row['pic_lists'];

            $dataArray["time_format"]    = !empty($row['pubdate']) && $row['pubdate'] != '0000-00-00'? 
                                            date('Y-m-d', strtotime($row['pubdate'])) : date('Y-m-d', strtotime($row['add_time']));

            $dataArray["url"] = URL."/article.php?no=".$row['no'];

            return $dataArray;
        }
	}

?>