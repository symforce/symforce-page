var CountDown   = (function(){
   
   var _Klass = new Klass({
       Binds:['update'],
       options: {
           'date': null ,
           'year': "年",
           'month': "月",
           'day': "天",
           'hour': "小时",
           'min': "分",
           'sec': "秒",
           'split': " ",
           'pass': '已结束'
       },
       parse : function(s) {
            var strInfo = s.match(/\d+/g) ;
            var d = new Date(), r = [d.getFullYear(), d.getMonth() + 1, d.getDate(), 0, 0, 0];
            for (var i = 0; i < 6 && i < strInfo.length; i++)
                r[i] = strInfo[i].length > 0 ? strInfo[i] : r[i];
            return new Date(r[0],r[1]-1,r[2],r[3],r[4],r[5]) ;
       },
       initialize: function(dom, options ){
           this.dom = $(dom) ;
           if( ! this.dom.get(0) ) {
               return ;
           }
           if( options ) {
               this.setOptions( options ) ;
           }
           if( this.dom.get(0).hasAttribute('data') ) {
               options  = $.parseJSON( $(dom).attr('data') ) ;
               this.setOptions( options ) ;
           }
           this.date =  new Date() ;
           if( this.options.date ) {
               this.date = this.parse( this.options.date ) ;
           }
           this.update();
       },
       update:function(){
           var date = this.date ;
           var now = new Date() ;
           var html = [] ;
           var diff = Math.floor( (date.getTime() - now.getTime()) / 1000 ) ;
           if(  diff > 0 ) {
               var values = [] ;
               var keys = [] ;
               // 1 minute = 60 sec
               values.push( diff % 60 ) ; keys.push( this.options.sec ) ;
               diff = Math.floor( diff / 60) ; // minute
               
               // 1 hors = 60 minute
               values.push( diff % 60 ) ; keys.push( this.options.min ) ;
               diff = Math.floor( diff / 60) ; // hours
               
               // 1 days = 24 hours
               values.push( diff % 24 ) ; keys.push( this.options.hour ) ;
               diff = Math.floor( diff / 24 ) ; // days
               
               // 1 month = 30 day
               values.push( diff % 30 ) ; keys.push( this.options.day ) ;
               diff = Math.floor( diff / 30 ) ; // months
               
               // 1 year = 12 month
               values.push( diff % 12 ) ; keys.push( this.options.month ) ;
               diff = Math.floor( diff / 12 ) ; // years
               
               values.push( diff ) ; keys.push( this.options.year ) ;
               
               var start = false ;
               for(var i = keys.length; i--; ) {
                   if( !start ) {
                       if( values[i] < 1 ) {
                           continue ;
                       }
                       start    = true ;
                   }
                   html.push( '<span class="countdown_number">'+values[i] + '</span><span class="countdown_unit">' + keys[i] + '</span>' );
                   if( html.length > 3 ) {
                       break ;
                   }
               }
               html = html.join( this.options.split) ;
               setTimeout(this.update, 999 );
           } else {
               html = '<span class="countdown_passed">' + this.options.pass + '</span>' ;
           }
           this.dom.html( html) ;
       }
   }) ;
   return _Klass ;
})();

$(function() {
    $.each($('.app_countdown'), function(){
       new CountDown(this);
    });
    
    var box = $('.app_content') ;
    if( ! box.length ) {
        return ;
    }
    $.each(box, function(){
        $(this).append( $('<div class="app_content_clear"></div>') );
    });
    var box_clear = $('.app_content_clear');
    function toInt( val ) {
        if( !/^([\d\.]+)/.test(val) ) {
            return 0 ;
        }
        return parseFloat(RegExp.$1) ;
    }
    var lt_ie9 = $('html').hasClass('lt-ie9') ;
    var min_height = 0 ;
    var height  = 0 ;
    function resize() {
        var _height = window.document.body.offsetHeight - height ;
        if( _height < min_height ) {
            _height = min_height ; 
        }
        // if use height will break layout when content height change by js
        box.css('min-height', _height) ;
    }
    function fix_height() {
        min_height  = 0 ;
        $.each(box_clear, function(){
            var _height =  $(this).position().top ;
            if(  _height > min_height )  {
                min_height = _height ;
            }
        });
        if( lt_ie9 ) {
            min_height  -= toInt( box.css('padding-bottom') ) + toInt( box.css('padding-top') ) + toInt(box.css('border-bottom-width')) + toInt(box.css('border-top-width')) - 2 ;
        } else {
            min_height  +=  toInt( box.css('padding-bottom') ) + toInt(box.css('border-bottom-width')) ;
        }
        height  = $('#footer').position().top + $('#footer').height() - min_height ;
        resize() ;
    }
    fix_height();
    $(window).resize(resize);
});