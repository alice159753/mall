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
export function article() {
  return newWork({
    url: '/article.php',
    data: {
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