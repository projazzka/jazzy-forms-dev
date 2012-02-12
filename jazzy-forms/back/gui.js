(function($) {
    var form = null;
    var form_index = 0;
    var dirty = false;
    var text_unload = "The current form has unsaved changes.";
    var text_dirty = text_unload + "\nAre you sure you want to discard them?";
    
    function new_element(type) {
        var elements = get_elements(); // need existing elements to suggest a valid name/title
        var id_helper = new jzzf_id(elements);
        var title = id_helper.suggest_title('Element');
        var name = id_helper.suggest_name(title);
        return obj = {'title': title, 'name': name, 'type': type};
    }
    
    function add_element(item, remove) {
        var type = item.attr('jzzf_type');
        var obj = new_element(type);
        var gui = jzzf_element.create(type);
        gui.add(obj, remove ? item : null, false);
    }

    function delete_form() {
        if(form==null) {
            return false;
        }
        if(confirm("Are you sure to delete the selected form?")) {
            $('#jzzf_delete').val(form.id);
            $('#jzzf_delete_form').submit();
        }
        return false;
    }
    
    function warn_unload() {
        return dirty ? text_unload : null;
    }
    
    function warn_dirty() {
        if(dirty) {
            return confirm(text_dirty);
        } else {
            return true;
        }
    }
    
    function mark_dirty() {
        if(!dirty) {
            dirty = true;
            window.onbeforeunload = warn_unload;
        }
        return true;
    }
    
    function mark_clean() {
        if(dirty) {
            dirty = false;
            window.onbeforeunload = null;
        }
        return true;
    }
    
    function bind() {
        $('#jzzf_main').delegate('input', 'change', mark_dirty);
        
        $('#jzzf_elements_toolbox_items li').click(function() {
            add_element($(this), false);
            return false;
        });
        
        $('#jzzf_elements_list').sortable({
            update: function(event, ui) {
                add_element(ui.item, true);
            }
        });
        $('#jzzf_elements_toolbox_items li').draggable({
            connectToSortable: "#jzzf_elements_list",
            helper: "clone",
            revert: "invalid"
        });

        $('#jzzf_selector_new').click(function() { new_form(); return false; });
        $('#jzzf_selector_delete').click(function() { delete_form(); return false; });
        $('#jzzf_new_form_add').click(function() { add_form(); return false; });
        $('#jzzf_new_form_cancel').click(function() { cancel_form(); return false; });
                                              
        $('#jzzf_selector').change(function() {
            if(warn_dirty()) {
                set_current_form($('#jzzf_selector').val());
                return true;
            } else {
                reset_current_form();
                return false;
            }
        });
        
        $('#jzzf_form *').delegate('*', 'click change sortupdate', function(event) {
            $('#message').hide();
        });
        
        $('#jzzf_name').change(update_shortcode);
        $('#jzzf_form_save').click(save);
    }
    
    function update_shortcode() {
        $('#jzzf_shortcode').val('[jazzy form="' + $('#jzzf_name').val() + '"]');
    }
    function set_form(form) {
        if(form==null) {
            $('#jzzf_form,#jzzf_selection').hide();
            $('#jzzf_new_form').show();
        } else {
            $('#jzzf_new_form').hide();
            $('#jzzf_form,#jzzf_selection').show();

            if(form.theme == 1) {
                $('#jzzf_default_css').attr('checked', 'checked');
            } else {
                $('#jzzf_default_css').removeAttr('checked');
            }
            $('#jzzf_css').val(form.css);
            $('#jzzf_id').val(form.id);
            $('#jzzf_title').val(form.title);
            $('#jzzf_name').val(form.name);
            $('#jzzf_elements_list').html('');
            for(var i=0; i<form.elements.length; i++) {
                var element = jzzf_element.create(form.elements[i].type)
                element.add(form.elements[i], null);
            }
        }
        update_shortcode();
    }
    
    function get_elements() {
        var elements = [];
        var idx = 0;
        $('#jzzf_elements_list > li').each(function(idx) {
            var element = jzzf_element.data_from_li($(this));
            element.order = idx++;
            elements.push(element);
        });
        return elements;
    }
    
    function get_form() {
        return {
            "id": $('#jzzf_id').val(),
            "title": $('#jzzf_title').val(),
            "name": $('#jzzf_name').val(),
            "theme": $('#jzzf_default_css').is(':checked'),
            "css": $('#jzzf_css').val(),
            "elements": get_elements()
        };
    }
    
    function save() {
        window.onbeforeunload = null;
        var form = get_form();
        var serialized = JSON.stringify(form);
        $('#jzzf_form_data').val(serialized);
        $('#jzzf_form_form').submit();
    }
    
    function add_form() {
        var title = $('#jzzf_new_form_title').val();
        var id_helper = new jzzf_id(jzzf_forms);
        var name = id_helper.suggest_name(title);
        form = {'title': title, 'name': name, 'elements': [], 'theme': 1};
        elements = [];
        $('#jzzf_form').show();
        var option = $('<option>');
        option.text(title);
        $('#jzzf_selector').append(option).children('option:last').attr('selected', 'selected');
        set_form(form);
    }
    
    function reset_current_form() {
        $('#jzzf_selector option:eq(' + form_index + ')').attr('selected', 'selected');
    }
    
    function set_current_form(idx) {
        mark_clean();
        form = jzzf_forms[idx];
        form_index = idx;
        set_form(form);
    }
    
    function cancel_form() {
        $('#jzzf_new_form_title, #jzzf_new_form_name').val('');
        $('#jzzf_new_form').hide();
        $('#jzzf_selection').show();
    }
    
    function new_form() {
        if(warn_dirty()) {
            form = null;
            set_form(form);            
        }
    }
    
    $(function() {
        form_index = $('#jzzf_selector option:selected').index();
        if(jzzf_forms.length == 0) {
            new_form();
        } else {
            set_current_form(form_index);
        }
        bind();
    });
})(jQuery);