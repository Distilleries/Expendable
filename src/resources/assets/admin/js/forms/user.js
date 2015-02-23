// Check instance
if (typeof dist == "undefined" || !dist) {
    var dist = {};
}
if (typeof dist.Form == "undefined" || !dist.Form) {
    dist.Form = {};
}

if (typeof dist.Form.User == "undefined" || !dist.Form.User) {
    dist.Form.User = {};
}

dist.Form.User.Global = function () {
    this.init();
};

// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------

dist.Form.User.Global.prototype = {

    ie8: (document.all && document.querySelector && !document.addEventListener) ? true : false,

    // --------------------------------------------------------------------------------------------

    init: function () {
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
        jQuery(window).load(jQuery.proxy(this, 'onWindowLoad'));
    },

    // --------------------------------------------------------------------------------------------
    onDocumentReady: function () {
        this.initEvents();

        var $element = jQuery('#change_password');
        if ($element.length > 0) {
            this.toogleElements();
        }

        var $element = jQuery('input[name="user[change_password]"]');
        if ($element.length > 0) {
            this.toogleSubElements();
        }
    },

    // --------------------------------------------------------------------------------------------
    onWindowLoad: function () {
    },
    // --------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------

    initEvents: function () {
        jQuery('#change_password').off('click.user').on('click.user', jQuery.proxy(this.toogleElements, this));
        jQuery('input[name="user[change_password]"]').off('click.user').on('click.user', jQuery.proxy(this.toogleSubElements, this));
    },

    toogleElements: function () {
        var $target = jQuery('#change_password');

        if ($target.is(':checked')) {
            jQuery('#password').parents('.form-group').show();
            jQuery('#password_match').parents('.form-group').show();
        } else {
            jQuery('#password').parents('.form-group').hide();
            jQuery('#password_match').parents('.form-group').hide();
        }

    },

    toogleSubElements:function () {
        var $target = jQuery('input[name="user[change_password]"]');

        if ($target.is(':checked')) {
            jQuery('input[name="user[password]"]').parents('.form-group').show();
            jQuery('input[name="user[password_match]"]').parents('.form-group').show();
        } else {
            jQuery('input[name="user[password]"]').parents('.form-group').hide();
            jQuery('input[name="user[password_match]"]').parents('.form-group').hide();
        }
    }


};
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
// Run instance
new dist.Form.User.Global();