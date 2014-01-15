function jzzf_element($, id_helper, deletion_listener, name_update_listener) {
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
        data.visible_always = (data.visible == 1);
        data.visible_never = (data.visible == 0);
        data.zeros_options = [];
        data.decimals_options = [];
        for(var i=0; i<=9; i++) {
            data.zeros_options.push({"value": i, "selected": (data.zeros == i)});
            data.decimals_options.push({"value": i, "selected": (data.decimals == i)});
        }
        for(var i=1; i<=4; i++) {
            data['divisions_' + i] = (data.divisions == i);
        }
        var separators = { "none": "", "comma": ",", "space": " ", "point": "." };
        for(var key in separators) {
            data['thousands_' + key] = (data.thousands === separators[key]);
            data['point_' + key] = (data.point == separators[key]);
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
        var self = this;
        element.find('.jzzf_element_header').click(function() {
            $(this).parent().toggleClass('jzzf_collapsed');
        });
        element.find('.jzzf_element_delete').click(function() {
            if(confirm("Are you sure to delete this element?")) {
                $(this).parentsUntil('#jzzf_elements_list').remove();
            }
            deletion_listener();
        });
        element.find('.jzzf_option_add').click(function() {
            var counter = $(this).closest('.jzzf_element').find('.jzzf_element_counter').val();
            var data = {"title":"Option"}
            var option_table = $(this).parent().find('.jzzf_option_table tbody')
            if(option_table.find('.jzzf_option').length == 0) {
                data.default = true;
            }
            option_table.append(self.html_option(data, counter));
            return false;
        });
        element.find('.jzzf_element_title').change(function() {
           element.find('.jzzf_header_title').text(self.display_title($(this).val())); 
        });
        element.find('.jzzf_option_table tbody').sortable();
        element.delegate('.jzzf_option_delete', 'click', self.delete_option);
        var smartid_element = element.find('.jzzf_element_name, .jzzf_element_title');
        smartid_element.bind('blur', null, name_update_listener);
        var smartid = new jzzf_smartid(id_helper, element);
        smartid.bind();
        smartid.init();
    }

    this.delete_option = function() {
        var row = $(this).parentsUntil('table', 'tr');
        var was_checked = row.find('.jzzf_option_default').is(':checked');
            
        if(confirm("Are you sure to delete this option?")) {
            if(was_checked) {
                var table = row.parentsUntil('table');
                table.find('.jzzf_option_default').first().attr('checked','checked');                    
            }
            row.remove();
        }
        return false;
    }
    
    this.data = function(li) {
        var result = {};
        var simple = [
            'id',
            'type',
            'title',
            'name',
            'value',
            'value2',
            'visible',
            'prefix',
            'postfix',
            'zeros',
            'decimals',
            'fixed',
            'formula',
            'thousands',
            'point',
            'classes',
            'divisions',
            'missing'
        ];
        var checkboxes = [
            'fixed',
            'break',
            'required'
        ];

        var type = li.find('.jzzf_element_type').val();
        if(type == 'c') {
            result.default = li.find('.jzzf_element_checked').is(':checked') ? "1" : "0";
        } else {
            simple.push('default');
        }

        switch(type) {
            case 'd':
            case 'r':
                result.options = this.options_data(li);
                break;
        };

        for(var i=0; i<simple.length; i++) {
            result[simple[i]] = li.find('.jzzf_element_' + simple[i]).val();
        }
        for(var i=0; i<checkboxes.length; i++) {
            result[checkboxes[i]] = li.find('.jzzf_element_' + checkboxes[i]).is(':checked');
        }
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

jzzf_element.create = function(type, id_helper, deletion_listener, name_update_listener) {
    return new jzzf_element(jQuery, id_helper, deletion_listener, name_update_listener);
}

jzzf_element.data_from_li = function(li) {
    var type = li.find('.jzzf_element_type').val();
    var gui = jzzf_element.create(type);
    if(gui) {
        return gui.data(li);
    }
    return null;
}

jzzf_element.reset_ids = function(element) {
    element.id = 0;
    if(element.options) {
        for(var j=0; j<element.options.length; j++) {
            element.options[j].id = 0;
        }
    }
}
