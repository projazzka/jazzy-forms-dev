function jzzf_smartid(id_helper) {
    var $ = jQuery;

    var handle_source_change = function() {
        var smarttitle = $(this);
        var smartid = $('.jzzf_smartid');
        if(smartid.hasClass('jzzf_smartid_clean')) {
            var name = id_helper.suggest_name(smarttitle.val());
            smartid.val(name);
            smartid.trigger("jzzf_smartid_change");
        }
        return true;
    }

    this.bind = function() {
        $('.jzzf_smartid').bind('change keyup', function() {
            var elem = $(this);
            if(elem.hasClass('jzzf_smartid_clean')) {
                elem.removeClass('jzzf_smartid_clean');
            }
            return true;
        });
        
        $('.jzzf_smartid_source').bind("keyup change", handle_source_change);
    }

    this.init = function() {
        $('.jzzf_smartid_source').each(handle_source_change);
    }
}


