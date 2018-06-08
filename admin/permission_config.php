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



$permission_config['menu_product']['data'][] = array('title' => '商品属性',         'php'=> 'product_attr.php',             'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品属性新增',     'php'=> 'product_attr_add.php',         'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品属性修改',     'php'=> 'product_attr_modify.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品属性删除',     'php'=> 'product_attr_delete.php',      'display' => 'none');
$permission_config['menu_product']['data'][] = array('title' => '商品属性删除更多', 'php'=> 'product_attr_delete_more.php', 'display' => 'none');



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


$permission_config['menu_user']['data'][] = array('title' => '标签管理',         'php'=> 'user_label.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '标签管理新增',     'php'=> 'user_label_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '标签管理修改',     'php'=> 'user_label_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '标签管理删除',     'php'=> 'user_label_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '标签管理删除更多', 'php'=> 'user_label_delete_more.php', 'display' => 'none');



$permission_config['menu_user']['data'][] = array('title' => '设置优惠券',         'php'=> 'discount_coupon_record.php',             'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置优惠券新增',     'php'=> 'discount_coupon_record_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置优惠券修改',     'php'=> 'discount_coupon_record_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置优惠券删除',     'php'=> 'discount_coupon_record_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置优惠券删除更多', 'php'=> 'discount_coupon_record_delete_more.php', 'display' => 'none');


$permission_config['menu_user']['data'][] = array('title' => '设置会员卡',         'php'=> 'user_cards_record.php',             'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置会员卡新增',     'php'=> 'user_cards_record_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置会员卡修改',     'php'=> 'user_cards_record_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置会员卡删除',     'php'=> 'user_cards_record_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '设置会员卡删除更多', 'php'=> 'user_cards_record_delete_more.php', 'display' => 'none');


$permission_config['menu_user']['data'][] = array('title' => '热门搜索',         'php'=> 'hot_search.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '热门搜索新增',     'php'=> 'hot_search_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '热门搜索修改',     'php'=> 'hot_search_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '热门搜索删除',     'php'=> 'hot_search_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '热门搜索删除更多', 'php'=> 'hot_search_delete_more.php', 'display' => 'none');


$permission_config['menu_user']['data'][] = array('title' => '客户搜索',         'php'=> 'search.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '客户搜索新增',     'php'=> 'search_add.php',         'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户搜索修改',     'php'=> 'search_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户搜索删除',     'php'=> 'search_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户搜索删除更多', 'php'=> 'search_delete_more.php', 'display' => 'none');


$permission_config['menu_user']['data'][] = array('title' => '客户意见反馈',         'php'=> 'suggest.php',             'display' => 'block');
$permission_config['menu_user']['data'][] = array('title' => '客户意见反馈修改',     'php'=> 'suggest_modify.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户意见反馈删除',     'php'=> 'suggest_delete.php',      'display' => 'none');
$permission_config['menu_user']['data'][] = array('title' => '客户意见反馈删除更多', 'php'=> 'suggest_delete_more.php', 'display' => 'none');



$permission_config['menu_posid']['title'] = '推荐位';

$permission_config['menu_posid']['data'][] = array('title' => '轮播图',         'php'=> 'slideshow.php',             'display' => 'block');
$permission_config['menu_posid']['data'][] = array('title' => '轮播图新增',     'php'=> 'slideshow_add.php',         'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '轮播图修改',     'php'=> 'slideshow_modify.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '轮播图删除',     'php'=> 'slideshow_delete.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '轮播图删除更多', 'php'=> 'slideshow_delete_more.php', 'display' => 'none');

$permission_config['menu_posid']['data'][] = array('title' => '广告位',         'php'=> 'slideshow_ad.php',             'display' => 'block');
$permission_config['menu_posid']['data'][] = array('title' => '广告位新增',     'php'=> 'slideshow_ad_add.php',         'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '广告位修改',     'php'=> 'slideshow_ad_modify.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '广告位删除',     'php'=> 'slideshow_ad_delete.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '广告位删除更多', 'php'=> 'slideshow_ad_delete_more.php', 'display' => 'none');


$permission_config['menu_posid']['data'][] = array('title' => '推荐位',         'php'=> 'recommend.php',             'display' => 'block');
$permission_config['menu_posid']['data'][] = array('title' => '推荐位新增',     'php'=> 'recommend_add.php',         'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '推荐位修改',     'php'=> 'recommend_modify.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '推荐位删除',     'php'=> 'recommend_delete.php',      'display' => 'none');
$permission_config['menu_posid']['data'][] = array('title' => '推荐位删除更多', 'php'=> 'recommend_delete_more.php', 'display' => 'none');





$permission_config['menu_marketing']['title'] = '营销';

$permission_config['menu_marketing']['data'][] = array('title' => '会员卡',         'php'=> 'user_cards.php',             'display' => 'block');
$permission_config['menu_marketing']['data'][] = array('title' => '会员卡新增',     'php'=> 'user_cards_add.php',         'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '会员卡修改',     'php'=> 'user_cards_modify.php',      'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '会员卡删除',     'php'=> 'user_cards_delete.php',      'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '会员卡删除更多', 'php'=> 'user_cards_delete_more.php', 'display' => 'none');

$permission_config['menu_marketing']['data'][] = array('title' => '优惠券',         'php'=> 'discount_coupon.php',             'display' => 'block');
$permission_config['menu_marketing']['data'][] = array('title' => '优惠券新增',     'php'=> 'discount_coupon_add.php',         'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '优惠券修改',     'php'=> 'discount_coupon_modify.php',      'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '优惠券删除',     'php'=> 'discount_coupon_delete.php',      'display' => 'none');
$permission_config['menu_marketing']['data'][] = array('title' => '优惠券删除更多', 'php'=> 'discount_coupon_delete_more.php', 'display' => 'none');





$permission_config['menu_article']['title'] = '图文';

$permission_config['menu_article']['data'][] = array('title' => '图文',         'php'=> 'article.php',             'display' => 'block');
$permission_config['menu_article']['data'][] = array('title' => '图文新增',     'php'=> 'article_add.php',         'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文修改',     'php'=> 'article_modify.php',      'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文删除',     'php'=> 'article_delete.php',      'display' => 'none');
$permission_config['menu_article']['data'][] = array('title' => '图文删除更多', 'php'=> 'article_delete_more.php', 'display' => 'none');




$permission_config['menu_admin']['title'] = '基本配置';
$permission_config['menu_admin']['data'][] = array('title' => '系统配置','php'=> 'system_config_modify.php', 'display' => 'block');


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