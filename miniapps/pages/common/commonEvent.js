import { commonAjax, register } from '../../api/request'
var utils = require('../../utils/util.js');
let app = getApp();

let resUserInfo = [];

function CommonEvent() {
  var cur = arguments[0];
  var userInfo = {};
  var hasUserInfo = false;
  var canIUse = wx.canIUse('button.open-type.getUserInfo');
};

export function login(e)
{
  console.log(e.detail.errMsg);
  console.log(e.detail.userInfo);

  resUserInfo.userInfo = e.detail.userInfo;

  console.log("commonEvent login");
  console.log(this.canIUse);

  if (app.globalData.userInfo) 
  {
  }
  else if (this.canIUse) 
  {
    // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
    // 所以此处加入 callback 以防止这种情况
    app.userInfoReadyCallback = res => {
      app.globalData.userInfo = res.userInfo
    }
  }
  else 
  {
    wx.login({
      fail: res => {
        console.log("获取用户登录res.code失败fail");
        console.log(res);
      },
      complete: res => {
        console.log("获取用户登录res.code complete");
        console.log(res);
      },
      success: res => {

        console.log("获取用户登录res.code成功=" + res.code);

        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        if (res.code) 
        {
              resUserInfo.userInfo.code = res.code;

              app.globalData.userInfo = resUserInfo.userInfo

              console.log(resUserInfo);

            //发起网络请求
            wx.request({
               url: 'https://mall.huaban1314.com/api/weixin_login.php',
               data: resUserInfo.userInfo,
               header: { 'content-type': 'application/json' },
                success: function (res) 
                {
                    console.log("注册返回的数据" + res.data);
                    console.log(res.data);

                    app.globalData.userInfo.user_no = res.data.result.data.no;

                    console.log(app.globalData.userInfo);
                }
             });
       }
        
      }

    })
  }

}


//module.exports = CommonEvent;