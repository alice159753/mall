import {
  product_detail
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();


// pages/product/product.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //商品详情
    product_detail: [],

    //商品详情是否展示
    isproductdetailshow: false,

    //是否展示规格
    isshowguige:false,

    //是否展示购物车
    isshowcarts: true,

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
    console.log('product onload');
    console.log("options");
    console.log(options);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    //商品详情
    product_detail(app.globalData.userInfo.user_no, options.product_no).then((res) => {
      
      let arr = res.data.result.data;
      this.setData({
        product_detail: arr,
      });

      //设置导航条名称
      wx.setNavigationBarTitle({
        title: arr.title
      });

    });

  },

  /**
   * 商品详情是否展示
   */
  traggle_product_detail_show:function(){

     if( this.data.isproductdetailshow ) 
     {
       this.setData({
         isproductdetailshow: false,
       });
     }
     else
     {
       this.setData({
         isproductdetailshow: true,
       });
     }
  },

  //点击分类跳转到分类详情
  changeTab: function (event) {
    let title = event.currentTarget.dataset.title;
    let category_no_1 = event.currentTarget.dataset.category_no;

    app.globalData.category.title = title;
    app.globalData.category.category_no_1 = category_no_1;

    //切换switchTab以后不刷新tab解决方案
    wx.switchTab({
      url: '../product/productlists',
      complete: function (e) {
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        page.onLoad();
      }
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

  traggle_guige:function (){
    //如果当前展示的是规格页面
    if (this.data.isshowguige)
    {
      this.setData({
        isshowguige: false,
        isshowcarts: true,
      })
    }
    else
    {
      this.setData({
        isshowguige: true,
        isshowcarts: false,
      })
    }

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})