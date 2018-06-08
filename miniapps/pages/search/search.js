// pages/search/search.js
import { hot_search, user_search_history, user_search_delete,product_search } from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var app = getApp();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    page: 1,
    //判断是否显示搜索和历史
    val: '',

    //是否展示热门搜索
    is_show_hot:true,

    //是否展示商品
    is_show_product:false,

    //热门搜索
    hotArray: [],

   //历史搜索
    historyArray:[],

    //首页商品
    productlists: [],
  },

  //点击小叉叉清除input内容
  clearFont: function () {
    this.setData({
      val: '',
    });
  },
  
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    //热门搜索
    hot_search().then((res) => {
      let arr = res.data.result.data;
      this.setData({
        hotArray: arr,
      })
    });

    //历史搜索
    user_search_history(app.globalData.userInfo.user_no).then((res) => {
      let arr = res.data.result.data;
      this.setData({
        historyArray: arr,
      })
    });

  },

  userInput:function(e)
  {
    let title = e.detail.value;

    this.search_make(title);
  },

  //点击enter按键
  search_submit_confirm:function(e) 
  {
    let title = e.detail.value;

    console.log("搜索关键字:" + title);

    this.search_make(title);
  },

  //点击搜索图标
  search_submit_query:function()
  {
    let title = this.data.val;

    console.log("搜索关键字:" + title);

    this.search_make(title);
  },

  submitInfo:function(e)
  {
    let title = e.detail.value.title;

    this.search_make(title);
  },

  //搜索提交
  search_submit: function (event)
  {
      let title = event.currentTarget.dataset.title;

      console.log("搜索关键字:"+title);

      this.search_make(title);
  },

  //执行搜索
  search_make:function(title)
  {
    wx.showToast({ //显示消息提示框  此处是提升用户体验的作用
      title: '数据加载中',
      icon: 'loading',
    });

    this.setData({
      val: title,
      page: 1
    });

    product_search(this.data.page, title).then((res) => {

      let arr = res.data.result.data;

      //如果查询出来的结果为空，则展示空结果，否则展示产品
      if (res.data.result.data.length == 0) {

        this.setData({
          is_show_hot: true,
          is_show_product: false,
        });

        wx.showToast({ //显示消息提示框  此处是提升用户体验的作用
          title: '没有此宝贝',
          icon: 'none',
        });
      }
      else {
        this.setData({
          is_show_hot: false,
          is_show_product: true,
          productlists: arr,
        });
      }
    })
  },

  //删除用户历史搜索记录
  user_search_delete: function (event)
  {
    let no = event.currentTarget.dataset.no;

    //删除需要展示
    user_search_delete(app.globalData.userInfo.user_no, no).then((res) => {
      let arr = res.data.result.data;
    });

    console.log(historyArray);

    //重新加载 
    for (let i = 0; i < this.data.historyArray.length; i++)
    {
       if (this.data.historyArray[i]['no'] == no )
        {
           this.data.historyArray[i]['is_display'] = 0;
        }
    }

    this.setData({
      historyArray: this.data.historyArray,
    })

    // user_search_history(app.globalData.userInfo.user_no).then((res) => {
    //   let arr = res.data.result.data;
    //   this.setData({
    //     historyArray: arr,
    //   })
    // });

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
    console.log('下拉刷新～');
    let that = this;

    that.setData({
      show: true,
      page: that.data.page + 1
    });

    setTimeout(function () {
      that.setData({
        show: false
      });
      product_search(that.data.page, that.data.val).then((res) => {
        let arr = res.data.result.data;
        let newarr = that.data.productlists.concat(arr);
        console.log(newarr);
        that.setData({
          productlists: newarr
        })
      })
    }, 1500)
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})