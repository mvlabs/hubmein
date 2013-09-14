(function($){
   
  $('.datepicker').datepicker();     
  
  $(".refresh-captcha").unbind("click",refreshCaptcha).bind("click",refreshCaptcha);
  
  function refreshCaptcha(){
        
      var captchaImg = $(".promote-form img");
      var captchaHidden = captchaImg.next(":hidden");
      var url = $(this).attr("href");
      var d = new Date();
      
      $.ajax({
          url:url,
          dataType:'json',
          success: function(data){
                 
             if(data.success){
                captchaImg.attr("src",data.captcha_data.href+"?"+d.getTime());
                captchaHidden.val(data.captcha_data.id);
              }
              
          }
          
      });
      return false;
  }
  
})(jQuery);


