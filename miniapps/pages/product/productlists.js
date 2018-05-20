// pages/product/productlists.js
import {
  category1, product
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {

    //首页一级分类
    category1list: [],   

    //分类no
    category_no_1: 0,

    //控制显示图片
    show: true,

    //商品列表
    productlists: [],

    //分页
    page: 1,

    //分类排序, 销量降序
    category_order: 'sale_num desc',

    //销量，价格，新品，综合
    istab: 0,

    //默认图标
    shang0: 'shang.png',
    xia0: 'xia.png',
    shang1: 'shang.png',
    xia1: 'xia.png',
    shang2: 'shang.png',
    xia2: 'xia.png',
    shang3: 'shang.png',
    xia3: 'xia.png',


  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    console.log("productlists onload");
    console.log(options);

    //设置导航条名称
    wx.setNavigationBarTitle({
      title: options.title
    });

    //首页一级分类
    category1().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        category1list: arr,
      })
    });

    //首页全部商品
    product(1, options.category_no_1, 'sale_num desc').then((res) => {
      let arr = res.data.result.data;
      this.setData({
        productlists: arr,
        category_no_1: options.category_no_1,
        category_order: 'sale_num desc',
        //设置默认箭头颜色
        xia0: 'xia_active.png',

      })
    });

  },
  //tab选择
  taplist: function (event) {
    let that = this;

    let id = event.currentTarget.dataset.id;
    let order = event.currentTarget.dataset.order;

    console.log("id=" + id);
    console.log("order=" + order);

    this.setData({
      istab: id,
      category_order: order,
      page: 1
    })

    //首页全部商品
    product(1, that.data.category_no_1, order).then((res) => {
      let arr = res.data.result.data;
      this.setData({
        productlists: arr,
      })
    });

    that.clearjiantou();

    if (id == 0) {
      if (order.indexOf('asc') >= 1) {
        this.setData({
          shang0: 'shang_active.png',
        })
      }

      if (order.indexOf('desc') >= 1) {
        this.setData({
          xia0: 'xia_active.png',
        })
      }
    }

    if (id == 1) {
      if (order.indexOf('asc') >= 1) {
        this.setData({
          shang1: 'shang_active.png',
        })
      }

      if (order.indexOf('desc') >= 1) {
        this.setData({
          xia1: 'xia_active.png',
        })
      }
    }

    if (id == 2) {
      if (order.indexOf('asc') >= 1) {
        this.setData({
          shang2: 'shang_active.png',
        })
      }

      if (order.indexOf('desc') >= 1) {
        this.setData({
          xia2: 'xia_active.png',
        })
      }
    }

    if (id == 3) {
      if (order.indexOf('asc') >= 1) {
        this.setData({
          shang3: 'shang_active.png',
        })
      }

      if (order.indexOf('desc') >= 1) {
        this.setData({
          xia3: 'xia_active.png',
        })
      }
    }


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