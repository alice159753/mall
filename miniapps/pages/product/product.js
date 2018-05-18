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
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
    console.log('product onload');
    CommonEvent.login();

    console.log(app.globalData.userInfo);

    console.log("options");
    console.log(options);

    //首页轮播图
    product_detail(1, options.product_no).then((res) => {
      
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