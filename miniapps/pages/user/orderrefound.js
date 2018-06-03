import { commonAjax, order_refound } from '../../api/request'

var util = require('../../utils/util.js');
var CommonEvent = require('../common/commonEvent');
var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    tempTotalNum: 250,
    totalNum: 250,

    //订单编号
    order_info_no:0,

  },
  changeInput: function (e) {
    this.setData({
      totalNum: this.data.tempTotalNum - e.detail.value.length
    });
  },

  formSubmit: function (e) {
    if (e.detail.value.sales_return_note.length <= 0) {
      wx.showModal({
        title: '提示',
        content: '输入您的退款理由及联系方式',
        showCancel: false,
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定')
          }
        }
      });
      return false;
    }

    order_refound(app.globalData.userInfo.user_no, this.data.order_info_no,e.detail.value.sales_return_note).then((json) => {
      if (json.data.result.status.code == 0) {
        util.noOpen('申请退款成功', function () {
          setTimeout(() => {
            wx.navigateBack({
              delta: 1, // 回退前 delta(默认为1) 页面
            });
          }, 100)
        });
      } else {
        wx.showModal({
          title: '提示',
          content: json.data.result.status.msg,
          showCancel: false,
          success: function (res) {
            if (res.confirm) {
              console.log('用户点击确定')
            }
          }
        });
      }
    });
  },


  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("orderrefound onload");
    console.log("order_info_no=" + options.order_info_no);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    this.setData({
      order_info_no: options.order_info_no
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
    return {
      title: app.globalData.globalShareTitle,
      success: function (res) {
        // 转发成功
      },
      fail: function (res) {
        // 转发失败
      }
    }
  }

})