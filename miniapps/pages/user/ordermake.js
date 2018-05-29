// pages/user/carts.js
import {
  user_carts, user_carts_delete
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();

// pages/user/ordermake.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //收货人地址
    chooseAddress:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("ordermake onload");
    console.log("app.globalUserCarts");

    //购物车列表商品
    console.log(app.globalUserCarts);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }


  },

  //选择地址
  chooseAddress:function (){

    wx.chooseAddress({
      success: function (res) {
        console.log(res.userName);
        console.log(res.postalCode);
        console.log(res.provinceName);
        console.log(res.cityName);
        console.log(res.countyName);
        console.log(res.detailInfo);
        console.log(res.nationalCode);
        console.log(res.telNumber);

        this.setData({
          chooseAddress: res,
        });

      }
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