// Check instance
if (typeof dist == "undefined" || !dist) {
    var dist = {};
}
if (typeof dist.Form == "undefined" || !dist.Form) {
    dist.Form = {};
}

if (typeof dist.Form.Permission == "undefined" || !dist.Form.Permission) {
    dist.Form.Permission = {};
}

dist.Form.Permission.Global = function () {
    this.init();
};

// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------

dist.Form.Permission.Global.prototype = {

    ie8: (document.all && document.querySelector && !document.addEventListener) ? true : false,

    // --------------------------------------------------------------------------------------------

    init: function () {
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
        jQuery(window).load(jQuery.proxy(this, 'onWindowLoad'));
    },

    // --------------------------------------------------------------------------------------------
    onDocumentReady: function () {
        this.initEvents();
    },

    // --------------------------------------------------------------------------------------------
    onWindowLoad: function () {
    },
    // --------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    initEvents: function () {
        jQuery('tbody .icheck').on('ifChecked', jQuery.proxy(this.changeColorInBlue, this));
        jQuery('tbody .icheck').on('ifUnchecked', jQuery.proxy(this.changeColorInGrey, this));
        jQuery('.check-all').on('ifChecked', jQuery.proxy(this.checkAll, this));
        jQuery('.uncheck-all').on('ifChecked', jQuery.proxy(this.uncheckAll, this));
    },

    changeColorInGrey: function (evt) {
        var $target = jQuery(evt.target);
        $target.addClass('icheckbox_line-grey').removeClass('icheckbox_line-blue');
        $target.parent().addClass('icheckbox_line-grey').removeClass('icheckbox_line-blue');
    },
    changeColorInBlue: function (evt) {
        var $target = jQuery(evt.target);
        $target.addClass('icheckbox_line-blue').removeClass('icheckbox_line-grey');
        $target.parent().addClass('icheckbox_line-blue').removeClass('icheckbox_line-grey');
    },

    checkAll: function (evt) {
        var $target = jQuery(evt.target);
        jQuery('input[name*="['+$target.prop('name')+'][]"]').iCheck('check');
    },

    uncheckAll: function (evt) {
        var $target = jQuery(evt.target);
        jQuery('input[name*="['+$target.prop('name')+'][]"]').iCheck('uncheck');
    }


};
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// Run instance
new dist.Form.Permission.Global();