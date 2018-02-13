<script type="text/javascript">
    (function ($) {
        $.fn.validationEngineLanguage = function () {
        };
        $.validationEngineLanguage = {
            newLang: function () {
                $.validationEngineLanguage.allRules = {
                    "required": { // Add your regex rules here, you can take telephone as an example
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.required.alertText') }}",
                        "alertTextCheckboxMultiple": "{{ trans('expendable::validation.validation-engine.required.alertTextCheckboxMultiple') }}",
                        "alertTextCheckboxe": "{{ trans('expendable::validation.validation-engine.required.alertTextCheckboxe') }}",
                        "alertTextDateRange": "{{ trans('expendable::validation.validation-engine.required.alertTextDateRange')  }}"
                    },
                    "dateRange": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.dateRange.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.dateRange.alertText2') }}"
                    },
                    "dateTimeRange": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.dateTimeRange.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.dateTimeRange.alertText2') }}"
                    },
                    "minSize": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.minSize.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.minSize.alertText2') }}"
                    },
                    "maxSize": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.maxSize.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.maxSize.alertText2') }}"
                    },
                    "groupRequired": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.groupRequired.alertText') }}"
                    },
                    "min": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.min.alertText') }}"
                    },
                    "max": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.max.alertText') }}"
                    },
                    "past": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.past.alertText') }}"
                    },
                    "future": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.future.alertText') }}"
                    },
                    "maxCheckbox": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.maxCheckbox.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.maxCheckbox.alertText2') }}"
                    },
                    "minCheckbox": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.minCheckbox.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.minCheckbox.alertText2') }}"
                    },
                    "equals": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.equals.alertText') }}"
                    },
                    "creditCard": {
                        "regex": "none",
                        "alertText": "{{ trans('expendable::validation.validation-engine.creditCard.alertText') }}"
                    },
                    "phone": {
                        // credit: jquery.h5validate.js / orefalo
                        "regex": /^([\+][0-9]{1,3}[\ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9\ \.\-\/]{3,20})((x|ext|extension)[\ ]?[0-9]{1,4})?$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.phone.alertText') }}"
                    },
                    "email": {
                        // HTML5 compatible email regex ( http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#    e-mail-state-%28type=email%29 )
                        "regex": /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.email.alertText') }}"
                    },
                    "integer": {
                        "regex": /^[\-\+]?\d+$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.integer.alertText') }}"
                    },
                    "number": {
                        // Number, including positive, negative, and floating decimal. credit: orefalo
                        "regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.number.alertText') }}"
                    },
                    "date": {
                        //	Check if date is valid by leap year
                        "func": function (field) {
                            var pattern = new RegExp(/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/);
                            var match = pattern.exec(field.val());
                            if (match == null) {
                                return false;
                            }

                            var year = match[1];
                            var month = match[2] * 1;
                            var day = match[3] * 1;
                            var date = new Date(year, month - 1, day); // because months starts from 0.

                            return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
                        },
                        "alertText": "{{ trans('expendable::validation.validation-engine.date.alertText') }}"
                    },
                    "ipv4": {
                        "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.ipv4.alertText') }}"
                    },
                    "url": {
                        "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                        "alertText": "{{ trans('expendable::validation.validation-engine.url.alertText') }}"
                    },
                    "onlyNumberSp": {
                        "regex": /^[0-9\ ]+$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.onlyNumberSp.alertText') }}"
                    },
                    "onlyLetterSp": {
                        "regex": /^[a-zA-Z\ \']+$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.onlyLetterSp.alertText') }}"
                    },
                    "onlyLetterNumber": {
                        "regex": /^[0-9a-zA-Z]+$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.onlyLetterNumber.alertText') }}"
                    },
                    "dateFormat": {
                        "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.dateFormat.alertText') }}"
                    },
                    "dateTimeFormat": {
                        "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                        "alertText": "{{ trans('expendable::validation.validation-engine.dateTimeFormat.alertText') }}",
                        "alertText2": "{{ trans('expendable::validation.validation-engine.dateTimeFormat.alertText2') }}",
                        "alertText3": "{{ trans('expendable::validation.validation-engine.dateTimeFormat.alertText3') }}",
                        "alertText4": "{{ trans('expendable::validation.validation-engine.dateTimeFormat.alertText4') }}"
                    }
                };
            }
        };

        $.validationEngineLanguage.newLang();
    })(jQuery);
</script>