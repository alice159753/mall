<?php

$permission_config['menu_product']['title'] = '商品';

$permission_config['menu_product']['data'][] = array('title' => '发布商品',     'php'=> 'product_add.php',         'display' => 'true');

$permission_config['menu_product']['data'][] = array('title' => '商品',         'php'=> 'product.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '商品新增',     'php'=> 'product_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品修改',     'php'=> 'product_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品删除',     'php'=> 'product_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品删除更多', 'php'=> 'product_delete_more.php', 'display' => 'none');



$permission_config['menu_product']['data'][] = array('title' => '商品分类',         'php'=> 'category.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '商品分类新增',     'php'=> 'category_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品分类修改',     'php'=> 'category_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品分类删除',     'php'=> 'category_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品分类删除更多', 'php'=> 'category_delete_more.php', 'display' => 'none');

$permission_config['menu_product']['data'][] = array('title' => '商品品牌',         'php'=> 'brand.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '商品品牌新增',     'php'=> 'brand_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品品牌修改',     'php'=> 'brand_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品品牌删除',     'php'=> 'brand_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品品牌删除更多', 'php'=> 'brand_delete_more.php', 'display' => 'none');


$permission_config['menu_product']['data'][] = array('title' => '商品规格',         'php'=> 'specification.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '商品规格新增',     'php'=> 'specification_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品规格修改',     'php'=> 'specification_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品规格删除',     'php'=> 'specification_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品规格删除更多', 'php'=> 'specification_delete_more.php', 'display' => 'none');


$permission_config['menu_product']['data'][] = array('title' => '运费设置',         'php'=> 'postage_config.php',             'display' => 'block');
$permission_config['menu_product']['data'][] = array('title' => '运费设置新增',     'php'=> 'postage_config_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '运费设置修改',     'php'=> 'postage_config_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '运费设置删除',     'php'=> 'postage_config_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品规格删除更多', 'php'=> 'postage_config_delete_more.php', 'display' => 'none');


$permission_config['menu_product']['data'][] = array('title' => '商品回收站',         'php'=> 'product_recycle_bin_lists.php',             'display' => 'block');


$permission_config['menu_order']['title'] = '订单';

$permission_config['menu_order']['data'][] = array('title' => '订单管理',         'php'=> 'order_info.php',             'display' => 'block');
$permission_config['menu_order']['data'][] = array('title' => '订单管理新增',     'php'=> 'order_info_add.php',         'display' => 'none');
$permission_config['menu_order']['data'][] = array('title' => '订单管理修改',     'php'=> 'order_info_modify.php',      'display' => 'none');
$permission_config['menu_order']['data'][] = array('title' => '订单管理删除',     'php'=> 'order_info_delete.php',      'display' => 'none');
$permission_config['menu_order']['data'][] = array('title' => '订单管理删除更多', 'php'=> 'order_info_delete_more.php', 'display' => 'none');

$permission_config['menu_user']['title'] = '客户';

$permission_config['menu_user']['data'][] = array('title' => '客户管理',         'php'=> 'user.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '客户管理新增',     'php'=> 'user_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户管理修改',     'php'=> 'user_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户管理删除',     'php'=> 'user_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户管理删除更多', 'php'=> 'user_delete_more.php', 'display' => 'none');

$permission_config['menu_user']['data'][] = array('title' => '客户地址', 'php'=> 'user_address.php', 'display' => 'none');



$permission_config['menu_user']['data'][] = array('title' => '客户第三方信息',         'php'=> 'open_user.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '客户第三方信息删除',     'php'=> 'open_user_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户管理删除更多', 'php'=> 'open_user_delete_more.php', 'display' => 'none');




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