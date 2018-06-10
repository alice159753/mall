import {
  user_cards, system_config, user_cards_record_delete, user_cards_record_default
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');
var util = require('../../utils/util');

var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {

    //会员卡
    user_cards_detail:{},

    //系统配置
    system_config:{},

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("cards onload");
    console.log(options);
    console.log("no=" + options.no);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    //会员卡
    user_cards(app.globalData.userInfo.user_no, options.no).then((res) => {
      let arr = res.data.result.data;

      this.setData({
        user_cards_detail: arr,
      })
    });

    //系统配置
    system_config().then((res) => {
      let arr = res.data.result.data;

      this.setData({
        system_config: arr,
      })
    });

    this.setData({
      userInfo: app.globalData.userInfo,
    })
  },

  delete_cards:function(){
    let no = this.data.user_cards_detail.no;

    wx.showModal({
      title: '提示',
      content: '确定要删除吗？',
      success: function (sm) {
        if (sm.confirm) 
        {
            // 用户点击了确定 可以调用删除方法了
              user_cards_record_delete(app.globalData.userInfo.user_no, no).then((res) => {
                let arr = res.data.result.data;
                if (res.data.result.status.code == 0) {
                  app.showModal({ content: '删除成功'});
                }
                wx.navigateTo({
                  url: '../user/cardslists',
                })
              });
          }
        }
      })
  },

  //设置默认会员卡
  default_cards:function ()
  {
    let no = this.data.user_cards_detail.no;

    user_cards_record_default(app.globalData.userInfo.user_no, no).then((res) => {
      let arr = res.data.result.data;
      if (res.data.result.status.code == 0) 
      {
        app.showToast({ title: '设置成功', icon: 'none' });
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


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})