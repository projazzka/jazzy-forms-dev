(function($) {
    var form = null;
    
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
        gui.add(obj, remove ? item : null);
    }

    function delete_form() {
        if(form==null) {
            return false;
        }
        $('#jzzf_delete').val(form.id);
        $('#jzzf_delete_form').submit();
        return false;
    }
    
    function bind() {     
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
            set_current_form($('#jzzf_selector').val());
        });
        
        $('#jzzf_form_save').click(save);
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
        var form = get_form();
        var serialized = JSON.stringify(form);
        $('#jzzf_form_data').val(serialized);
        $('#jzzf_form_form').submit();
    }
    
    function add_form() {
        var title = $('#jzzf_new_form_title').val();
        var id_helper = new jzzf_id(jzzf_forms);
        var name = id_helper.suggest_name(title);
        form = {'title': title, 'name': name, 'elements': []};
        elements = [];
        $('#jzzf_form').show();
        var option = $('<option>');
        option.text(title);
        $('#jzzf_selector').append(option).children('option:last').attr('selected', 'selected');
        set_form(form);
    }
    
    function set_current_form(idx) {
        form = jzzf_forms[idx];
        set_form(form);
    }
    
    function cancel_form() {
        $('#jzzf_new_form_title, #jzzf_new_form_name').val('');
        $('#jzzf_new_form').hide();
        $('#jzzf_selection').show();
    }
    
    function new_form() {
        form = null;
        set_form(form);
    }
    
    $(function() {
        if(jzzf_forms.length == 0) {
            new_form();
        } else {
            set_current_form(0);
        }
        bind();
    });
})(jQuery);