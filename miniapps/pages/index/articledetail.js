import {
  article_detail
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();

var WxParse = require('../../wxParse/wxParse.js')




Page({

  /**
   * 页面的初始数据
   */
  data: {
    //文章
    article:[],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("articledetail onload");

    console.log(options);

    var article = '<div>这里是html数据</div>';

    var that = this;
    WxParse.wxParse('article', 'html', article, that, 5);  

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    //动态
    article_detail(options.article_no).then((res) => {
      let arr = res.data.result.data;

      if ( res.data.result.status.code != 0 )
      {
        app.showModal({ content: res.data.result.status.msg  });
      }

      this.setData({
        article: arr,
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