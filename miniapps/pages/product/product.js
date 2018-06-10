import {
  product_detail, user_carts_add_make, product_collect
} from '../../api/request'
var CommonEvent = require('../common/commonEvent');

var util = require('../../utils/util');

var app = getApp();


function buy_api(that)
{
  console.log("buy_api");

  //如果是立即购买，则跳转到立即购买页面
  if ( that.data.button_type == 'lijigoumai' )
  {
    buy_api_buy_now(that);
    return '';
  }

  //加入购物车
  user_carts_add_make(app.globalData.userInfo.user_no, that.data.product_no, that.data.product_attr_no, that.data.buy_num).then((res) => {
    let arr = res.data.result.data;
    console.log(arr);

    if (res.data.result.status.code == 0 )
    {
      app.showToast({ title: '加入购物车成功', icon:'none' });

      that.setData({
        user_carts_num: arr.count,
      });

      // var page = getCurrentPages().pop();
      // if (page == undefined || page == null) return;
      // page.traggle_guige();

      this.setData({
        isshowguige: false,
        isshowcarts: true,
      })

    }
    else
    {
      app.showModal({ content: res.data.result.status.msg });
    }

  });
}

function buy_api_buy_now(that) 
{
    //立即购买
  console.log("buy_api_buy_now");

  //加入购物车
  user_carts_add_make(app.globalData.userInfo.user_no, that.data.product_no, that.data.product_attr_no, that.data.buy_num,0).then((res) => {
    let arr = res.data.result.data;

    console.log(arr);

    if ( res.data.result.status.code == 0 ) 
    {
      let user_carts_no = arr.no;
      wx.navigateTo({
        url: '../user/ordermake?user_carts_nos=' + user_carts_no,
      })
    }
    
  });

}


// pages/product/product.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    //商品详情
    product_detail: [],

    //商品详情是否展示
    isproductdetailshow: false,

    //是否展示规格
    isshowguige:false,

    //是否展示购物车
    isshowcarts: true,

    //库存 减少样式
    minus_disabled:'disabled',

    //库存 添加样式
    plus_disabled: '',

    //购买数量
    buy_num:1,

    //展示规格商品图片
    product_specification_pic:'',
    //展示规格标题
    product_specification_title: '',
    //展示规格价格
    product_specification_price: '',
    //展示规格库存
    product_specification_repertory_num: '',

    //规格值1
    product_specification_value1: '',
    //规格值2
    product_specification_value2: '',
    //规格值3
    product_specification_value3: '',

    //规格no1
    product_specification_no1: '',
    //规格no2
    product_specification_no2: '',
    //规格no3
    product_specification_no3: '',

    //规格是否有1
    product_has_specification1: false,
    //规格是否有2
    product_has_specification2: false,
    //规格是否有3
    product_has_specification3: false,

    //选中的product_attr_no
    product_attr_no:0,

    //选中的product_no
    product_no: 0,

    //用户购物车数量
    user_carts_num:0,

    //是否收藏
    is_collect:false,

    //按钮类型
    button_type:'jiarugouwuche'
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
    console.log('product onload');
    console.log("options");
    console.log(options);

    //没有登录则展示登录框
    if (!app.globalData.userInfo) {
      this.setData({
        isloginshow: true,
      })
    }

    this.setData({
      product_no: options.product_no,
    })
    
    //商品详情
    product_detail(app.globalData.userInfo.user_no, options.product_no).then((res) => {
      let arr = res.data.result.data;

      if ( !util.isBlank(arr.product_attr.title1) )
      {
        this.setData({
          product_has_specification1: true,
        });
      }
      if (!util.isBlank(arr.product_attr.title2)) {
        this.setData({
          product_has_specification2: true,
        });
      }

      if (!util.isBlank(arr.product_attr.title3)) {
        this.setData({
          product_has_specification3: true,
        });
      }

      this.setData({
        product_detail: arr,
        product_specification_pic: arr.product_specification_pic,
        product_specification_title: arr.product_specification_title,
        product_specification_price: arr.product_specification_price,
        product_specification_repertory_num: arr.product_specification_repertory_num,

        user_carts_num: arr.user_carts_num,

        is_collect: arr.is_collect

      });

      //设置导航条名称
      wx.setNavigationBarTitle({
        title: arr.title
      });

    });

  },

  /**
   * 商品详情是否展示
   */
  traggle_product_detail_show:function(){

    console.log("isproductdetailshow=");
    console.log(this.data.isproductdetailshow);

     if( this.data.isproductdetailshow ) 
     {
       this.setData({
         isproductdetailshow: false,
       });
     }
     else
     {
       this.setData({
         isproductdetailshow: true,
       });
     }
  },

  //点击分类跳转到分类详情
  changeTab: function (event) {
    let title = event.currentTarget.dataset.title;
    let category_no_1 = event.currentTarget.dataset.category_no;

    app.globalData.category.title = title;
    app.globalData.category.category_no_1 = category_no_1;

    //切换switchTab以后不刷新tab解决方案
    wx.switchTab({
      url: '../product/productlists',
      complete: function (e) {
        var page = getCurrentPages().pop();
        if (page == undefined || page == null) return;
        page.onLoad();
      }
    });

  },

  //收藏
  collect: function () {

    //商品收藏
    product_collect(app.globalData.userInfo.user_no, this.data.product_no).then((res) => {
      let arr = res.data.result.data;

      if (res.data.result.status.code != 0) {
        app.showModal({ content: res.data.result.status.msg });
      }
      else {
        if (arr.is_collect == 1) {
          app.showToast({ title: '收藏成功', icon: 'none' });
        }
        else {
          app.showToast({ title: '取消收藏成功', icon: 'none' });
        }

        this.setData({
          is_collect: arr.is_collect,
        })
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

  traggle_guige:function (e){
    console.log("traggle_guige");

    let button_type = e.currentTarget.dataset.button_type;

    console.log("button_type=" + button_type);

    if ( !util.isBlank(button_type) )
    {
        this.setData({
          button_type: button_type,
        })
    }

    //如果当前展示的是规格页面
    if (this.data.isshowguige)
    {
      this.setData({
        isshowguige: false,
        isshowcarts: true,
      })
    }
    else
    {
      this.setData({
        isshowguige: true,
        isshowcarts: false,
      })
    }

  },

  //减少
  minus:function (){
    this.data.buy_num = this.data.buy_num - 1;
    if (this.data.buy_num < 1) {
      this.data.buy_num = 1;
      app.showModal({ content: '购买数量不能小于1' });

      this.setData({
        'minus_disabled': 'disabled'
      });
    }

    this.setData({
      'buy_num': this.data.buy_num,
      'plus_disabled': ''
    });

  },

  //添加
  plus:function (){
    this.data.buy_num = this.data.buy_num + 1;
    if (this.data.buy_num > this.data.product_specification_repertory_num) {
      this.data.buy_num = parseInt(this.data.product_specification_repertory_num);
      app.showModal({ content: '购买数量不能大于库存' });

      this.setData({
        'plus_disabled': 'disabled',
      });
    }

    this.setData({
      'buy_num': this.data.buy_num,
      'minus_disabled': ''
    });
  },

  //点击数量
  buy_num: function (e) {
    var count = e.detail.value

    if (count > this.data.product_specification_repertory_num) {
      count = this.data.product_specification_repertory_num;
      app.showModal({ content: '购买数量不能大于库存' });

      this.setData({
        'plus_disabled': 'disabled',
        'minus_disabled': ''
      });
    }

    if (count < 1 )
    {
      count = 1;
      app.showModal({ content: '购买数量不能小于1' });

      this.setData({
        'minus_disabled': 'disabled',
        'plus_disabled': '',
      });
    }
    
    this.setData({
      'buy_num': count
    });
  },

  //点击规格
  chooseGuige:function (e){    
    let position = e.currentTarget.dataset.position;
    let specification_value = e.currentTarget.dataset.specification_value;
    let specification_no = e.currentTarget.dataset.specification_no;

    this.setData({
      'product_attr_no': 0,
    });

    //位置1
    if (position == 1 )
    {
      this.setData({
        'product_specification_value1': specification_value,
        'product_specification_no1': specification_no
      });
    }

    //位置2
    if (position == 2) {
      this.setData({
        'product_specification_value2': specification_value,
        'product_specification_no2': specification_no
      });
    }

    //位置3
    if (position == 3) {
      this.setData({
        'product_specification_value3': specification_value,
        'product_specification_no3': specification_no
      });
    }

    let is_3 = false;
    let is_2 = false;


    //点击了以后需要修改商品的图片和价格
    //3个规格都有
    console.log(3);
    if (this.data.product_has_specification1 && 
        this.data.product_has_specification2 &&
        this.data.product_has_specification3 )
    {
      is_3 = true;

      //如果3个规格都选择，则修改对应的数据
      if ( !util.isBlank(this.data.product_specification_no1) &&
           !util.isBlank(this.data.product_specification_no2) &&
           !util.isBlank(this.data.product_specification_no3) 
         )
        {
           var lists = this.data.product_detail.product_attr.lists;

           var i = 0;
           for (i = 0; i < lists.length; i++)
          {
             if (
this.data.product_specification_no1 == lists[i]['specification_no1'] && this.data.product_specification_value1 == lists[i]['specification_value1'] && 
this.data.product_specification_no2 == lists[i]['specification_no2'] && this.data.product_specification_value2 == lists[i]['specification_value2'] && 
 this.data.product_specification_no3 == lists[i]['specification_no3'] && this.data.product_specification_value3 == lists[i]['specification_value3'] 
             )
            {
               if (lists[i]['repertory_num'] == 0 )
              {
                 app.showModal({ content: '库存为空，请选择其他规格' });
                 return 0;
              }

               this.setData({
                 'product_specification_pic': lists[i]['pic'],
                 'product_specification_price': lists[i]['sale_price'],
                 'product_specification_repertory_num': lists[i]['repertory_num'],
                 'product_attr_no': lists[i]['no'],
               });

               return 0;

            }
          }

        }
        else{
        return 0;
        }
    }

    if (is_3) {
      return 0;
    }

    //如果只有2个规格
    console.log(2);
 
    if (this.data.product_has_specification1 &&
      this.data.product_has_specification2 ) {

      is_2 = true;

      //如果3个规格都选择，则修改对应的数据
      if (!util.isBlank(this.data.product_specification_no1) &&
        !util.isBlank(this.data.product_specification_no2) 
      ) {
        var lists = this.data.product_detail.product_attr.lists;

        var i = 0;
        for (i = 0; i < lists.length; i++) {
          if (
            this.data.product_specification_no1 == lists[i]['specification_no1'] && this.data.product_specification_value1 == lists[i]['specification_value1'] &&
            this.data.product_specification_no2 == lists[i]['specification_no2'] && this.data.product_specification_value2 == lists[i]['specification_value2'] 
          ) {
            if (lists[i]['repertory_num'] == 0) {
              app.showModal({ content: '库存为空，请选择其他规格' });
              return 0;
            }

            this.setData({
              'product_specification_pic': lists[i]['pic'],
              'product_specification_price': lists[i]['sale_price'],
              'product_specification_repertory_num': lists[i]['repertory_num'],
              'product_attr_no': lists[i]['no'],
            });

            return 0;
          }
        }
      }
      else{
        return 0;
      }

    }

    if (is_2) {
      return 0;
    }

    //如果只有1个规格
    console.log(1);
    if (this.data.product_has_specification1 ) {
      //如果3个规格都选择，则修改对应的数据
      if (!util.isBlank(this.data.product_specification_no1)
      ) {
        var lists = this.data.product_detail.product_attr.lists;
        console.log(lists);
        var i = 0;
        for (i = 0; i < lists.length; i++) {
          if (
            this.data.product_specification_no1 == lists[i]['specification_no1'] && this.data.product_specification_value1 == lists[i]['specification_value1'] 
          ) {
            if (lists[i]['repertory_num'] == 0) {
              app.showModal({ content: '库存为空，请选择其他规格' });
              return 0;
            }
            this.setData({
              'product_specification_pic': lists[i]['pic'],
              'product_specification_price': lists[i]['sale_price'],
              'product_specification_repertory_num': lists[i]['repertory_num'],
              'product_attr_no': lists[i]['no'],
            });

            return 0;
          }
        }

      }
      else
      {
        return 0;
      }
    }
  },

  //加入购物车
  buy_carts_submit:function ()
  {
     console.log("buy_carts_submit");

     let is_3 = false;
     let is_2 = false;
     let is_1 = false;

      //如果有3个
      console.log(3);
      if (this.data.product_has_specification1 &&
      this.data.product_has_specification2 &&
      this.data.product_has_specification3)
      {
        is_3 = true;

        if (util.isBlank(this.data.product_specification_value1)) {
          app.showModal({ content: '请选择规格1' });
          return 0;
        }
        if (util.isBlank(this.data.product_specification_value2)) {
          app.showModal({ content: '请选择规格2' });
          return 0;
        }
        if (util.isBlank(this.data.product_specification_value3)) {
          app.showModal({ content: '请选择规格3' });
          return 0;
        }

        if (util.isBlank(this.data.product_attr_no)) 
        {
          app.showModal({ content: '该规格库存为空' });
          return 0;
        }

        buy_api(this);

      }

      if (is_3)
      {
        return 0;
      }

      //如果有2个
      console.log(2);
      if (this.data.product_has_specification1 &&
          this.data.product_has_specification2
        ) 
        {
            if (util.isBlank(this.data.product_specification_value1)) {
              app.showModal({ content: '请选择规格1' });
              return 0;
            }

            if (util.isBlank(this.data.product_specification_value2)) {
              app.showModal({ content: '请选择规格2' });
              return 0;
            }

            buy_api(this);

        }

        if (is_2) {
          return 0;
        }

      //如果有1个
      console.log(1);
       if (this.data.product_has_specification1) 
        {
          is_1 = true;

          if (util.isBlank(this.data.product_specification_value1)) {
            app.showModal({ content: '请选择规格1' });
            return 0;
          }

          buy_api(this);
        }

       if (is_1) 
       {
         return 0;
       }

       buy_api(this);
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})