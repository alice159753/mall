import { commonAjax, suggest } from '../../api/request'

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

  },
  changeInput: function (e) {
    this.setData({
      totalNum: this.data.tempTotalNum - e.detail.value.length
    });
  },

  formSubmit: function (e) {
    if (e.detail.value.wrong_content.length <= 0) {
      wx.showModal({
        title: '提示',
        content: '请输入反馈内容',
        showCancel: false,
        success: function (res) {
          if (res.confirm) {
            console.log('用户点击确定')
          }
        }
      });
      return false;
    }

    suggest(app.globalData.userInfo.user_no, e.detail.value.wrong_content).then((json) => {
      if (json.data.result.status.code == 0) {
        util.noOpen('反馈成功', function () {
          setTimeout(() => {
            wx.navigateBack({
              delta: 100, // 回退前 delta(默认为1) 页面
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