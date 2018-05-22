import {
  discount_coupon_record
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');
var util = require('../../utils/util');

var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    //控制显示load
    load_show: true,

    //优惠券
    couponlists:{},

    scrollTop : 0,
    scrollHeight: 0,
    page: 1,

    //可用优惠券，已失效，类型
    type:1
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    let that = this;

    //重新设置type的值
    if ( !util.isBlank(options.type) ) 
    {
      this.setData({
        type: options.type,
      })
    }

    console.log("coupon type="+that.data.type);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

     wx.getSystemInfo({
         success:function(res){
             that.setData({
                 scrollHeight:res.windowHeight
             });
         }
     });
     
     //优惠券
     discount_coupon_record(that.data.page, app.globalData.userInfo.user_no, that.data.type).then((res) => {
       let arr = res.data.result.data;
       this.setData({
         couponlists: arr,
       })
     });
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

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    console.log('下拉刷新～');
    let that = this;

    //设置分页数据
    that.setData({
      page: that.data.page + 1
    });

    discount_coupon_record(that.data.page, app.globalData.userInfo.user_no, that.data.type).then((res) => {
      let arr = res.data.result.data;

      console.log(arr);

      if (util.isBlank(arr)) 
      {
        that.setData({
          load_show: false,
        });
      }
      else
      {
        that.setData({
          load_show: true,
        });
      }

      let newarr = that.data.couponlists.concat(arr);
      console.log(newarr);
      that.setData({
        couponlists: newarr
      })
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
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})