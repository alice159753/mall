import {
  user_footprint
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');
var util = require('../../utils/util');

var app = getApp();


// pages/user/footprint.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    
    //足迹
    user_footprint_lists:[],

    //控制显示load
    load_show: true,
    scrollTop: 0,
    scrollHeight: 0,
    page:1,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("fontprint load");

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

    //我的足迹
    user_footprint(that.data.page, app.globalData.userInfo.user_no).then((res) => {
      let arr = res.data.result.data;
      this.setData({
        user_footprint_lists: arr,
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

    user_footprint(that.data.page, app.globalData.userInfo.user_no).then((res) => {
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

      let newarr = that.data.user_footprint_lists.concat(arr);
      console.log(newarr);
      that.setData({
        user_footprint_lists: newarr
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