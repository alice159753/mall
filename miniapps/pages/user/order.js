import {
  order_info, order_cancel, order_receiving, order_pay, wechat_callback
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var util = require('../../utils/util');

var app = getApp();

function load_more(that)
{
    console.log('下拉刷新～');

    //设置分页数据
    that.setData({
      page: that.data.page + 1
    });

    order_info(that.data.page, app.globalData.userInfo.user_no, that.data.order_type).then((res) => {
      let arr = res.data.result.data;

      console.log(arr);

      if (util.isBlank(arr)) {
        that.setData({
          load_show: false,
        });
      }
      else {
        that.setData({
          load_show: true,
        });
      }

      let newarr = that.data.orderlists.concat(arr);
      console.log(newarr);
      that.setData({
        orderlists: newarr
      })

    })
}


// pages/user/order.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

    //订单列表
    orderlists: [],
    order_type:'all',
    
    //是否展示空
    is_empty:false,

    load_show: true,
    scrollTop: 0,
    scrollHeight: 0,
    page: 1,

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('order onload');

    let that = this;

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });

    if ( util.isBlank(options) )
    {
      options.order_type = that.data.order_type;
    }

    if ( util.isBlank(options.order_type) )
    {
      options.order_type = that.data.order_type;
    }

    //订单列表
    order_info(that.data.page, app.globalData.userInfo.user_no, options.order_type).then((res) => {
      let arr = res.data.result.data;
      
      let is_empty = this.data.is_empty;

      if ( arr.length == 0 )
      {
        is_empty = true;
      }

      this.setData({
        orderlists: arr,
        order_type: options.order_type,
        is_empty: is_empty,
      });

    });

  },

  //切换tab
  changeTab:function(e){
    var order_type = e.currentTarget.dataset.order_type;

    console.log("order_type=" + order_type);

    this.setData({
      page:1,
      order_type: order_type,
      is_empty:false,

    });

    //订单列表
    order_info(1, app.globalData.userInfo.user_no, order_type).then((res) => {
      let arr = res.data.result.data;

      let is_empty = this.data.is_empty;

      console.log("length="+arr.length);
      console.log("is_empty=" + is_empty);

      if (arr.length == 0 ) 
      {
        is_empty = true;
      }

      this.setData({
        orderlists: arr,
        is_empty: is_empty,

      });

    });

  },

  //取消订单
  order_cancel:function (e){
    var order_info_no = e.currentTarget.dataset.order_info_no;

    if ( util.isBlank(order_info_no) )
    {
       app.showModal({ content: '订单编号不能为空' });

       return '';
    }

    order_cancel(app.globalData.userInfo.user_no, order_info_no).then((res) => {
      let arr = res.data.result.data;

      if ( res.data.result.status.code == 0 )
      {
        //重新加载页面
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        let options = {};
        page.onLoad(options);
      }
      else
      {
        app.showModal({ content: res.data.result.status.msg });
      }

    });

  },

  //确认收货
  order_receiving: function (e) {
    var order_info_no = e.currentTarget.dataset.order_info_no;

    if (util.isBlank(order_info_no)) {
      app.showModal({ content: '订单编号不能为空' });

      return '';
    }

    order_cancel(app.globalData.userInfo.user_no, order_info_no).then((res) => {
      let arr = res.data.result.data;

      if (res.data.result.status.code == 0) {

        app.showToast({ title: '确认收货成功',icon:'none' });

        //重新加载页面
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        let options = {};
        page.onLoad(options);
      }
      else {
        app.showModal({ content: res.data.result.status.msg });
      }

    });

  },

  //查看物流
  order_expressage:function(e)
  {
    var order_info_no = e.currentTarget.dataset.order_info_no;

      if (util.isBlank(order_info_no)) {
        app.showModal({ content: '订单编号不能为空' });

        return '';
      }

      wx.navigateTo({
        url: '../user/orderexpressage?order_info_no=' + order_info_no,
      })
  },

  //微信登录
  onGotUserInfo: function (e) {
    CommonEvent.login(e);

    console.log('登录完成');
    console.log(app.globalData.userInfo);

    this.setData({
      isloginshow: false,
    })
  },

  //关闭微信登录
  closetip: function () {
    this.setData({
      isloginshow: false,
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var page = getCurrentPages().pop();
    if (page == undefined || page == null) return;
    page.onLoad([]);

  },

  //订单信息
  order_pay:function(e){
    var order_info_no = e.currentTarget.dataset.order_info_no;

    order_pay(app.globalData.userInfo.user_no, order_info_no).then((res) => {
      let arr = res.data.result.data;

      var param = arr;
      console.log(param);

      param.success = function () {
        console.log("支付成功");
        app.showModal({ content: '支付成功' });
        console.log(res);
        //通知服务器,支付成功
        wechat_callback(app.globalData.userInfo.user_no, param.order_sn).then((res) => {
        });
      };

      param.fail = function () {
        console.log("支付失败");
        app.showModal({ content: '支付失败' });
      };

      app.wxPay(param);


    });

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  //下一页
  loadMore: function () {
    load_more(this);
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    load_more(this);
  },


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})