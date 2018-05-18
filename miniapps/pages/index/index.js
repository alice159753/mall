import {
  slideshow, category1, recommend, article, discount_coupon,slideshow_ad
 } from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();

Page({
  data: {
    //首页轮播图
    swiperlists: [],

    //首页一级分类
    category1list: [],   

    //首页推荐位
    recommend: [],

    //动态
    article: [],

    //优惠券
    discount_coupon: [],
  
    //广告
    slideshow_ad: [],
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    wx.showToast({ //显示消息提示框  此处是提升用户体验的作用
      title: '数据加载中',
      icon: 'loading',
    });

    console.log('index onload');
    CommonEvent.login();

    //设置导航条名称
    wx.setNavigationBarTitle({
      title: app.globalData.globalNameOne
    });

    //首页轮播图
    slideshow().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        swiperlists: arr,
      })
    });

    //首页一级分类
    category1().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        category1list: arr,
      })
    });

    //优惠券
    discount_coupon().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        discount_coupon: arr,
      })
    });


    //首页推荐位
    recommend().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        recommend: arr,
      })
    });

    //动态
    article().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        article: arr,
      })
    });


    //广告
    slideshow_ad().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        slideshow_ad: arr,
      })
    });


  },
  
})
