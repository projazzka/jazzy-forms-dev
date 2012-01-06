(function($) {
    $(function() {
        select('elements');
        bind();
    });

    function select(name) {
        $('#jzzf_tabs li').removeClass('jzzf_current_tab');
        $('.jzzf_section').hide();
        $('#jzzf_tabs li[jzzf_section="' + name + '"]').addClass('jzzf_current_tab');
        $('#jzzf_section_' + name).show();
    }
    

    function factory(name) {
        return function() {
            select(name);
        }
    }
    
    function bind() {
        $('#jzzf_tabs li').each(function() {
            $(this).click(factory($(this).attr("jzzf_section")));
        });
    }
})(jQuery);
