<script>
jzzf_forms = <?php echo json_encode($forms) ?>;
</script>
<h2>Jazzy Forms</h2>
<div id="jzzf_selector">
    <select id="jzzf_selector"></select>
    <a id="jzzf_selector_new" href="">New</a><a id="jzzf_selector_delete" href="">Delete</a>
    <div id="jzzf_new_form">
        <h3>New Form</h3>
        <label for="jzzf_new_form_title">Title</label><input type="text" id="jzzf_new_form_title" name="jzzf_new_form_title" value="New Form">
        <input id="jzzf_new_form_add" type="button" value="Add"><a href="" id="jzzf_new_form_cancel">Cancel</a>
    </div>
</div>
<div id="jzzf_form">
    <ul id="jzzf_tabs">
        <li id="jzzf_tab_elements">Elements</li>
        <li id="jzzf_tab_buttons">Buttons</li>
        <li id="jzzf_tab_general">General</li>
    </ul>
    <div id="jzzf_main">
        <div id="jzzf_section_elements">
            Elements section (to be implemented)

        </div>
        <div id="jzzf_section_buttons">
            Buttons section (to be implemented)

        </div>
        <div id="jzzf_section_general">           
            General section (to be implemented)
        </div>
    </div>
    <input id="jzzf_form_save" type="button" value="Save"><a href="" id="jzzf_form_cancel">Discard changes</a>
</div>

