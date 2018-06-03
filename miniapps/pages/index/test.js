var WxParse = require('../../wxParse/wxParse.js');
Page({
  data: {
  },
  onLoad: function (options) {

    console.log("articledetail onload");

    var that = this;
 
    var article = "<div>这里是html数据</div>";

    WxParse.wxParse('article', 'html', article, that, 5);
  },
  


})
