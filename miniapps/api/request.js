var util = require('../utils/util');
var md5 = require('../utils/md5.js');

function newWork(options) {
  var tempOptions = {
    url: options.url || '',
    data: options.data || {},
    header: options.header || { 'content-type': 'application/json' },
    method: options.method || 'GET',
  };

  console.log(tempOptions);

  if (!!tempOptions.method && tempOptions.method.toLowerCase() == 'POST'.toLowerCase() && !options.header) {
    tempOptions.header = {
      "content-type": "application/x-www-form-urlencoded"
    };
  }
  return new Promise((resolve) => {
      if (!!tempOptions.data.isUser) {
        tempOptions.data.user_id = sucData.user_id;//用户ID【1.01版本新增】
      }
      tempOptions.data.req_time = new Date().getTime() + util.randomNum();
      
      wx.request({
        url: '' + util.host + tempOptions.url,
        data: tempOptions.data,
        header: tempOptions.header,
        method: tempOptions.method,
        success: function (res) {
          resolve(res);
        }
      });
    });
}

export function commonAjax(options) {
  return newWork(options);
}

//首页，轮播图
export function slideshow() {
  return newWork({
    url: '/slideshow.php',
    data: {
    }
  });
}


//首页一级分类
export function category1() {
  return newWork({
    url: '/category1.php',
    data: {
    }
  });
}


//首页推荐位
export function recommend() {
  return newWork({
    url: '/recommend.php',
    data: {
    }
  });
}


//动态
export function article(article_no = 0) {
  return newWork({
    url: '/article.php',
    data: {
      article_no: article_no,
    }
  });
}


//优惠券
export function discount_coupon() {
  return newWork({
    url: '/discount_coupon.php',
    data: {
    }
  });
}

//广告
export function slideshow_ad() {
  return newWork({
    url: '/slideshow_ad.php',
    data: {
    }
  });
}

//商品列表
export function product(page, category_no_1 = 0, order = 'sale_num desc') {
  return newWork({
    url: '/product.php',
    data: {
      page: page,
      category_no_1: category_no_1,
      order: order,
    }
  });
}

//商品详情
export function product_detail(user_no, product_no) {
  return newWork({
    url: '/product_detail.php?user_no=' + user_no + "&product_no=" + product_no,
    data: {
    }
  });
}


//领取优惠券
export function discount_coupon_add(user_no, discount_coupon_no) {
  return newWork({
    url: '/discount_coupon_add.php?user_no=' + user_no + "&discount_coupon_no=" + discount_coupon_no,
    data: {
    }
  });
}

//意见反馈
export function suggest(user_no, content) {
  return newWork({
    url: '/suggest.php',
    data: {
      user_no: user_no,
      content: content,
    }
  });
}



//获取客户优惠券信息，//1 可使用，2已过期，已使用
export function discount_coupon_record(page, user_no, type) {
  return newWork({
    url: '/discount_coupon_record.php',
    data: {
      page: page,
      user_no: user_no,
      type: type,
    }
  });
}


//系统配置
export function system_config() {
  return newWork({
    url: '/system_config.php',
  });
}


//加入购物车
export function user_carts_add_make(user_no, product_no, product_attr_no, buy_num) {
  return newWork({
    url: '/user_carts_add_make.php',
    data: {
      user_no: user_no,
      product_no: product_no,
      product_attr_no: product_attr_no,
      buy_num: buy_num,
    }
  });
}



//用户购物车列表
export function user_carts(user_no) {
  return newWork({
    url: '/user_carts.php',
    data: {
      user_no: user_no,
    }
  });
}



//删除购物车
export function user_carts_delete(user_no, user_carts_no) {
  return newWork({
    url: '/user_carts_delete.php',
    data: {
      user_no: user_no,
      user_carts_no: user_carts_no,
    }
  });
}



//结算
export function order_confirm(user_no, user_carts_nos) {
  return newWork({
    url: '/order_confirm.php',
    data: {
      user_no: user_no,
      user_carts_nos: user_carts_nos,
    }
  });
}


//添加新地址
export function user_address_add(user_no, chooseAddress) {
  return newWork({
    url: '/user_address_add.php',
    data: {
      user_no: user_no,
      consignee: chooseAddress.userName,
      zipcode: chooseAddress.postalCode,
      province: chooseAddress.provinceName,
      city: chooseAddress.cityName,
      district: chooseAddress.countyName,
      address: chooseAddress.detailInfo,
      country: chooseAddress.nationalCode,
      tel: chooseAddress.telNumber,
    }
  });
}


//下单
export function order_make(user_no, openid, user_carts_nos, discount_coupon_no, user_address_no) {
  return newWork({
    url: '/order_make.php',
    data: {
      user_no: user_no,
      user_carts_nos: user_carts_nos,
      discount_coupon_no: discount_coupon_no,
      openid: openid,
      user_address_no: user_address_no,
    }
  });
}


//文章详细
export function article_detail(article_no) {
  return newWork({
    url: '/article_detail.php',
    data: {
      article_no: article_no,
    }
  });
}


//我的足迹
export function user_footprint(page, user_no) {
  return newWork({
    url: '/user_footprint.php',
    data: {
      page: page,
      user_no: user_no,
    }
  });
}



//用户收藏
export function user_collect(page, user_no, collect_type) {
  return newWork({
    url: '/user_collect.php',
    data: {
      page: page,
      user_no: user_no,
      collect_type: collect_type,
    }
  });
}


//会员卡列表
export function user_cards_record(page, user_no) {
  return newWork({
    url: '/user_cards_record.php',
    data: {
      page: page,
      user_no: user_no,
    }
  });
}

//会员卡详细
export function user_cards(user_no,user_cards_record_no) {
  return newWork({
    url: '/user_cards.php',
    data: {
      user_no: user_no,
      user_cards_record_no: user_cards_record_no,
    }
  });
}


//删除会员卡
export function user_cards_record_delete(user_no, user_cards_record_no) {
  return newWork({
    url: '/user_cards_record_delete.php',
    data: {
      user_no: user_no,
      user_cards_record_no: user_cards_record_no,
    }
  });
}

//设置默认会员卡
export function user_cards_record_default(user_no, user_cards_record_no) {
  return newWork({
    url: '/user_cards_record_default.php',
    data: {
      user_no: user_no,
      user_cards_record_no: user_cards_record_no,
    }
  });
}

//订单列表
export function order_info(page, user_no, order_type) {
  return newWork({
    url: '/order_info.php',
    data: {
      page: page,
      user_no: user_no,
      order_type: order_type,
    }
  });
}


//取消订单
export function order_cancel(user_no, order_info_no) {
  return newWork({
    url: '/order_cancel.php',
    data: {
      user_no: user_no,
      order_info_no: order_info_no,
    }
  });
}


//确认收货
export function order_receiving(user_no, order_info_no) {
  return newWork({
    url: '/order_receiving.php',
    data: {
      user_no: user_no,
      order_info_no: order_info_no,
    }
  });
}


//申请收货
export function order_refound(user_no, order_info_no, sales_return_note) {
  return newWork({
    url: '/order_refound.php',
    data: {
      user_no: user_no,
      order_info_no: order_info_no,
      sales_return_note: sales_return_note,
    }
  });
}


//订单商品列表
export function order_product(user_no, order_info_no) {
  return newWork({
    url: '/order_product.php',
    data: {
      user_no: user_no,
      order_info_no: order_info_no,
    }
  });
}


//评价
export function order_review(user_no, order_info_no, contents, stars, isanons, productnos) {
  return newWork({
    url: '/order_review.php',
    data: {
      user_no: user_no,
      order_info_no: order_info_no,
      contents: contents,
      stars: stars,
      isanons: isanons,
      productnos: productnos
    }
  });
}