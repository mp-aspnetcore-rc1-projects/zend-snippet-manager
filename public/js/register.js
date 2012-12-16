// @NOTE @JQUERY valider un login ou un email unique contre un webservice 
// SCRIPT for registration form
// checks if username or email is already used
// require jQuery
// @usage $("#username").checkInputField({existsProp:"the json field to check in the json response , must be a boolean","url":"/account/exists",cssClass:"a-css-class",errorClass:"an-error-class"}); 
//        response format : {"exists":true|false} , for instance : {"exist":true}
$.fn.checkInputField = function(_options) {
    var options, $after,currentValue;
    if (this.prop("tagName") != "INPUT") {
        console.error("The given element should be an input element");
        return;
    }
    options = {
        url: null,
        existsProp: "exists",
        errorClass: "error",
        cssClass: this.prop('name'),
        validMessage :this.prop('name') + " is unique" ,
        unvalidMessage : this.prop('name') + " already exists , please choose another one",
        id :  "after-" + this.prop('name'),
        element :"<p>"
    };
    $.extend(options, _options);
    $after = $(options.element, {
        id:options.id,
        "class": options.cssClass
    });
    this.after($after);
    this.after().addClass(options.cssClass);
    this.blur(function(event) {
        var fieldName = event.currentTarget.name;
        if(currentValue===event.currentTarget.value){
          return ;
        }
        currentValue = event.currentTarget.value ;
        var datas = {};
        datas[fieldName] = this.value;
        $.getJSON(options.url, datas , function(datas) {
            if (datas[options.existsProp] == true) {
                // field is not unique
                $after.addClass(options.errorClass);
                $after.hide().text(options.unvalidMessage ).fadeIn();
            } else {
                // field is unique
                $after.removeClass(options.errorClass);
                $after.hide().text(options.validMessage).fadeIn();
            }
        });
    });

};

$("#username").checkInputField({
    url: "./exist"
});
$("#email").checkInputField({
    url: "./exist"
});
