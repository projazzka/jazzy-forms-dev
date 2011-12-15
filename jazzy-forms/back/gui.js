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
    
    function name_occupied(name) {
        for(var i=0; i<elements.length; i++) {
            if(elements[i].name == name) {
                return true;
            }
        }
        return false;
    }
    
    function suggest_name_index() {
        var i=0;
        var name;
        do {
            i++;
        } while(name_occupied('element-' + i));
        return i;
    }
    
    function new_element() {
        var i = suggest_name_index();
        return obj = {'title': 'Element ' + i, 'name': 'element-' + i};
    }
    
    function add_new_element(type) {
        var obj = new_element();
        add_element(obj);
        elements.push(obj);
    }
    
    function add_element(element) {
        $('#jzzf_elements_list').append(
            Mustache.to_html($('#jzzf_tmpl_' + element.type).html(), element)
        );
    }
    
    function initial_visibility() {
        $('#jzzf_new_form,.jzzf_section').hide();
        select_tab('elements');
    }
    
    function select_tab(name) {
        $('#jzzf_tabs li').removeClass('jzzf_current_tab');
        $('.jzzf_section').hide();
        $('#jzzf_tab_' + name).addClass('jzzf_current_tab');
        $('#jzzf_section_' + name).show();
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
        
        bind_tab_switching_events();
    }
    
    function tab_switching_cb(name) {
        return function() {
            select_tab(name);
        }
    }
    
    function bind_tab_switching_events() {
        var tabs = ['elements', 'buttons', 'general'];
        for(var i=0; i<tabs.length; i++) {
            $('#jzzf_tab_' + tabs[i]).click(tab_switching_cb(tabs[i]));
        }
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
            add_element(elements[i]);
        }
    }
    
    function add_form() {
        // @todo
    }
    
    function set_current_form(idx) {
        current_form = idx;
        elements = jzzf_forms[idx].elements;
        //bind_form_data(jzzf_forms[idx]);
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
        initial_visibility();
        bind_events();
        bind_data();
    });
})(jQuery);