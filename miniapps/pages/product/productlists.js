// pages/product/productlists.js
import {
  category1, product
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');
var util = require('../../utils/util');


var app = getApp();

function load_more(that)
{
  console.log('下拉刷新～');

  that.setData({
    load_show: true,
    page: that.data.page + 1
  });

  product(that.data.page, that.data.category_no_1, that.data.category_order).then((res) => {
    let arr = res.data.result.data;

    if (util.isBlank(arr)) {
      that.setData({
        load_show: false,
      });
    }

    let newarr = that.data.productlists.concat(arr);
    console.log(newarr);
    that.setData({
      productlists: newarr
    })
  })

}



Page({

  /**
   * 页面的初始数据
   */
  data: {

    //控制显示load
    load_show: true,

    //首页一级分类
    category1list: [],   

    //分类no
    category_no_1: 0,

    //商品列表
    productlists: [],

    //分页
    page: 1,

    //分类排序, 销量降序
    category_order: 'real_sales desc,virtual_sales desc',

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

    //是否
    isloginshow: false,

    scrollTop: 0,
    scrollHeight: 0,
    page: 1,

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    let that = this;

    console.log("productlists onload");
    console.log(app.globalData.category);

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


    if ( util.isBlank(options) )
    {
      options = { 'category_no_1': 0, 'title':'分类'};
    }

    let title = app.globalData.category.title;
    let category_no_1 = app.globalData.category.category_no_1;

    if ( !util.isBlank(title) )
    {
      options.title = title;
    }

    if (!util.isBlank(category_no_1)) {
      options.category_no_1 = category_no_1;
    }

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
    product(1, options.category_no_1, 'real_sales desc,virtual_sales desc').then((res) => {
      let arr = res.data.result.data;
      console.log("product arr");
      console.log(arr);
      if (util.isBlank(arr) )
      {
        this.setData({
          load_show:false,
        });
      }
        this.setData({
          productlists: arr,
          category_no_1: options.category_no_1,
          category_order: 'real_sales desc,virtual_sales desc',
          //设置默认箭头颜色
          xia0: 'xia_active.png',
        })
    });

    //清空跳转时候的全局变量
    app.globalData.category.title = '分类';
    app.globalData.category.category_no_1 = '0';
  },
  //tab选择
  taplist: function (event) {
    let that = this;
    
    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    this.setData({
      load_show: true,
    });

    //清空数据
    this.setData({
      productlists: {},
    })

    let id = event.currentTarget.dataset.id;
    let order = event.currentTarget.dataset.order;
    let category_no_1 = event.currentTarget.dataset.category_no;

    //如果id为空，则获取全局变量
    if (util.isBlank(id) )
    {
      id = that.data.istab;
    }

    //如果order为空，则获取全局变量
    if (util.isBlank(order)) {
      order = that.data.category_order;
    }
    else
    {
      that.data.category_order = order;
    }

    //如果category_no_1为空，则获取全局变量
    if (util.isBlank(category_no_1)) {
      category_no_1 = that.data.category_no_1;
    }
    else
    {
      that.data.category_no_1 = category_no_1;
    }

    console.log("id=" + id);
    console.log("order=" + order);

    this.setData({
      istab: id,
      category_order: order,
      page: 1,
      category_no_1: category_no_1,
    })

    //首页全部商品
    product(1, category_no_1, order).then((res) => {
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

  //清空箭头的颜色
  clearjiantou: function () {
    let that = this;

    this.setData({
      shang0: 'shang.png',
      xia0: 'xia.png',
      shang1: 'shang.png',
      xia1: 'xia.png',
      shang2: 'shang.png',
      xia2: 'xia.png',
      shang3: 'shang.png',
      xia3: 'xia.png',
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

  //下一页
  loadMore: function (){
    load_more(this);
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () 
  {
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


  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})