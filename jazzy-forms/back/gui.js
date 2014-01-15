(function($) {
    var form = null;
    var form_index = 0;
    var dirty = false;
    var text_unload = "The current form has unsaved changes.";
    var text_dirty = text_unload + "\nAre you sure you want to discard them?";
    
    var email_fields = ['to', 'from', 'cc', 'bcc', 'subject', 'message', 'sending', 'ok', 'fail'];

    var form_id_helper = null;
    var form_smartid_helper = null;
    
    var element_names = [];
    var element_id_helper = new jzzf_id(element_names);

    function new_element(type) {
        var elements = get_elements(); // need existing elements to suggest a valid name/title
        var id_helper = new jzzf_id(elements);
        var title = id_helper.suggest_title('Element');
        var name = '';
        var obj = {
            'title': title,
            'name': '',
            'type': type,
            'decimals': 9,
            'point': '.',
            'visible': 1,
            'divisions': 1,
            'break': 1
        };
        if(type == 'r' || type == 'd') {
            obj.options = [{'title': 'Option', 'default': true}];
        }
        return obj;
    }
    
    function add_element(item, remove) {
        var type = item.attr('jzzf_type');
        var obj = new_element(type);
        var gui = jzzf_element.create(type, element_id_helper, adjust_email_tab, update_element_names);
        gui.add(obj, remove ? item : null, false);
        update_element_names();
        adjust_email_tab();
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
        
        $('#jzzf_elements_list').delegate('.jzzf_toggler', 'click', function() {
            $(this).parent().toggleClass('jzzf_div_collapsed');
        });
        
        $('.jzzf_elements_toolbox_items li').click(function() {
            add_element($(this), false);
            return false;
        });
        
        $('#jzzf_elements_list').delegate('.jzzf_element_clone', 'click', function() {
            var li = $(this).closest('li');
            var element = new jzzf_element($, element_id_helper, adjust_email_tab, update_element_names);
            var placeholder = $('<div class="jzzf_element"></div>');
            li.after(placeholder);
            var data = element.data(li);
            var elements = get_elements();
            var id_helper = new jzzf_id(elements);
            var title = id_helper.suggest_title(data.title);
            var name = id_helper.suggest_name(title);
            data.title = title;
            data.name = '';//name;
            jzzf_element.reset_ids(data);
            element.add(data, placeholder, false);
            return false;
        });
        
        $('#jzzf_elements_list').sortable({
            update: function(event, ui) {
                add_element(ui.item, true);
            }
        });
        $('.jzzf_elements_toolbox_items li').draggable({
            connectToSortable: "#jzzf_elements_list",
            helper: "clone",
            revert: "invalid",
            cursor: "move"
        });

        $('#jzzf_selector_new').click(function() { new_form(); return false; });
        $('#jzzf_selector_delete').click(function() { delete_form(); return false; });
        $('#jzzf_selector_clone').click(function() { set_cloned_form(); return false; });
        $('#jzzf_form_cancel').click(function() { form_cancel(); return false; });
                                              
        $('#jzzf_selector').change(function() {
            if(warn_dirty()) {
                set_current_form($('#jzzf_selector').val());
                return true;
            } else {
                reset_current_form();
                return false;
            }
        });
        
        $('#jzzf_form *, #jzzf_selection *').delegate('*', 'click change sortupdate', function(event) {
            $('#message').hide();
        });
        
        $('#jzzf_name').bind('keyup change jzzf_smartid_change', update_shortcode);
        $('#jzzf_form_save').click(save);
        
        $('#jzzf_new_form_title').bind('change keyup', function() {
            $('#jzzf_title').val($('#jzzf_new_form_title').val());
            $('#jzzf_title').trigger('jzzf_smartid_change');
            return false;
        });
        $('#jzzf_title').bind('change keyup', function() {
            $('#jzzf_new_form_title').val($('#jzzf_title').val());
            return false;
        });

        form_smartid_helper.bind();
        
    }
    
    function update_shortcode() {
        $('#jzzf_shortcode').val('[jazzy form="' + $('#jzzf_name').val() + '"]');
    }
    
    function set_email(email) {
        if(!email) {
            email = {"to": "", "from": "", "cc": "", "bcc": "", "subject": "", "message": ""};
        }
        for(var idx = 0; idx<email_fields.length; idx++) {
            $('#jzzf_email_' + email_fields[idx]).val(email[email_fields[idx]]);
        }
    }
    
    function set_form(form) {
        if(form.theme == 1) {
            $('#jzzf_default_css').attr('checked', 'checked');
        } else {
            $('#jzzf_default_css').removeAttr('checked');
        }
        $('#jzzf_incomplete').val(form.incomplete);
        $('#jzzf_css').val(form.css);
        $('#jzzf_id').val(form.id);
        $('#jzzf_title').val(form.title);
        $('#jzzf_new_form_title').val(form.title);
        $('#jzzf_name').val(form.name);
        $('#jzzf_elements_list').html('');
        if(form.realtime == 1) {
            $('#jzzf_realtime').attr('checked', 'checked');
        } else {
            $('#jzzf_realtime').removeAttr('checked');
        }
        for(var i=0; i<form.elements.length; i++) {
            var element = jzzf_element.create(form.elements[i].type, element_id_helper, adjust_email_tab, update_element_names);
            element.add(form.elements[i], null);
        }
        adjust_email_tab(form.elements);
        set_email(form.email);
        update_shortcode();
        mark_clean();

        form_smartid_helper.init();
    }
    
    function form_cancel() {
        location.reload();    
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
    
    function has_email(elements) {
        if(elements == null) {
            elements = get_elements();
        }
        for(var i=0; i<elements.length; i++) {
            if(elements[i].type == 'e') {
                return true;
            }
        }
        return false;
    }
    
    function get_email() {
        var result = {};
        for(var idx=0; idx<email_fields.length; idx++) {
            result[email_fields[idx]] = $('#jzzf_email_' + email_fields[idx]).val();
        };
        return result;
    }
    
    function get_form() {
        var elements = get_elements();
        var form = {
            "id": $('#jzzf_id').val(),
            "title": $('#jzzf_title').val(),
            "name": $('#jzzf_name').val(),
            "theme": $('#jzzf_default_css').is(':checked'),
            "realtime": $('#jzzf_realtime').is(':checked'),
            "css": $('#jzzf_css').val(),
            "incomplete": $('#jzzf_incomplete').val(),
            "elements": elements
        };
        if(has_email(elements)) {
            form.email = get_email();
        } else {
            form.email = null;
        }
        return form;
    }
    
    function save() {
        window.onbeforeunload = null;
        var form = get_form();
        var serialized = JSON.stringify(form);
        $('#jzzf_form_data').val(serialized);
        $('#jzzf_form_form').submit();
    }
    
    function default_email_parameters() {
        return {
            'sending': 'Sending...',
            'ok': "Message sent",
            'fail': "Can't send the message"
        };
    }
    
    function add_form() {
        switch_head(true);

        var id_helper = new jzzf_id(jzzf_forms);
        var title = id_helper.suggest_title('New Form');
        var name = id_helper.suggest_name(title);
        form = {
            'title': title,
            'name': '',
            'elements': [],
            'theme': 1,
            'realtime': true,
            'email': default_email_parameters()
        };
        elements = [];
        set_form(form);
    }

    function reset_current_form() {
        $('#jzzf_selector option:eq(' + form_index + ')').attr('selected', 'selected');
    }
    
    function set_current_form(idx) {
        if(idx === undefined) {
            idx = $('#jzzf_selector option:selected').index();
        }
        switch_head(false);
        mark_clean();
        form = jzzf_forms[idx];
        form_index = idx;
        if(!form.email) {
            form.email = default_email_parameters();
        }
        set_form(form);
    }
    
    function new_form() {
        $('#message').hide();
        if(warn_dirty()) {
            form = null;
            add_form(form);            
        }
    }
    
    function set_cloned_form() {
        mark_dirty();
        var new_form = clone_form(form);
        reset_ids(new_form);
        set_form(new_form);

        switch_head(true);
        $('#message').hide();
    }

    function switch_head(show_new_form) {
        if(show_new_form) {
            $('#jzzf_selection').hide();
            $('#jzzf_new_form').show();
        } else {
            $('#jzzf_selection').show();
            $('#jzzf_new_form').hide();            
        }
    }
    
    function reset_ids(form) {
        form.id = 0;
        for(var i=0; i<form.elements.length; i++) {
            jzzf_element.reset_ids(form.elements[i]);
        }
        if(form.email) {
            form.email.id = 0;
        }
        form.name = '';
    }
    
    function clone_form(form) {
        var new_form = jQuery.extend(true, {}, form);
        var helper = new jzzf_id(jzzf_forms)
        new_form.title = helper.suggest_title(new_form.title)
        return new_form;
    }
    
    function update_element_names() {
        element_names.length = 0;
        $('.jzzf_element_name').each(function() {
            element_names.push({"name":$(this).val()});
        });
    }
    
    function adjust_email_tab(elements) {
        var email = has_email(elements);
        $('#jzzf_section_email').toggleClass('jzzf_enabled', email).toggleClass('jzzf_disabled', !email);
    }
    
    $(function() {
        form_id_helper = new jzzf_id(jzzf_forms);
        form_smartid_helper = new jzzf_smartid(form_id_helper, $('#jzzf_section_general'));

        if(jzzf_forms.length == 0) {
            new_form();
        } else {
            set_current_form();
        }
        bind();
    });
})(jQuery);
