// pages/user/carts.js
import {
  order_confirm, user_address_add
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();

function getUserCartsNos($rows)
{
   var arr = new Array();

    for (var i = 0; i < $rows.length; i++) 
    {
      let no = $rows[i]['no'];

      if ($rows[i]['isshow'] )
      {
        arr.push(no);
      }

    }

    return arr.join(",");
}


// pages/user/ordermake.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //订单确认数据
    order_confirm:[],

    selectDiscountInfo:[],
    selectDiscountIndex: [],

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("ordermake onload");

    console.log("app.globalUserCarts");
    console.log(app.globalUserCarts);

    console.log(options.user_carts_nos);

    //let user_carts_nos = getUserCartsNos(app.globalUserCarts);
    //console.log("user_carts_nos="+user_carts_nos);

    //订单确认数据
    order_confirm(app.globalData.userInfo.user_no, options.user_carts_nos).then((res) => {
      let arr = res.data.result.data;

       //失败
      if ( res.data.result.status.code != 0 )
      {
        app.showModal({ content: res.data.result.status.msg });
      }
      else
      {
        this.setData({
          order_confirm: arr,
        });
      }
    });


  },

  chooseAddress:function(){

    let that = this;
    let user_no = app.globalData.userInfo.user_no;

    wx.chooseAddress({
      success: function (res) 
      {
        console.log(res.userName)
        console.log(res.postalCode)
        console.log(res.provinceName)
        console.log(res.cityName)
        console.log(res.countyName)
        console.log(res.detailInfo)
        console.log(res.nationalCode)
        console.log(res.telNumber)

        //添加新地址
        user_address_add(user_no, res).then((res) => {
          let arr = res.data.result.data;
        });

        console.log(that.data.order_confirm);

        that.data.order_confirm.user_address = { 'user_no': '', 'consignee': '', 'zipcode': '', 'province': '', 'city': '', 'district': '', 'address': '', 'country': '','tel':''};

        that.data.order_confirm.user_address.user_no = user_no;
        that.data.order_confirm.user_address.consignee = res.userName;
        that.data.order_confirm.user_address.zipcode = res.postalCode;
        that.data.order_confirm.user_address.province = res.provinceName;
        that.data.order_confirm.user_address.city = res.cityName;
        that.data.order_confirm.user_address.district = res.countyName;
        that.data.order_confirm.user_address.address = res.detailInfo;
        that.data.order_confirm.user_address.country = res.nationalCode;
        that.data.order_confirm.user_address.tel = res.telNumber;

        that.setData({
          order_confirm: that.data.order_confirm,
        });
      }
    });

  },

  //优惠券改变
  discountChange:function (e){
    var index = e.detail.value;
    console.log(index);
    this.setData({
      selectDiscountInfo: this.data.order_confirm.discount_coupon[index],
      selectDiscountIndex: index,
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