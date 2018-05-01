<?php

$permission_config['menu_product']['title'] = '商品';


$permission_config['menu_product']['data'][] = array('title' => '分类',         'php'=> 'category.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '分类新增',     'php'=> 'category_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '分类修改',     'php'=> 'category_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '分类删除',     'php'=> 'category_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '分类删除更多', 'php'=> 'category_delete_more.php', 'display' => 'none');


$permission_config['menu_product']['data'][] = array('title' => '商品',         'php'=> 'product.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '商品新增',     'php'=> 'product_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品修改',     'php'=> 'product_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品删除',     'php'=> 'product_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品删除更多', 'php'=> 'product_delete_more.php', 'display' => 'none');


$permission_config['menu_article']['title'] = '图文';

$permission_config['menu_article']['data'][] = array('title' => '图文',         'php'=> 'article.php',             'display' => 'block');
$permission_config['menu_article']['data'][] = array('title' => '图文新增',     'php'=> 'article_add.php',         'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文修改',     'php'=> 'article_modify.php',      'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文删除',     'php'=> 'article_delete.php',      'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文删除更多', 'php'=> 'article_delete_more.php', 'display' => 'none');




$permission_config['menu_admin']['title'] = '基本配置';
$permission_config['menu_admin']['data'][] = array('title' => '管理员管理',         'php'=> 'admin.php',             'display' => 'block');
$permission_config['menu_admin']['data'][] = array('title' => '管理员管理新增',     'php'=> 'admin_add.php',         'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '管理员管理修改',     'php'=> 'admin_modify.php',      'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '管理员管理删除',     'php'=> 'admin_delete.php',      'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '管理员管理删除更多', 'php'=> 'admin_delete_more.php', 'display' => 'none');

$permission_config['menu_admin']['data'][] = array('title' => '角色配置',         'php'=> 'role.php',            'display' => 'block');
$permission_config['menu_admin']['data'][] = array('title' => '角色配置新增',     'php'=> 'role_add.php',        'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '角色配置修改',     'php'=> 'role_modify.php,',    'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '角色配置删除',     'php'=> 'role_delete.php',     'display' => 'none');
$permission_config['menu_admin']['data'][] = array('title' => '角色配置删除更多', 'php'=> 'role_delete_more.php','display' => 'none');




?>