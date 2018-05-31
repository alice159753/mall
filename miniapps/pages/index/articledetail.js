var WxParse = require('../../wxParse/wxParse.js');

import {
  article_detail, article
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();


Page({
  data: {
    //文章
    article_detail: [],

    //相关推荐
    article_lists:[],
    
  },
  onLoad: function (options) {
    console.log("articledetail onload");

    var that = this;

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    //动态详情
    article_detail(options.article_no).then((res) => {
      let arr = res.data.result.data;

      if (res.data.result.status.code != 0) {
        app.showModal({ content: res.data.result.status.msg });
      }

      WxParse.wxParse('content', 'html', arr.content, that, 5);

      that.setData({
        article_detail: arr,
      })
    });

    //相关推荐
    article(options.article_no).then((res) => {
      let arr = res.data.result.data;

      if (res.data.result.status.code != 0) {
        app.showModal({ content: res.data.result.status.msg });
      }

      that.setData({
        article_lists: arr,
      })
    });

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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }

})
