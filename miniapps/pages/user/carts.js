// pages/user/carts.js
import {
  user_carts, user_carts_delete
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();

//获取选种的购物车no
function getUserCartsNos($rows) {
  var arr = new Array();

  for (var i = 0; i < $rows.length; i++) {
    let no = $rows[i]['no'];

    if ($rows[i]['isshow']) {
      arr.push(no);
    }

  }

  return arr.join(",");
}


//设置选中的商品
function set_choose(that, user_carts_no)
{
  console.log("set_choose");

  let lists = that.data.user_carts_lists;
  //设置展示
  for (var i = 0; i < lists.length; i++) 
  {
    if (lists[i]['no'] == user_carts_no ) 
    {
      lists[i]['isshow'] = lists[i]['isshow'] ? false : true;
    }

    if (user_carts_no == 0 )
    {
      lists[i]['isshow'] = true;
    }
  }

  that.setData({
    user_carts_lists: lists,
  })
}

//重新计算总价格
function computer_price(that)
{
  console.log("computer_price");

  let lists = that.data.user_carts_lists;
  let total_sale_price = 0;
  let total_buy_num = 0;

  //设置展示
  for (var  i = 0;i < lists.length;i++)
  {
      //计算价格
      if (lists[i]['isshow'] )
      {
        total_buy_num += parseInt(lists[i]['buy_num']);

        total_sale_price = total_sale_price + (parseInt(lists[i]['sale_price']) * parseInt(lists[i]['buy_num']));
      }
  }

  that.setData({
    user_carts_lists: lists,
    total_sale_price: total_sale_price,
    total_buy_num: total_buy_num,
  })
}

//设置购买数量
function buy_num(that, user_carts_no, operate_type)
{
  console.log("buy_num");

  let lists = that.data.user_carts_lists;

  //设置展示
  for (var i = 0; i < lists.length; i++) 
  {

    if (lists[i]['no'] == user_carts_no) 
    {
      if (operate_type == 'plus' )
      {
        lists[i]['buy_num'] = parseInt(lists[i]['buy_num']) + 1;

        if (lists[i]['buy_num'] > lists[i]['repertory_num']) {
          app.showModal({ content: '购买数量不能大于库存' });
          lists[i]['buy_num'] = parseInt(lists[i]['buy_num']) - 1;
        }
      }
      else
      {
        lists[i]['buy_num'] = parseInt(lists[i]['buy_num']) - 1;

        if (lists[i]['buy_num'] < 1) {
          app.showModal({ content: '购买数量不能小于1' });
          lists[i]['buy_num'] = parseInt(lists[i]['buy_num']) + 1;
        }
      }

    }
  }

  that.setData({
    user_carts_lists: lists,
  })

}


Page({

  /**
   * 页面的初始数据
   */
  data: {

    //购物车列表
    user_carts_lists:[],

    scrollTop: 0,
    scrollHeight: 0,

    //购物车总体价格
    total_sale_price:0,

    //购物车购买数量
    total_buy_num:0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
    console.log("carts onload");

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })

      return 0;
    }

    let that = this;

    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });


    //购物车列表
    user_carts(app.globalData.userInfo.user_no).then((res) => {
      let arr = res.data.result.data;

      this.setData({
        user_carts_lists: arr,
      });

    });

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    console.log('onReady');
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    console.log('onShow');

    var page = getCurrentPages().pop();
    if (page == undefined || page == null) return;
    page.onLoad();

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    console.log('onHide');

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
    console.log('onUnload');
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

  //选择所有商品
  chooseAll:function ()
  {
    console.log("chooseAll");

    set_choose(this, 0);

    computer_price(this);

  },

  //删除购物车
  user_carts_delete:function (e){
    let user_carts_no = e.currentTarget.dataset.user_carts_no;
    
    console.log("user_carts_no=" + user_carts_no);

    //删除购物车
    user_carts_delete(app.globalData.userInfo.user_no, user_carts_no).then((res) => {

      if (res.data.result.status.code == 0 )
      {
          app.showToast({ title: '删除成功',icon:'none'});
      }
      
      var page = getCurrentPages().pop();
      if (page == undefined || page == null) return;
      page.onLoad();

    });
  },

  //选择1个商品
  user_carts_one:function (e){
    let user_carts_no = e.currentTarget.dataset.user_carts_no;

    set_choose(this, user_carts_no);

    computer_price(this);

  },

  //减少
  minus: function (e) {
    let user_carts_no = e.currentTarget.dataset.user_carts_no;

    buy_num(this, user_carts_no, 'minus');

    computer_price(this);

  },


  //添加
  plus:function (e){
    let user_carts_no = e.currentTarget.dataset.user_carts_no;

    buy_num(this, user_carts_no,'plus');

    computer_price(this);

  },

  //结算
  user_carts_make:function (){

    app.globalUserCarts = this.data.user_carts_lists;
    console.log(app.globalUserCarts);
    let user_carts_nos = getUserCartsNos(this.data.user_carts_lists);
    console.log(user_carts_nos);

    wx.navigateTo({
      url: '../user/ordermake?user_carts_nos=' + user_carts_nos,
    })

  },


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})