(function($) {

    var form = $('form[name="search"]');
    var regionInput = form.find(':input[name="region"]');
    var periodInput = form.find(':input[name="period"]');
    var countLoaderImg = $(".count-loader");
    var submitLoaderImg = $(".submit-loader");
    var resetSearchButton = $(".reset-filters");

    var moduleName = "/events";
    var topicsElement = ".chzn-select.topics";


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

        var loader = $(this).find('div[class="loader"]');
        var formController = moduleName+ "/count"+getRegionValue();
        var preparedForm = prepareFormValues($(this));
        var url = (preparedForm.serialize() !== "") ? formController + "?" + preparedForm.serialize() : formController;
        var result = $(this).find(".result");
        
        form.disableInputFiled("enableAll");
       
        loader.hide();
        
        countLoaderImg.show();
        result.hide();
        
        loader.load(url, function(data) {
            
            var obj = $.parseJSON(data);

            if (obj.success) {
                
                countLoaderImg.hide();
                result.text(obj.count);
                result.show();

            }

        });

    };
    
   $(".chzn-select").val("city");
   $(".chzn-select").trigger("liszt:updated");
    
    $(topicsElement).chosen().change(function() {

        checkTagsContentSize($(this));
        form.getTotalCountByFilter();
        
    });
    
    form.find(":radio").change(function(){
       
       form.getTotalCountByFilter();
        
    });
    
    //Commands

    form.attr('action', '');

    showCondition(false);

    submitLoaderImg.hide();
    countLoaderImg.hide();

    checkTagsContentSize($(topicsElement));

    form.disableInputFiled('enableAll');

    periodInput.change(function() {

        form.getTotalCountByFilter();

    });


    regionInput.change(function() {

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

        $(".chzn-select").val('').trigger("liszt:updated");
        form.find(":selected").each(function() {

            $(this).removeAttr("selected");

        });

    }

    function prepareFormValues(form) {

        form.disableInputFiled('disableAll');
        checkTagsContentSize($(topicsElement));
        buildTagRequest(form);

        return form;
    }

    function buildTagRequest(form) {

        var tagElement = form.find(topicsElement);
        var tagValues = tagElement.val();
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

    function checkTagsContentSize(tagElement) {

        var tagElement = tagElement;
        var selectedValue = tagElement.val();
        var contentSize = (selectedValue !== null) ? selectedValue.length : 0;
                      
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



