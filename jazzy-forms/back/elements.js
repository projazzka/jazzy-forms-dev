function jzzf_element($) {
    var partials = {};
    
    this.counter = function() {
        if(jzzf_element.incremental == undefined) {
            jzzf_element.incremental = 0;
        }
        return ++jzzf_element.incremental;
    }
    
    this.add = function(element, idx) {
        $('#jzzf_elements_list li').addClass('jzzf_collapsed');
        element.counter = this.counter();
        var html = this.html(element.type, element);
        if(idx==0) {
            $('#jzzf_elements_list').prepend(html);
        } else {
            $('#jzzf_elements_list > li').eq(idx-1).after(html);
        }
        this.bind(idx);
    }
    
    this.html = function(tmpl_name, data) {
        return Mustache.to_html($('#jzzf_tmpl_' + tmpl_name).html(), data, partials);
    }
    
    this.init_partials = function() {
        $('[id^="jzzf_tmpl_"]').each(function() {
            var tmpl = $(this).html();
            var id = $(this).attr('id').replace('jzzf_tmpl_', '');
            partials[id] = tmpl;
        });
    }
    
    this.bind = function(idx) {
        var element = jzzf_element.from_index(idx);
        element.find('.jzzf_element_header').click(function() {
            $(this).parent().toggleClass('jzzf_collapsed');
        });
        element.find('.jzzf_element_delete').click(function() {
            $(this).parentsUntil('#jzzf_elements_list').remove();
        });
        var self = this;
        element.find('.jzzf_option_add').click(function() {
            $(this).parent().find('.jzzf_option_table').append(self.html('option', {}));
            self.bind_options();
            return false;
        });
        this.bind_options();
    }

    this.bind_options = function() {
        $('.jzzf_option_delete').click(function() {
            $(this).parentsUntil('table', 'tr').remove();
            return false;
        });
    }
    
    this.data = function(li) {
        var result = {
            "id": li.find('.jzzf_element_id').val(),
            "type": li.find('.jzzf_element_type').val(),
            "title": li.find('.jzzf_element_title').val(),
            "name": li.find('.jzzf_element_name').val()
        };
        switch(li.find('.jzzf_element_type').val()) {
            case 'number':
                result.value = li.find('.jzzf_element_value').val();
                break;
            case 'radio':
            case 'dropdown':
                result.options = this.options_data(li);
                break;
        };
        return result;
    }
    
    this.options_data = function(li) {
        var options = [];
        var idx = 0;
        li.find('.jzzf_option').each(function(idx) {
            options.push({
                'id': $(this).find('.jzzf_option_id').val(),
                'order': idx++,
                'title': $(this).find('.jzzf_option_title').val(),
                'value': $(this).find('.jzzf_option_value').val()
            });
        });
        return options;
    }
    
    this.init_partials();
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
