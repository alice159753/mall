//app.js
App({

  wxPay: function (param) {
    let _this = this;
    wx.requestPayment({
      'timeStamp': param.timeStamp,
      'nonceStr': param.nonceStr,
      'package': param.package,
      'signType': 'MD5',
      'paySign': param.paySign,
      success: function(res){
        _this.wxPaySuccess(param);
        typeof param.success === 'function' && param.success();
      },
      fail: function(res){
        if(res.errMsg === 'requestPayment:fail cancel'){
          typeof param.fail === 'function' && param.fail();
          return;
        }
        if(res.errMsg === 'requestPayment:fail'){
          res.errMsg = '支付失败';
        }
        _this.showModal({
          content: res.errMsg
        })
        _this.wxPayFail(param, res.errMsg);
        typeof param.fail === 'function' && param.fail();
      }
    })
  },
  wxPaySuccess: function (param) {
    let orderId = param.orderId,
        goodsType = param.goodsType,
        formId = param.package.substr(10),
        t_num = goodsType == 1 ? 'AT0104':'AT0009';

    this.sendRequest({
      hideLoading: true,
      url: '/index.php?r=AppShop/SendXcxOrderCompleteMsg',
      data: {
        formId: formId,
        t_num: t_num,
        order_id: orderId
      }
    })
  },
  wxPayFail: function (param, errMsg) {
    let orderId = param.orderId,
        formId = param.package.substr(10);

    this.sendRequest({
      hideLoading: true,
      url: '/index.php?r=AppShop/SendXcxOrderCompleteMsg',
      data: {
        formId: formId,
        t_num: 'AT0010',
        order_id: orderId,
        fail_reason: errMsg
      }
    })
  },


  showModal: function (param) {
    wx.showModal({
      title: param.title || '提示',
      content: param.content,
      showCancel: param.showCancel || false,
      cancelText: param.cancelText || '取消',
      cancelColor: param.cancelColor || '#000000',
      confirmText: param.confirmText || '确定',
      confirmColor: param.confirmColor || '#3CC51F',
      success: function (res) {
        if (res.confirm) {
          typeof param.confirm == 'function' && param.confirm(res);
        } else {
          typeof param.cancel == 'function' && param.cancel(res);
        }
      },
      fail: function (res) {
        typeof param.fail == 'function' && param.fail(res);
      },
      complete: function (res) {
        typeof param.complete == 'function' && param.complete(res);
      }
    })
  },
  showToast: function (param) {
    wx.showToast({
      title: param.title,
      icon: param.icon,
      duration: param.duration || 1500,
      success: function (res) {
        typeof param.success == 'function' && param.success(res);
      },
      fail: function (res) {
        typeof param.fail == 'function' && param.fail(res);
      },
      complete: function (res) {
        typeof param.complete == 'function' && param.complete(res);
      }
    })
  },
  hideToast: function () {
    wx.hideToast();
  },
  
  onLaunch: function () {

  },

  //app.globalData.userInfo.user_no //user_no
  //app.globalData.userInfo.openid //openid
  globalData: {
    userInfo: null,
    globalNameOne: "花伴电商",
    globalShareTitle: "花伴电商",
    category: {
      title:'分类',
      category_no_1:'0',
    },
    globalUserCarts:[],

  },

})