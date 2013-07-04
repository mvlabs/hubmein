(function($){
    
    var form = $('form[name="search"]');
    var regionInput = form.find(':input[name="region"]');
    var periodInput = form.find(':input[name="period"]');
    var moduleName = "/events";
    var topicsElement = ".chzn-select.topics";
   
   
   form.attr('action','');
                 
   //Enable all input field if mode equal to enableAll
   //Disable input if its name is "region" or its value is "all"
         
   $.fn.disableInputFiled = function(mode) {     
       
       $(this).find(":input").not(':submit').each(function(){
            
            var inputField = $(this);
                     
           if(inputField.attr('name') === undefined) {
               
               return ;
               
           }
          
            switch(mode){

               case "disableAll":

                 if( inputField.val() === "*" || inputField.val() === "" || inputField.attr('name') === "region") {

                   inputField.attr('disabled',true);

                 }
                 
                
               break;

               case "enableAll":

                    inputField.attr('disabled',false);

                break;

               default:

                   alert('missing "enableAll" or "disableAll" on mode');

                   break;
           }
        });
                        
   };
   
   //get the number of element from input values
   $.fn.getTotalCountByFilter = function(){
       
       var loader = $(this).find('div[class="count-loader"]');
       var formAction = getActionUrl();
       var preparedForm = prepareFormValues($(this));
       var url = (preparedForm.serialize() !== "")?formAction+"?"+preparedForm.serialize():formAction;
       
       form.disableInputFiled("enableAll");
       countLoader.show();   
       alert(url);
       
       return false;
       
       loader.load(moduleName,function(data){
           
       });
             
   };
   
   $(topicsElement).chosen().change(function() {
       
        checkTagsContentSize($(this));  
        form.getTotalCountByFilter();
        
   });
   
   //Commands
   
   showCondition(false);
   
   checkTagsContentSize($(topicsElement));  
     
   form.disableInputFiled('enableAll');
   
   periodInput.change(function(){
       
       form.getTotalCountByFilter();
       
   });
   
   showCondition(false);
   
   regionInput.change(function(){
       
       form.getTotalCountByFilter();
       
   });
      
   form.submit(function(){

        var formAction = getActionUrl();
        var preparedForm = prepareFormValues($(this));

        form.attr('action',formAction);

        alert(preparedForm.serialize());
        return false;

    });

    //internal function 
    
    function prepareFormValues(form) {

        form.disableInputFiled('disableAll');
        checkTagsContentSize($(topicsElement));  
        buildTagRequest(form);

         return form;
    }
     
    function getActionUrl() {
         
         var regionValue = (getRegionValue() !== "*") ? "/"+getRegionValue() : "";
         var baseAction = moduleName+regionValue;
         
        
         
         return baseAction;
    }
     
    function buildTagRequest(form) {
         
         var tagElement = form.find(topicsElement); 
         var tagValues = tagElement.val();
         var tagAppendix = "tags";
         
         var hiddenValue = form.find(":hidden[name='tags']");
         hiddenValue.remove();

         
         if(tagValues  !== null) {
             
             var queryTag = tagValues.join(",");
             var input = $("<input>").attr("type", "hidden").attr("name", tagAppendix).val(queryTag);
              form.append(input);
         }
                
     }
     
     
    function disableRegion( isDisabled ) {
         
         regionInput.attr('disable',isDisabled);
         
     }
          
    function getRegionValue(){
        
        return  regionInput.attr('value');
         
    }
     
     
     
     function checkTagsContentSize(tagElement) {
         
         var tagElement = tagElement;
         var selectedValue = tagElement.val();
         var contentSize = ( selectedValue !== null )? selectedValue.length : 0;
         
         
         if(contentSize > 1) {

               showCondition(true);

         }

         if(contentSize  <= 1) {

             showCondition(false);

         }
              
     }
    
     
      function showCondition(show){
        
        var conditionBox = $('.type-condition');
        conditionBox.find(":checked").attr("disabled",false);
              
         if(show === false) {
             
             conditionBox.find(":checked").attr("disabled",true);
             conditionBox.hide();
             
         }
        
     }
     
    
})(jQuery);
    


