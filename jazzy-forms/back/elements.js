function jzzf_element($) {
    
    this.counter = function() {
        if ( typeof jzzf_element.incremental == 'undefined' ) {
                jzzf_element.incremental = 0;
        }
        jzzf_element.incremental++;        
    }
    
    this.add = function(element, idx) {
        $('#jzzf_elements_list li').addClass('jzzf_collapsed');
        element.id = this.counter();
        var html = Mustache.to_html($('#jzzf_tmpl_' + element.type).html(), element);
        if(idx==0) {
            $('#jzzf_elements_list').prepend(html);
        } else {
            $('#jzzf_elements_list > li').eq(idx-1).after(html);
        }
        this.bind(idx);
    }
    
    this.bind = function(idx) {
        var element = $('#jzzf_elements_list > li:eq(' + idx + ')');
        $(element).find('.jzzf_element_header').click(function() {
            $(this).parent().toggleClass('jzzf_collapsed');
        });
    }    
}

jzzf_element.create = function(type) {
    return new jzzf_element(jQuery);
}
