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
        var html = this.html(element);
        if(idx==0) {
            $('#jzzf_elements_list').prepend(html);
        } else {
            $('#jzzf_elements_list > li').eq(idx-1).after(html);
        }
        this.bind(idx);
    }
    
    this.html = function(element) {
        return Mustache.to_html($('#jzzf_tmpl_common').html(), element, {'extra': this.extra(element)});
    }
    
    this.extra = function(element) {
        return $('#jzzf_tmpl_' + element.type).html()
    }
    
    this.bind = function(idx) {
        var element = jzzf_element.from_index(idx);
        $(element).find('.jzzf_element_header').click(function() {
            $(this).parent().toggleClass('jzzf_collapsed');
        });
    }
    
    this.data = function(li) {
        var result = {
            "title": li.find('.jzzf_element_title').val(),
            "name": li.find('.jzzf_element_name').val()
        };
        switch(li.find('.jzzf_element_type').val()) {
            case 'number':
                result.value = li.find('.jzzf_element_value').val();
                break;
        };
        return result;
    }
}

jzzf_element.from_index = function(idx) {
    return jQuery('#jzzf_elements_list > li:eq(' + idx + ')');
}

jzzf_element.create = function(type) {
    return new jzzf_element(jQuery);
}

jzzf_element.data_from_li = function(li) {
    var type = li.find('.jzzf_element_type').val();
    var gui = jzzf_element.create(type);
    if(gui) {
        return gui.data(li);
    }
    return null;
}
