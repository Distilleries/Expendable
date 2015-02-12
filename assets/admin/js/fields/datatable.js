// Check instance
if (typeof dist == "undefined" || !dist) {
    var dist = {};
}
if (typeof dist.Form == "undefined" || !dist.Form) {
    dist.Form = {};
}

if (typeof dist.Form.Fields == "undefined" || !dist.Form.Fields) {
    dist.Form.Fields = {};
}

dist.Form.Fields.DatatableUtils = {

    getInstance: function (target) {
        var $target = $(target);
        if (typeof($target) == 'undefined' || $target == null || $target == '') {
            return false;
        }

        var dt =  $('.dataTable',$target.parents('.row')).dataTable();

        return dt;
    },

    getFilterform: function (target) {
        var $target = $(target);

        if (typeof($target) == 'undefined' || $target == null || $target == '') {
            return false;
        }

        var form = $('.row-filter form',$target.parents('.row'));

        console.log(form);
        return form;

    },

    addSessionFilters: function (aoData,target) {
        var form = $('.row-filter form',target.parents('.row'));
        var data = form.serializeArray();

        for (var i in data) {
            aoData.push({ name: data[i].name, value: data[i].value});
        }

        return aoData;
    },

    initFilters:function(selector_reset, selector_submit){

        $(selector_reset).off('click').on('click', function (event) {

            event.preventDefault();
            var form = dist.Form.Fields.DatatableUtils.getFilterform(event.currentTarget);
            var dt = dist.Form.Fields.DatatableUtils.getInstance(event.currentTarget);
            var data = form.serializeArray();


            for (var i in data) {
                if (data[i].name != '_token') {
                   var that =  $('[name="' + data[i].name + '"]');
                    that.val('');

                    var select2 = $(that).data('select2');
                    if(select2){
                        $(that).select2("val", "");
                    }

                }
            }

            jQuery('.tools a',jQuery(event.currentTarget).parents('.portlet')).click();

            dt.fnDraw();
            return false;
        });


        $(selector_submit).off('click').on('click', function (event) {
            event.preventDefault();
            var dt = dist.Form.Fields.DatatableUtils.getInstance(event.currentTarget);
            dt.fnDraw();
            jQuery('.tools a',jQuery(event.currentTarget).parents('.portlet')).click();
            return false;
        });

    }

};