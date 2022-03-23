$(document).ready(function () {
  'use strict';
  //Dashboard
  $('.toggle-info').click(function (){
    $(this).parent().next('.panel-body').fadeToggle();
  });
  // triger the selectBox
  $("select").selectBoxIt({
    autoWidth:false
  });
  //Hide Placeholser on form focus
    $('[placeholder]').focus(function () {
      $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function (){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    // add asterisk on requierd field
    $("input").each(function (){
      if ($(this).attr("required") === "required"){
        $(this).after('<span class = "asterisk" >*</span>');
        


      }
    });
    // convert password filed to hover filed
    var passfield = $('.password');
    $('.show-pass').hover(function(){
      passfield.attr('type', 'text');

    }, function(){
      passfield.attr('type', 'password');
      

    });
    // Confirmation Message On Button 
    $('.confirm').click(function(){
      return confirm('Are You Sure To Delete This Item');
    });
    // catogery view option
    $('.cat h3').click(function() {
        $(this).next('.full-view').fadeToggle(200);
    });
    $('.option span').click(function () {
        $(this).addClass('active').siblings('span').removeClass('active');
        if ($(this).data('view') === 'full') {
          $('.cat .full-view').fadeIn(200);
        } else {
          $('.cat .full-view').fadeToggle(200);
        }
    });
    
  
  });