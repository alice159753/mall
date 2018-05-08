import { commonAjax, register } from '../../api/request'
var utils = require('../../utils/util.js');
let app = getApp();

function CommonEvent() {
  var cur = arguments[0];
  var userInfo = {};
  var hasUserInfo = false;
  var canIUse = wx.canIUse('button.open-type.getUserInfo');
};

export function login()
{
    


  if (app.globalData.userInfo) {
  }
  else if (this.canIUse) {
    // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
    // 所以此处加入 callback 以防止这种情况
    app.userInfoReadyCallback = res => {
      app.globalData.userInfo = res.userInfo
    }
  }
  else {
    // 在没有 open-type=getUserInfo 版本的兼容处理
    wx.getUserInfo({
      success: res => {
        app.globalData.userInfo = res.userInfo

        console.log(app.globalData.userInfo);

        //注册用户
       // utils.register(app.globalData.userInfo);
      }
    })
  }

}


//module.exports = CommonEvent;