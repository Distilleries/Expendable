<script type="text/javascript">

   (function($){
       $.fn.validationEngineLanguage = function(){
       };
       $.validationEngineLanguage = {
           newLang: function(){
               $.validationEngineLanguage.allRules = {
                   "required": { // Add your regex rules here, you can take telephone as an example
                       "regex": "none",
                       "alertText": "{{ _("* This field is required") }}",
                       "alertTextCheckboxMultiple": "{{ _("* Please select an option") }}",
                       "alertTextCheckboxe": "{{ _("* This checkbox is required") }}",
                       "alertTextDateRange": "{{ _("* Both date range fields are required") }}"
                    },
                   "dateRange": {
                       "regex": "none",
                       "alertText": "{{ _("* Invalid ") }}",
                       "alertText2": "{{ _("Date Range") }}"
                   },
                   "dateTimeRange": {
                       "regex": "none",
                       "alertText": "{{ _("* Invalid ") }}",
                       "alertText2": "{{ _("Date Time Range") }}"
                   },
                   "minSize": {
                       "regex": "none",
                       "alertText": "{{ _("* Minimum ") }}",
                       "alertText2": "{{ _(" characters required") }}"
                   },
                   "maxSize": {
                       "regex": "none",
                       "alertText": "{{ _("* Maximum ") }}",
                       "alertText2": "{{ _(" characters allowed") }}"
                   },
   				"groupRequired": {
                       "regex": "none",
                       "alertText": "{{ _("* You must fill one of the following fields") }}"
                   },
                   "min": {
                       "regex": "none",
                       "alertText": "{{ _("* Minimum value is ") }}"
                   },
                   "max": {
                       "regex": "none",
                       "alertText": "{{ _("* Maximum value is ") }}"
                   },
                   "past": {
                       "regex": "none",
                       "alertText": "{{ _("* Date prior to ") }}"
                   },
                   "future": {
                       "regex": "none",
                       "alertText": "{{ _("* Date past ") }}"
                   },
                   "maxCheckbox": {
                       "regex": "none",
                       "alertText": "{{ _("* Maximum ") }}",
                       "alertText2": "{{ _(" options allowed") }}"
                   },
                   "minCheckbox": {
                       "regex": "none",
                       "alertText": "{{ _("* Please select ") }}",
                       "alertText2": "{{ _(" options") }}"
                   },
                   "equals": {
                       "regex": "none",
                       "alertText": "{{ _("* Fields do not match") }}"
                   },
                   "creditCard": {
                       "regex": "none",
                       "alertText": "{{ _("* Invalid credit card number") }}"
                   },
                   "phone": {
                       // credit: jquery.h5validate.js / orefalo
                       "regex": /^([\+][0-9]{1,3}[\ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9\ \.\-\/]{3,20})((x|ext|extension)[\ ]?[0-9]{1,4})?$/,
                       "alertText":"{{ _( "* Invalid phone number") }}"
                   },
                   "email": {
                       // HTML5 compatible email regex ( http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#    e-mail-state-%28type=email%29 )
                       "regex": /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                       "alertText": "{{ _("* Invalid email address") }}"
                   },
                   "integer": {
                       "regex": /^[\-\+]?\d+$/,
                       "alertText": "{{ _("* Not a valid integer") }}"
                   },
                   "number": {
                       // Number, including positive, negative, and floating decimal. credit: orefalo
                       "regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                       "alertText": "{{ _("* Invalid floating decimal number") }}"
                   },
                   "date": {
                       //	Check if date is valid by leap year
                "func": function (field) {
                        var pattern = new RegExp(/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/);
                        var match = pattern.exec(field.val());
                        if (match == null)
                           return false;

                        var year = match[1];
                        var month = match[2]*1;
                        var day = match[3]*1;
                        var date = new Date(year, month - 1, day); // because months starts from 0.

                        return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
   				},
   			 "alertText": "{{ _("* Invalid date, must be in YYYY-MM-DD format") }}"
                   },
                   "ipv4": {
                       "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                       "alertText": "{{ _("* Invalid IP address") }}"
                   },
                   "url": {
                       "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                       "alertText": "{{ _("* Invalid URL") }}"
                   },
                   "onlyNumberSp": {
                       "regex": /^[0-9\ ]+$/,
                       "alertText": "{{ _("* Numbers only") }}"
                   },
                   "onlyLetterSp": {
                       "regex": /^[a-zA-Z\ \']+$/,
                       "alertText": "{{ _("* Letters only") }}"
                   },
                   "onlyLetterNumber": {
                       "regex": /^[0-9a-zA-Z]+$/,
                       "alertText": "{{ _("* No special characters allowed") }}"
                   },
                   //tls warning:homegrown not fielded
                   "dateFormat":{
                       "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                       "alertText": "{{ _("* Invalid Date") }}"
                   },
                   //tls warning:homegrown not fielded
   				"dateTimeFormat": {
   	                "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                       "alertText": "{{ _("* Invalid Date or Date Format") }}",
                       "alertText2": "{{ _("Expected Format: ") }}",
                       "alertText3": "{{ _("mm/dd/yyyy hh:mm:ss AM|PM or ") }}",
                       "alertText4": "{{ _("yyyy-mm-dd hh:mm:ss AM|PM") }}"
   	            }
               };

           }
       };

       $.validationEngineLanguage.newLang();

   })(jQuery);

</script>
