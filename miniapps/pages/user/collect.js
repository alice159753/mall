import {
  user_collect
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');
var util = require('../../utils/util');

var app = getApp();

function load_more(that)
{
  console.log('下拉刷新～');

  //设置分页数据
  that.setData({
    page: that.data.page + 1
  });

  user_collect(that.data.page, app.globalData.userInfo.user_no, that.data.collect_type).then((res) => {
    let arr = res.data.result.data;

    console.log(arr);

    if (util.isBlank(arr)) {
      that.setData({
        load_show: false,
      });
    }
    else {
      that.setData({
        load_show: true,
      });
    }

    let newarr = that.data.lists.concat(arr);
    console.log(newarr);
    that.setData({
      lists: newarr
    })
  })

}


// pages/user/collect.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

    lists: {},

    //控制显示load
    load_show: true,
    scrollTop: 0,
    scrollHeight: 0,
    page: 1,

    //商品或者动态
    collect_type: 1
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("collect onload");

    let that = this;

    //重新设置type的值
    if (!util.isBlank(options.collect_type)) {
      this.setData({
        type: options.collect_type,
      })
    }

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });

    //优惠券
    user_collect(that.data.page, app.globalData.userInfo.user_no, that.data.collect_type).then((res) => {
      let arr = res.data.result.data;
      this.setData({
        lists: arr,
      })
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
    console.log("collect onShow");

    var page = getCurrentPages().pop();
    if (page == undefined || page == null) return;
    let options = {};
    options.collect_type = 1
    page.onLoad(options);
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

  //下一页
  loadMore: function () {
    load_more(this);
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    load_more(this);
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

  //切换tab
  changeTab:function(e)
  {
      let that = this;
      let collect_type = e.currentTarget.dataset.collect_type;

      console.log("collect_type=" + collect_type);

      that.setData({
        collect_type: collect_type,
        page:1,
        lists:[],
      });

      //优惠券
      user_collect(that.data.page, app.globalData.userInfo.user_no, collect_type).then((res) => {
        let arr = res.data.result.data;
        this.setData({
          lists: arr,
        })
      });

  },


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})