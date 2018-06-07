import { commonAjax, order_product, order_review } from '../../api/request'

var util = require('../../utils/util.js');
var CommonEvent = require('../common/commonEvent');
var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    //订单编号
    order_info_no: 0,
    //订单商品
    order_product:[],
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

    //订单确认数据
    order_product(app.globalData.userInfo.user_no, options.order_info_no).then((res) => {
      let arr = res.data.result.data;

      //失败
      if (res.data.result.status.code != 0) {
        app.showModal({ content: res.data.result.status.msg });
      }
      else {
        this.setData({
          order_product: arr,
        });
      }
    });

  },

  //点击星星
  starclick:function(e)
  { 
      var position = e.currentTarget.dataset.position;
      var no = e.currentTarget.dataset.no;

      for (var i = 0; i < this.data.order_product.length; i++ )
      {
          if(no == this.data.order_product[i]['no'] )
          {
            this.data.order_product[i]['position'] = position;
          }
      }

      this.setData({
        order_product: this.data.order_product,
      });
  },

  //是否匿名
  anonlick: function (e) {
    var no = e.currentTarget.dataset.no;

    for (var i = 0; i < this.data.order_product.length; i++) {
      if (no == this.data.order_product[i]['no']) 
      {
            if ( this.data.order_product[i]['is_anon'] )
            {
              this.data.order_product[i]['is_anon'] = false;
            }
            else
            {
              this.data.order_product[i]['is_anon'] = true;
            }
      }
    }

    this.setData({
      order_product: this.data.order_product,
    });
  },

  //表单提交
  formSubmit:function(e){

    var stars = [];
    var contents = [];
    var isanons = [];
    var productnos = [];

    for (var i = 0; i < this.data.order_product.length; i++) {
      //内容
      let no = this.data.order_product[i]['no'];
      let name = "content_"+no;
      contents.push(e['detail']['value'][name]);

      //星星
      stars.push(this.data.order_product[i]['position']);

      //是否匿名
      isanons.push(this.data.order_product[i]['is_anon']);

      productnos.push(no);
    }

    console.log("contents");
    console.log(contents);

    console.log("stars");
    console.log(stars);

    console.log("isanons");
    console.log(isanons);

    //提交评价
    order_review(app.globalData.userInfo.user_no, this.data.order_info_no, contents.join(','), stars.join(','), isanons.join(','), productnos.join(',')).then((res) => {
      let arr = res.data.result.data;

      //失败
      if (res.data.result.status.code != 0) {
        app.showModal({ content: res.data.result.status.msg });
      }
      else 
      {
        util.noOpen('评价成功', function () {
          setTimeout(() => {
            wx.navigateBack({
              delta: 1, // 回退前 delta(默认为1) 页面
            });
          }, 100)
        });
      }
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