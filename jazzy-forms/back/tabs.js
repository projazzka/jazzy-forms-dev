(function($) {
    $(function() {
        select('elements');
        bind();
    });

    function select(name) {
        $('#jzzf_tabs li').removeClass('jzzf_current_tab');
        $('.jzzf_section').hide();
        $('#jzzf_tab_' + name).addClass('jzzf_current_tab');
        $('#jzzf_section_' + name).show();
    }
    

    function factory(name) {
        return function() {
            select(name);
        }
    }
    
    function bind() {
        var tabs = ['elements', 'buttons', 'general'];
        for(var i=0; i<tabs.length; i++) {
            $('#jzzf_tab_' + tabs[i]).click(factory(tabs[i]));
        }
    }
})(jQuery);
