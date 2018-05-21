var md5 = require('../utils/md5.js');
//md5.hexMD5('123')
var util = {
  host: 'https://mall.huaban1314.com/api',
  version: 1,
  isFirst: true,
  //时间
  formatTime: function (date) {
    var year = date.getFullYear()
    var month = date.getMonth() + 1
    var day = date.getDate()
    var hour = date.getHours()
    var minute = date.getMinutes()
    var second = date.getSeconds()

    return [year, month, day].map(this.formatNumber).join('/') + ' ' + [hour, minute, second].map(this.formatNumber).join(':')
  },
  formatNumber: function (n) {
    n = n.toString()
    return n[1] ? n : '0' + n
  },
  randomNum: function (num) {
    var numStr = '';
    var tempNum = num || 4;
    while (tempNum > 0) {
      numStr = numStr + '' + parseInt(Math.random() * 10);
      tempNum--;
    }
    return numStr;
  },
  noOpen: function (msg, cal) {
    wx.showModal({
      title: '提示',
      content: !!msg ? msg : '抱歉，此功能暂未开通',
      showCancel: false,
      success: function (res) {
        if (res.confirm) {
          console.log('用户点击确定')
        }
        try {
          if (typeof cal == 'function') {
            cal();
          }
        } catch (e) {
        }
      }
    });
  },
  getOpenid: function () {
    // 获取openid
    var _this = util;
    // var req_time = new Date().getTime() + _this.randomNum();//请求接口时间（Unix时间戳+4位的随机数）

  },
  //用于判断空，Undefined String Array Object
  isBlank: function (str){

      if (Object.prototype.toString.call(str) === '[object Undefined]') {//空
        return true
      } else if (
        Object.prototype.toString.call(str) === '[object String]' ||
        Object.prototype.toString.call(str) === '[object Array]') { //字条串或数组
        return str.length == 0 ? true : false
      } else if (Object.prototype.toString.call(str) === '[object Object]') {
        return JSON.stringify(str) == '{}' ? true : false
      } else {
        return true
      }

  },

};

module.exports = util;


