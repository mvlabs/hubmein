(function($) {

    var form = $('form[name="search"]');
    var regionInput = form.find(':input[name="region"]');
    var periodInput = form.find(':input[name="period"]');
    var countLoaderImg = $(".count-loader");
    var submitLoaderImg = $(".submit-loader");
    var resetSearchButton = $(".reset-filters");

    var moduleName = "/conferences";
<<<<<<< HEAD
    var topicsElement = ".topics";
=======
    var topicsElement = "select.topics";
>>>>>>> FETCH_HEAD

    //Enable all input field if mode equal to enableAll
    //Disable input if its name is "region" or its value is "all"

    $.fn.disableInputFiled = function(mode) {

        $(this).find(":input").not(':submit').each(function() {

            var inputField = $(this);

            if (inputField.attr('name') === undefined) {

                return;

            }

            switch (mode) {

                case "disableAll":

                    if (inputField.val() === "*" || inputField.val() === "" || inputField.attr('name') === "region") {

                        inputField.attr('disabled', true);

                    }

<<<<<<< HEAD

=======
>>>>>>> FETCH_HEAD
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

    //get the number of element from input values
    $.fn.getTotalCountByFilter = function() {
<<<<<<< HEAD

=======
        
                
>>>>>>> FETCH_HEAD
        var loader = $(this).find('div[class="loader"]');
        var formController = moduleName+ "/count"+getRegionValue();
        var preparedForm = prepareFormValues($(this));
        var url = (preparedForm.serialize() !== "") ? formController + "?" + preparedForm.serialize() : formController;
        var result = $(this).find(".result");
<<<<<<< HEAD
        
=======
             
>>>>>>> FETCH_HEAD
        
        form.disableInputFiled("enableAll");
       
        loader.hide();
        
        countLoaderImg.show();
        result.hide();
        
<<<<<<< HEAD
=======
        countLoaderImg.css({"background":"url('/images/ajax-loader.gif') no-repeat"});
        countLoaderImg.text("");
        
>>>>>>> FETCH_HEAD
        loader.load(url, function(data) {
            
            var obj = $.parseJSON(data);

            if (obj.success) {
                
<<<<<<< HEAD
                countLoaderImg.hide();
                result.text(obj.count);
                result.show();

=======
                var event = (obj.count > 1)? "events" : "event";
                countLoaderImg.css({"background":"none"});
                countLoaderImg.text(obj.count+" "+event+" found");
                displayResetFilter();
                setTopicsDefaultValue();
                
>>>>>>> FETCH_HEAD
            }

        });

    };
    
    
  
    form.find(":radio").change(function(){
       
       form.getTotalCountByFilter();
        
    });
    
    //Commands
<<<<<<< HEAD

       
=======
      
>>>>>>> FETCH_HEAD
    form.attr('action', '');

    showCondition(false);

    submitLoaderImg.hide();
<<<<<<< HEAD
    countLoaderImg.hide();
    
    
=======
           
>>>>>>> FETCH_HEAD
    checkTagsContentSize($(topicsElement));

    form.disableInputFiled('enableAll');

<<<<<<< HEAD
    periodInput.change(function() {

        form.getTotalCountByFilter();

    });
    
    //Init select2 plugin
    $(topicsElement).select2();
    //Set the tags when a search is performed
    setTagsAfterSearch();
     
         
    $(topicsElement).change(function() {
        
        checkTagsContentSize();
             
        form.getTotalCountByFilter();
        
    });
     
     
     
    regionInput.change(function() {
        
       // checkTagContentSize();
       
        form.getTotalCountByFilter();

    });

    resetSearchButton.unbind("click", resetFields).bind('click', resetFields);

    form.submit(function() {
        
        var formAction = moduleName+getRegionValue();
        var preparedForm = prepareFormValues($(this));

        regionInput.parent('p').hide();
        periodInput.parent('p').hide();

        submitLoaderImg.show();

        form.attr('action',formAction);
        
        alert(formAction);
        
   });

    //internal function 

    function resetFields() {

        $(topicsElement).select2("val",[]);
=======
   
    
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
   
   
   displayResetFilter();
     
     
   form.submit(function() {
        
        var formAction = moduleName+getRegionValue();
        prepareFormValues($(this));

        regionInput.parent('div').hide();
        periodInput.parent('div').hide();
        form.find(":submit").hide();
        
        submitLoaderImg.show();
        
        form.attr('action',formAction);
           
   });
   
   
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
        
>>>>>>> FETCH_HEAD
        form.find(":selected").each(function() {

            $(this).removeAttr("selected");

        });

    }
    
<<<<<<< HEAD
=======
    
>>>>>>> FETCH_HEAD
    function setTagsAfterSearch(){
        
        
        var tagsToSelect = getUrlParam('tags');
        var tags = [];
                
        if( tagsToSelect !== "null") {
            
            tags = tagsToSelect.split(",");
           
        }
      
        $(topicsElement).select2("val",tags);
    
        
    }
    
<<<<<<< HEAD
=======
    
>>>>>>> FETCH_HEAD
    function getUrlParam(name) {
      
        return decodeURIComponent((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]);
        
    }
   
    
    function prepareFormValues(form) {

        form.disableInputFiled('disableAll');
        checkTagsContentSize($(topicsElement));
        buildTagRequest(form);

        return form;
    }

    function buildTagRequest(form) {

        var tagElement = form.find(topicsElement);
        var tagValues = getTopicsContent();
        var tagAppendix = "tags";

        var hiddenValue = form.find(":hidden[name='tags']");
        hiddenValue.remove();


        if (tagValues !== null) {

            var queryTag = tagValues.join(",");
            var input = $("<input>").attr("type", "hidden").attr("name", tagAppendix).val(queryTag);
            form.append(input);
        }

    }


    function disableRegion(isDisabled) {

        regionInput.attr('disable', isDisabled);

    }

    function getRegionValue() {
        
        var regionValue = ( regionInput.attr('value') !== "*") ? "/" +  regionInput.attr('value') : "";
        
        return regionValue;

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



