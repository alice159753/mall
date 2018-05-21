import {
  slideshow, category1, recommend, article, discount_coupon, slideshow_ad, discount_coupon_add
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

    //是否
    isloginshow : false,
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
    console.log(app.globalData.userInfo);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }
    
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
  closetip: function() {
    this.setData({
      isloginshow: false,
    })
  },


  //领取优惠券
  get_discount_coupon: function (event) {
    console.log("领取优惠券");
    console.log(event);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) 
    {
      this.setData({
        isloginshow: true,
      })
    }
    else
    {
      let discount_coupon_no = event.currentTarget.dataset.discount_coupon_no;
      //领取优惠券
       discount_coupon_add(app.globalData.userInfo.user_no, discount_coupon_no).then((res) => {
        console.log("领取优惠券result");
        console.log(res);

        if ( res.data.result.status.code == 0 )
        {
          wx.showToast({
            title: '领取成功',
            icon: 'success',
          });
        }
        else
        {
          wx.showToast({ 
            title: res.data.result.status.msg,
            icon: 'none',
          });
        }
      });
    }
  },

  //点击分类跳转到分类详情
  changeTab: function (event)
  {
    let title = event.currentTarget.dataset.title;
    let category_no_1 = event.currentTarget.dataset.category_no;

    app.globalData.category.title = title;
    app.globalData.category.category_no_1 = category_no_1;

    //切换switchTab以后不刷新tab解决方案
    wx.switchTab({
      url: '../product/productlists',
      success: function (e) {
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        page.onLoad();
      }
    });

  },


})
