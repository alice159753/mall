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
  console.log("commonEvent login");
  console.log(this.canIUse);


  if (app.globalData.userInfo) 
  {
    console.log("1");
  }
  else if (this.canIUse) 
  {
    console.log("2");

    // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
    // 所以此处加入 callback 以防止这种情况
    app.userInfoReadyCallback = res => {
      app.globalData.userInfo = res.userInfo
    }
  }
  else 
  {
    console.log("3");

    // 在没有 open-type=getUserInfo 版本的兼容处理
    wx.getUserInfo({
      success: res => {
        app.globalData.userInfo = res.userInfo

        console.log("commonEvent login getUserInfo succ");
        console.log(app.globalData.userInfo);
      },

      fail:res=>{
        console.log("commonEvent login getUserInfo fail");
      }

    })
  }

}


//module.exports = CommonEvent;