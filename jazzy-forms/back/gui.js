(function($) {
    var elements;
    
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
    
    function add_element(type, element) {
        var obj = new_element();
        $('#jzzf_elements_list').append(
            Mustache.to_html($('#jzzf_tmpl_' + type).html(), obj)
        );
        elements.push(obj);
    }
    
    $(function() {
        elements = [];
        add_element('number');
        add_element('number');
        add_element('number');
    });
})(jQuery);