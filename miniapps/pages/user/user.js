import { commonAjax, product_detail } from '../../api/request'

var utils = require('../../utils/util.js');
var CommonEvent = require('../common/commonEvent');
var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    isloginshow:false
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    console.log('user onload');
    console.log(app.globalData.userInfo);

    let that = this;
    console.log(that.data.isloginshow);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    this.setData({
      userInfo: app.globalData.userInfo,
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
  
  },

  //微信登录
  onGotUserInfo: function (e) {
    CommonEvent.login(e);

    console.log('登录完成');
    console.log(app.globalData.userInfo);

    this.setData({
      isloginshow: false,
    });

    let page = getCurrentPages().pop();
    if (page == undefined || page == null) return;
    page.onLoad();


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