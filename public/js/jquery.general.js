(function($){
   
   var formClassName = ".promote-form";
   var msgBox = $("<p></p>").css({"text-align":"right","margin-right":"12%"});
   var detailMsg = "Add more detail ?";
   var extraBoxEl = $(formClassName+" .extra");
   var tagInputEl = $(formClassName+" #tag");
   
  $('.datepicker').datepicker();     
  
  $(".refresh-captcha").unbind("click",refreshCaptcha).bind("click",refreshCaptcha);
  
  extraBoxEl.css({"height":"0px","overflow":"hidden"});
  tagInputEl.unbind("blur",optionalDetailMsg).bind("blur",optionalDetailMsg);
  msgBox.unbind("click",displayExtra).bind("click",displayExtra);
  
  function displayExtra(){
     
      extraBoxEl.animate({
          "height":"5%",
          
      },5000);
          
  }
  
  function optionalDetailMsg(){
      
      var elementBox = $(this).parent();
      msgBox.text(detailMsg);
     
      elementBox.append(msgBox);
  }
  
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


