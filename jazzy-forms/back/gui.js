(function($) {
    var form = null;
    
    function new_element(type) {
        var elements = get_elements(); // need existing elements to suggest a valid name/title
        var id_helper = new jzzf_id(elements);
        var title = id_helper.suggest_title('Element');
        var name = id_helper.suggest_name(title);
        return obj = {'title': title, 'name': name, 'type': type};
    }
    
    function add_element(type) {
        var obj = new_element(type);
        var idx = $('#jzzf_elements_list > li').length;
        var gui = jzzf_element.create(type);
        gui.add(obj, idx);
    }
            
    function delete_form() {
        if(current_form==null) {
            return;
        }
        // @todo
    }
    
    function bind() {     
        $('#jzzf_elements_toolbox_number').click(function() { add_element('number'); return false; });
        $('#jzzf_elements_toolbox_dropdown').click(function() { add_element('dropdown'); return false; });
        $('#jzzf_elements_toolbox_radio').click(function() { add_element('radio'); return false; });
        $('#jzzf_elements_toolbox_checkbox').click(function() { add_element('checkbox'); return false; });
        $('#jzzf_elements_toolbox_output').click(function() { add_element('output'); return false; });
        $('#jzzf_elements_toolbox_hidden').click(function() { add_element('hidden'); return false; });

        $('#jzzf_selector_new').click(function() { new_form(); return false; });
        $('#jzzf_selector_delete').click(function() { delete_form(); return false; });
        $('#jzzf_selector_add').click(function() { add_form(); return false; });
        $('#jzzf_selector_cancel').click(function() { cancel_form(); return false; });
                                              
        $('#jzzf_selector').change(function() {
            set_current_form($('#jzzf_selector').val());
        });
        
        $('#jzzf_form_save').click(save);
    }
    
    function set_form(form) {
        if(form==null) {
            $('#jzzf_form').hide();
            $('#jzzf_new_form').show();
        } else {
            $('#jzzf_new_form').hide();
            $('#jzzf_form').show();

            $('#jzzf_id').val(form.id);
            $('#jzzf_title').val(form.title);
            $('#jzzf_name').val(form.name);
            $('#jzzf_elements_list').html('');
            for(var i=0; i<form.elements.length; i++) {
                var element = jzzf_element.create(form.elements[i].type)
                element.add(form.elements[i], i);
            }
        }
    }
    
    function get_elements() {
        var elements = [];
        $('#jzzf_elements_list > li').each(function(idx) {
            elements.push(jzzf_element.data_from_li($(this)));
        });
        return elements;
    }
    
    function get_form() {
        return {
            "id": $('#jzzf_id').val(),
            "title": $('#jzzf_title').val(),
            "name": $('#jzzf_name').val(),
            "elements": get_elements()
        };
    }
    
    function save() {
        var form = get_form();
        alert(JSON.stringify(form));
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
        $('#jzzf_selector').append(option);
        $('#jzzf_new_form').hide();
        $('#jzzf_selection').show();
    }
    
    function set_current_form(idx) {
        form = jzzf_forms[idx];
        set_form(form);
    }
    
    function cancel_form() {
        $('#jzzf_new_form_title, #jzzf_new_form_name').val('');
        set_current_for$('#jzzf_new_form').hide();
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