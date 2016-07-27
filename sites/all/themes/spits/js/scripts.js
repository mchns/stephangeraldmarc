(function($) {
  Drupal.behaviors.spits = {
    attach : function(context, settings) {
      $('#navigation').after('<a href="#" id="hamburger-menu"></a>');

      /* push menu */
      new mlPushMenu(document.getElementById('mp-menu'), document.getElementById('hamburger-menu'), {
        type : 'cover'
      });
      
      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
       $("#header-wrapper").prependTo("#mp-pusher");
      }  
      
      $('#navigation a').hover(function(){
        $(this).addClass('hover');
      },
      function(){
        $(this).removeClass('hover');
      });
      
      /* facebook likebox */
      $('#facebook-likebox').append('<a href="#" id="facebook-likebox-close">close</a>');
      if(getCookie('facebook_likebox') !== 'shown') {
        setTimeout(function(){        
          if($(document).outerWidth() > 600) {
            setCookie("facebook_likebox", 'shown', 30);
            $('#facebook-likebox').addClass('show');
          }
        }, 5000);
        
        $('#facebook-likebox-close').click(function(e) {
          e.preventDefault();
          setCookie("facebook_likebox", 'shown', 30);
          $('#facebook-likebox').removeClass('show');
        });        
      }

      /* blur */
      /*
      var timer = 2000;
      $('.blurred-background-inner', context).each(function() {
        var target = $(this).attr('id');
        var source = $(this).find('.blur').attr('id');
        setTimeout(function() {
          $('#' + target).blurjs({
            source : '#' + source,
            radius : 20,
            overlay : 'rgba(0, 0, 0, .2)',
            optClass : 'blurred',
            cache : false
          });
          timer += 2000;
        }, timer);
      });
      */
    }
  };
})(jQuery); 

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}