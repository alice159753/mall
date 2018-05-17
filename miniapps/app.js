//app.js
App({
  onLaunch: function () {
    // 展示本地存储能力
    //var logs = wx.getStorageSync('logs') || []
    //logs.unshift(Date.now())
    //wx.setStorageSync('logs', logs)

    console.log("app js 登录开始");

    // 登录,注册
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
        if (res.code) {
          // 获取用户信息
          wx.getSetting({
            success: resSetting => {

              console.log("获取用户信息成功1");
              console.log(resSetting);

              //resSetting.authSetting['scope.userInfo']
              if (true) {
                // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
                wx.getUserInfo({
                  success: resUserInfo => {

                    console.log("获取用户信息成功2");

                    resUserInfo.userInfo.code = res.code;

                    this.globalData.userInfo = resUserInfo.userInfo

                    console.log(resUserInfo);

                    let that = this;

                    //发起网络请求
                    wx.request({
                      url: 'https://mall.huaban1314.com/api/weixin_login.php',
                      data: resUserInfo.userInfo,
                      header: { 'content-type': 'application/json' },
                      success: function (res) {
                        console.log("注册返回的数据" + res.data);
                        console.log(res.data);

                        that.globalData.userInfo.user_no = res.data.result.data.no;

                        console.log(that.globalData.userInfo);

                      }

                    });

                    // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回,所以此处加入 callback 以防止这种情况
                    if (this.userInfoReadyCallback) {
                      this.userInfoReadyCallback(resUserInfo)
                    }

                  }
                })
              }
            }
          })
        }
        else {
          console.log('获取用户登录态失败！' + res.errMsg);
        }
      }


    })
  },
  //app.globalData.userInfo.no //user_no
  globalData: {
    userInfo: null,
    globalNameOne: "花伴电商",
    globalShareTitle: "花伴电商",

  },

})