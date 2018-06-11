// pages/user/orderexpressage.js
import {
  order_expressage
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var util = require('../../utils/util');

var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    //物流信息
    order_expressage:{},

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("orderexpreddage onload");
    console.log(options);

    let that = this;

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    //订单列表
    order_expressage(app.globalData.userInfo.user_no, options.order_info_no).then((res) => {
        let arr = res.data.result.data;
        console.log(arr);

        if (res.data.result.status.code == 0) 
        {
          this.setData({
            order_expressage: arr,
          });
        }
        else {
          app.showModal({ content: res.data.result.status.msg });
        }

    });

  },

  //复制订单单号
  copy_order_sn:function(e)
  {
    let order_sn = e.currentTarget.dataset.order_sn;

      wx.setClipboardData({
           data: order_sn,
            success() {
              app.showToast({ title: '复制成功',icon:'success'});
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

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})