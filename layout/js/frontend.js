$(document).ready(function () {
    'use strict';
    // Switch Between Login &SignUp
  $('.login-page h1 span').click(function () {
      $(this).addClass('selected').siblings().removeClass('selected');
      $('.login-page form').hide();
      $('.' + $(this).data('class')).fadeIn(100);
      
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
        // Confirmation Message On Button
      $('.confirm').click(function(){
        return confirm('Are You Sure To Delete This Item');
      });
     $('.live').keyup(function () {
       $($(this).data('class')).text($(this).val());
     });
    });