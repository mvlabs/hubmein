(function($) {

    var form = $('form[name="search"]');
    var regionInput = form.find(':input[name="region"]');
    var periodInput = form.find(':input[name="period"]');
    var countLoader = $(".count-loader");
    var submitLoaderImg = $(".submit-loader");
    var resetSearchButton = $(".reset-filters");

    var routeName = "conferences";
    var topicsElement = "select.topics";

    //Enable all input field if mode equal to enableAll
    //Disable input if its name is "region" or its value is "all"

    $.fn.disableInputField = function(mode) {

        $(this).find(":input").not(':submit').each(function() {

            var inputField = $(this);
                     
           if (inputField.attr('name') === undefined) {

                return;

            }
 
            switch (mode) {

                case "disableAll":
                                      
                    if (inputField.val() === "*" || inputField.val() === "" || inputField.attr('name') === "region" ) {

                        inputField.attr('disabled', true);

                    }

                    break;

                case "enableAll":

                    inputField.attr('disabled', false);

                    break;

                default:

                    alert('missing "enableAll" or "disableAll" on mode');

                    break;
            }
        });

    };

    //get the number of element from input values13cx202e
    $.fn.getTotalCountByFilter = function() {
                       
        var loader = $(this).find('div[class="loader"]');
        var formController = getRouteName()+ "/count"+getRegionValue();
        var preparedForm = prepareFormValues($(this));
        var url = (preparedForm.serialize() !== "") ? formController + "?" + preparedForm.serialize() : formController;
        var result = $(this).find(".result");
     
        form.disableInputField("enableAll");
        loader.hide();
        
        countLoader.show();
        result.hide();
           
        countLoader.css({"background":"url('/images/ajax-loader.gif') no-repeat"});
        countLoader.text("");
        
        loader.load(url, function(data) {
            
            var obj = $.parseJSON(data);

            if (obj.success) {
                
                var event = (obj.count > 1)? "events" : "event";
                countLoader.css({"background":"none"});
                countLoader.text(obj.count+" "+event+" found");
                displayResetFilter();
                setTopicsDefaultValue();
                
            }

        });

    };
    
  
    form.find(":radio").change(function(){
       
       form.getTotalCountByFilter();
        
    });
    
    //Commands
      
    form.attr('action', '');

    showCondition(false);

    submitLoaderImg.hide();
           
    checkTagsContentSize($(topicsElement));

    form.disableInputField('enableAll');
    
    //Init select2 plugin
    
    setTopicsDefaultValue();
    
    //Set the tags when a search is performed
    setTagsAfterSearch();
              
    $(topicsElement).change(function() {
        
        checkTagsContentSize();
        
        form.getTotalCountByFilter();
                        
    });
       
    regionInput.change(function() {
        
       form.getTotalCountByFilter();

    });
    
     periodInput.change(function() {

        form.getTotalCountByFilter();

    });
    
   resetSearchButton.unbind("click", resetFields)
                     .bind('click', resetFields);
   
   $(".select2-choices").find(".select2-search-choice").addClass("tagbutton");
   
   displayResetFilter();
       
     
   form.submit(function() {
        
        var formAction = getRouteName()+getRegionValue();
      
        prepareFormValues($(this));

        regionInput.parent('div').hide();
        periodInput.parent('div').hide();
        $(topicsElement).parent('div').hide();
        resetSearchButton.hide();
        
        form.find(":submit").hide();
        
        submitLoaderImg.show();
        
        form.attr('action',formAction);
           
   });
   
   function getRouteName(){
       
       var currentPathName = location.pathname.substring(1);
       pathNamePart = currentPathName.split("/");
      
       if( pathNamePart[0] !== ""  && pathNamePart[0] !== routeName){
           
           routeName = pathNamePart[0];
           
       }
      
       return "/"+routeName;
       
   }
   
   function setTopicsDefaultValue(){
       
       $(topicsElement).select2(); 
       
       if($(topicsElement).val() === null) {
           
           $(topicsElement).select2({placeholder: "Pick a topics"}); 
           
       }
       
   }
     
   //Hide the link to reset filters based on search field value
   function displayResetFilter(){
         
      resetSearchButton.css({"visibility":"visible"});
      
      if( regionInput.val() === "*" && periodInput.val() === "*" && $(topicsElement).val() === null ) {
          
           resetSearchButton.css({"visibility":"hidden"});
          
      }
                
   }

    //internal function 
    function resetFields() {

        $(topicsElement).select2("val",[]);
        $(countLoader).text("");
              
        form.find(":selected").each(function() {

            $(this).removeAttr("selected");

        });

    }
    
    
    function setTagsAfterSearch(){
                
        var tagsToSelect = getUrlParam('tags');
        var tags = [];
             
        if( tagsToSelect !== "null") {
            
            tags = tagsToSelect.replace("+"," ")
                               .split(",");
           
        }
               
        $(topicsElement).select2("val",tags);
            
    }
    
    
    function getUrlParam(name) {
      
        return decodeURIComponent((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
        
    }
   
    
    function prepareFormValues(form) {

        form.disableInputField('disableAll');
        checkTagsContentSize($(topicsElement));
        buildTagRequest(form);

        return form;
    }

    function buildTagRequest(form) {

        //var tagElement = form.find(topicsElement);
        var tagValues = getTopicsContent();
        var tagAppendix = "tags";
        var queryTag = tagValues.join(",");
        var input = $("<input>").attr("type", "hidden").attr("name", tagAppendix).val(queryTag);
        var hiddenValue = form.find(":hidden[name='tags']");
        
        hiddenValue.remove();
        
        if ( tagValues.length > 0 ) {
            
            form.append(input);
        }

    }


    function disableRegion(isDisabled) {

        regionInput.attr('disable', isDisabled);

    }

    function getRegionValue() {
        
        var selectedValue = regionInput.find(":selected").val();
                    
        var regionUrl = ( selectedValue !== "*") ? "/" +  selectedValue: "";
        
        return regionUrl;

    }
    
    function getTopicsContent() {
        
        var totalTags = $(topicsElement).select2("val");
               
        return totalTags;
        
    }
    
    function checkTagsContentSize() {
      
        var totalTags = getTopicsContent();
        var contentSize = totalTags.length;
                      
        if (contentSize > 1) {
            
            showCondition(true);

        }

        if (contentSize <= 1) {

            showCondition(false);

        }
        
    }
    
    
    function showCondition(show) {

        var conditionBox = $('.type-condition');
          
        conditionBox.find(":checked").attr("disabled", false);
        conditionBox.show();

        if (show === false) {

            conditionBox.find(":checked").attr("disabled", true);
            conditionBox.hide();

        }

    }


})(jQuery);



