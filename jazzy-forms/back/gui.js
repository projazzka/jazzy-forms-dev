(function($) {
    var elements;
    var sorted_forms;
    var current_form = null;
    
    function init() {
        sorted_forms = [];
        for(var key in jzzf_forms) {
            sorted_forms.push(jzzf_forms[key]);
        }
        sorted_forms.sort(function(a,b) { return a.key < b.key ? -1 : 1 });
    }

    function new_element(type) {
        var elements = get_form_elements();
        var id_helper = new jzzf_id(elements);
        var title = id_helper.suggest_title('Element');
        var name = id_helper.suggest_name(title);
        return obj = {'title': title, 'name': name, 'type': type};
    }
    
    function add_new_element(type) {
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
    
    function bind_events() {
        function get_cb_wrapper(cb) {
            return function() {
                cb();
                return false;
            };
        }
        
        handlers = {
            '#jzzf_elements_toolbox_number': function() { add_new_element('number'); },
            '#jzzf_selector_new': new_form,
            '#jzzf_selector_delete': delete_form,
            '#jzzf_new_form_add': add_form,
            '#jzzf_new_form_cancel': cancel_form
        };
        for(var id in handlers) {
            $(id).click(get_cb_wrapper(handlers[id]));
        }
        
        $('#jzzf_selector').change(function() {
            bind_form_data(jzzf_forms[$('#jzzf_selector').val()]);
        });
        
        $('#jzzf_form_save').click(save);
        
    }
    
    function bind_data() {
        if(current_form==null) {
            $('#jzzf_form').hide();
        } else {
            bind_form_data()
        }
    }
    
    function bind_form_data(form) {
        $('#jzzf_form').show();
        $('#jzzf_elements_list').html('');
        for(var i=0; i<elements.length; i++) {
            var element = jzzf_element.create(elements[i].type)
            element.add(elements[i], i);
        }
    }
    
    function get_form_elements() {
        var elements = [];
        $('#jzzf_elements_list > li').each(function(idx) {
            elements.push(jzzf_element.data_from_li($(this)));
        });
        return elements;
    }
    
    function get_form_data() {
        return {
            "elements": get_form_elements()
        };
    }
    
    function save() {
        var form = get_form_data();
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
        current_form = idx;
        elements = jzzf_forms[idx].elements;
        bind_form_data(jzzf_forms[idx]);
    }
    
    function cancel_form() {
        $('#jzzf_new_form_title, #jzzf_new_form_name').val('');
        $('#jzzf_new_form').hide();
        $('#jzzf_selection').show();
    }
    
    function new_form() {
        $('#jzzf_selection').hide();
        $('#jzzf_new_form').show();
    }
    
    $(function() {
        init();
        if(jzzf_forms.length == 0) {
            new_form();
        } else {
            set_current_form(0);
        }
        bind_events();
        bind_data();
    });
})(jQuery);