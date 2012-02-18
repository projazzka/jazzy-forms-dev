function jzzf_element($) {
    var partials = {};
    
    this.counter = function() {
        if(jzzf_element.incremental == undefined) {
            jzzf_element.incremental = 0;
        }
        return ++jzzf_element.incremental;
    }
    
    this.add = function(element, placeholder, collapsed) {
        var html = this.html_element(element.type, element);
        var li;
        if(placeholder) {
            li = $(html);
            placeholder.replaceWith(li);
        } else {
            li = $(html);
            $('#jzzf_elements_list').append(li);
        }
        if(collapsed === undefined || collapsed) {
            li.addClass('jzzf_collapsed');
        }
        this.bind(li);
    }
        
    this.html_element = function(tmpl_name, data) {
        var counter = this.counter();
        data.counter = counter;
        data.display_title = this.display_title(data.title);
        data.typeString = $('.jzzf_elements_toolbox_items li[jzzf_type="' + data.type + '"]').text();
        if(data.options) {
            $.each(data.options, function(idx) {
                data.options[idx].counter = counter;
            });
            if(data.type == 'c') {
                data.checked = (data.default == "1");
            }
        }
        return this.html(tmpl_name, data);
    }

    this.html_option = function(data, counter) {
        data.counter = counter;
        return this.html('option', data);
    }
    
    this.html = function(tmpl_name, data) {
        return Mustache.to_html($('#jzzf_tmpl_' + tmpl_name).html(), data, partials)    
    }
    
    this.init_partials = function() {
        $('[id^="jzzf_tmpl_"]').each(function() {
            var tmpl = $(this).html();
            var id = $(this).attr('id').replace('jzzf_tmpl_', '');
            partials[id] = tmpl;
        });
    }
    
    this.bind = function(li) {
        var element = li;
        element.find('.jzzf_element_header').click(function() {
            $(this).parent().toggleClass('jzzf_collapsed');
        });
        element.find('.jzzf_element_delete').click(function() {
            if(confirm("Are you sure to delete this element?")) {
                $(this).parentsUntil('#jzzf_elements_list').remove();
            }
        });
        var self = this;
        element.find('.jzzf_option_add').click(function() {
            var counter = $(this).parentsUntil('.jzzf_elements_list').find('.jzzf_element_counter').val();
            $(this).parent().find('.jzzf_option_table tbody').append(self.html_option({}, counter));
            self.bind_options();
            return false;
        });
        element.find('.jzzf_element_title').change(function() {
           element.find('.jzzf_header_title').text(self.display_title($(this).val())); 
        });
        element.find('.jzzf_option_table tbody').sortable();
        this.bind_options();
    }

    this.bind_options = function() {
        $('.jzzf_option_delete').unbind('click').click(function() {
            if(confirm("Are you sure to delete this option?")) {
                $(this).parentsUntil('table', 'tr').remove();
            }
            return false;
        });
    }
    
    this.data = function(li) {
        var result = {
            "id": li.find('.jzzf_element_id').val(),
            "type": li.find('.jzzf_element_type').val(),
            "title": li.find('.jzzf_element_title').val(),
            "name": li.find('.jzzf_element_name').val(),
            "value": li.find('.jzzf_element_value').val(),
            "default": li.find('.jzzf_element_default').val()
        };
        switch(li.find('.jzzf_element_type').val()) {
            case 'n':
                result.value = li.find('.jzzf_element_value').val();
                break;
            case 'c':
                result.value = li.find('.jzzf_element_value').val();
                result.value2 = li.find('.jzzf_element_value2').val();
                result.default = li.find('.jzzf_element_checked').is(':checked') ? "1" : "0";
            case 'r':
            case 'd':
                result.options = this.options_data(li);
                break;
            case 'f':
                result.formula = li.find('.jzzf_element_formula').val();
                break;
        };
        return result;
    }
    
    this.display_title = function(title) {
        if(title.length >= 50) {
            return title.substring(0, 47) + '...';
        } else {
            return title;
        }
    }
    
    this.options_data = function(li) {
        var options = [];
        var idx = 0;
        li.find('.jzzf_option').each(function(idx) {
            options.push({
                'id': $(this).find('.jzzf_option_id').val(),
                'order': idx++,
                'title': $(this).find('.jzzf_option_title').val(),
                'value': $(this).find('.jzzf_option_value').val(),
                'default': $(this).find('.jzzf_option_default').is(':checked')
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
