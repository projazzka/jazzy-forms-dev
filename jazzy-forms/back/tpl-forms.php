<script id="jzzf_tmpl_common_raw" type="text/html">
<li class="jzzf_element">
    <input type="hidden" value="{{id}}" class="jzzf_element_id">
    <input type="hidden" value="{{counter}}" class="jzzf_element_counter">
    <input type="hidden" class="jzzf_element_type" value="{{type}}">
    <div class="jzzf_element_header">
        <div class="jzzf_type jzzf_type_{{type}}"></div>
        <span class="jzzf_header_title">{{display_title}}</span>
        <a href="#" class="jzzf_element_delete" title="Delete Element"></a>
    </div>
    <div class="jzzf_element_body">
</script>
<script id="jzzf_tmpl_common" type="text/html">
{{>common_raw}}
        <fieldset>
            <ul class="jzzf_element_parameters">
                <li>
                    <label for="jzzf_element_{{counter}}_title">Title</label>
                    <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title" value="{{title}}">
                </li>
                <li>
                    <label for="jzzf_element_{{counter}}_name">ID</label>
                    <input type="text" id="jzzf_element_{{counter}}_name" class="jzzf_element_name" value="{{name}}">
                </li>
            </ul>
        </fieldset>
</script>
<script id="jzzf_tmpl_foot" type="text/html">
    </div>
</li>
</script>
<script id="jzzf_tmpl_n" type="text/html">
{{>common}}
        <fieldset>
            <legend>Value</legend>
            <ul>
                <li>
                    <label for="jzzf_element_{{counter}}_value">Factor</label>
                    <input type="text" id="jzzf_element_{{counter}}_value" class="jzzf_element_value" value="{{value}}">
                </li>
                <li>
                    <label for="jzzf_element_{{id}}_default">Default</label>
                    <input type="text" id="jzzf_element_{{id}}_default" class="jzzf_element_default" value="{{default}}">
                </li>
            </ul>                
        </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_d" type="text/html">
{{>common}}
{{>options}}
{{>foot}}
</script>
<script id="jzzf_tmpl_r" type="text/html">
{{>common}}
{{>options}}
{{>foot}}
</script>
<script id="jzzf_tmpl_c" type="text/html">
{{>common}}
    <fieldset>
        <legend>Values</legend>
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_value">Value for checked</label>
                <input type="text" id="jzzf_element_{{counter}}_value" class="jzzf_element_value" value="{{value}}">
            </li>
            <li>
                <label for="jzzf_element_{{counter}}_value2">Value for unchecked</label>
                <input type="text" id="jzzf_element_{{counter}}_value2" class="jzzf_element_value2" value="{{value2}}">
            </li>
            <li>
                <input type="checkbox" id="jzzf_element_{{counter}}_checked" class="jzzf_element_checked"{{#checked}} checked="checked"{{/checked}}>
                <label for="jzzf_element_{{counter}}_checked">Checked by default</label>
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_f" type="text/html">
{{>common}}
    <fieldset>
        <ul>
            <li>
                <legend>Formula</legend>
                <label for="jzzf_element_{{counter}}_formula">Formula</label>
                <input type="text" id="jzzf_element_{{counter}}_formula" class="jzzf_element_formula" value="{{formula}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_u" type="text/html">
{{>common}}
{{>foot}}
</script>
<script id="jzzf_tmpl_t" type="text/html">
{{>common_raw}}
    <fieldset>
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">Text</label>
                <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title" value="{{title}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_h" type="text/html">
{{>common_raw}}
    <fieldset>
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">Heading</label>
                <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title" value="{{title}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_m" type="text/html">
{{>common_raw}}
    <fieldset>
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">HTML code</label>
                <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title" value="{{title}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>

<script id="jzzf_tmpl_options" type="text/html">
        <fieldset>
            <legend>Options</legend>
            <table class="jzzf_option_table">
            <thead><tr>
                <th class="jzzf_column_drag"></th>
                <th class="jzzf_column_default">Default</th>
                <th class="jzzf_column_title">Title</th>
                <th class="jzzf_column_value">Value</th>
                <th></th>
            </tr></thead>
            <tbody>
            {{#options}}
                {{>option}}
            {{/options}}
            </tbody>
            </table>
            <a href="" class="jzzf_option_add">Add</a>
        </fieldset>
</script>
<script id="jzzf_tmpl_option" type="text/html">
                <tr class="jzzf_option">
                    <td class="jzzf_column_drag jzzf_option_drag">&nbsp;</td>
                    <td class="jzzf_column_default"><input type="radio" name="jzzf_radio_{{counter}}" class="jzzf_option_default" {{#default}}checked="checked"{{/default}}></td>
                    <td class="jzzf_column_title"><input type="hidden" value="{{id}}" class="jzzf_option_id"><input type="text" value="{{title}}" class="jzzf_option_title"></td>
                    <td class="jzzf_column_value"><input type="text" value="{{value}}" class="jzzf_option_value"></td>
                    <td><a href="" class="jzzf_option_delete">(x)</a></td>
                </tr>
</script>
<script type="text/javascript">//<![CDATA[
    var jzzf_forms = <?php echo json_encode($forms) ?>;
//]]></script>
<h2>Jazzy Forms</h2>
<div id="jzzf_selection">
    <form id="jzzf_delete_form" method="post" action="#">
    <label for="jzzf_selector">Form:</label>
    <select id="jzzf_selector">
<?php $i=0; foreach($forms as $form) : ?>
        <option value="<?php echo $i++ ?>"<?php if($form->id == $current) :?> selected="selected"<?php endif ?>><?php echo esc_attr($form->title) ?></option>
<?php endforeach; ?>
    </select>
    <input id="jzzf_delete" name="delete" type="hidden" value="0">
    <a id="jzzf_selector_new" href="">New</a> <a id="jzzf_selector_delete" href="">Delete</a>
    </form>
</div>
<div id="jzzf_new_form">
    <h3>New Form</h3>
    <label for="jzzf_new_form_title">Title</label><input type="text" id="jzzf_new_form_title" name="jzzf_new_form_title" value="New Form">
    <input id="jzzf_new_form_add" type="button" value="Add"><a href="" id="jzzf_new_form_cancel">Cancel</a>
</div>
<div id="message" class="updated" <?php if(!$msg): ?>style="display:none"<?php endif ?>><p><?php esc_html_e($msg) ?></p></div>
<div id="jzzf_form">
    <ul id="jzzf_tabs">
        <li jzzf_section="elements">Elements</li>
        <li jzzf_section="appearance">Appearance</li>
        <li jzzf_section="general" >General</li>
    </ul>
    <div id="jzzf_main">
        <div class="jzzf_section" id="jzzf_section_elements">
            <div class="jzzf_elements_toolbox">
            <div class="jzzf_column_heading" id="jzzf_elements_toolbox_description">Available form elements</div>
                <ul id="jzzf_toolbox_input" class="jzzf_elements_toolbox_items">
                    <li jzzf_type="n"><div class="jzzf_type jzzf_type_n"></div>Number Entry</li>
                    <li jzzf_type="d"><div class="jzzf_type jzzf_type_d"></div>Drop-down Menu</li>
                    <li jzzf_type="r"><div class="jzzf_type jzzf_type_r"></div>Radio Buttons</li>
                    <li jzzf_type="c"><div class="jzzf_type jzzf_type_c"></div>Checkbox</li>
                    <li jzzf_type="f"><div class="jzzf_type jzzf_type_f"></div>Output</li>
                </ul>
                <ul id="jzzf_toolbox_buttons" class="jzzf_elements_toolbox_items">
                    <li jzzf_type="u"><div class="jzzf_type jzzf_type_u"></div>Update Button</li>
                </ul>
                <ul id="jzzf_toolbox_text" class="jzzf_elements_toolbox_items">
                    <li jzzf_type="t"><div class="jzzf_type jzzf_type_t"></div>Text</li>
                    <li jzzf_type="h"><div class="jzzf_type jzzf_type_h"></div>Heading</li>
                    <li jzzf_type="m"><div class="jzzf_type jzzf_type_m"></div>Free HTML</li>
                </ul>
            </div>
            <div id="jzzf_elements_push_for_action">Click or drag to add<br><div class="jzzf_arrow"></div></div>
            <div id="jzzf_elements">
            <div class="jzzf_column_heading">Form elements</div>
                <ul id="jzzf_elements_list">
                </ul>
            </div>
        </div>
        <div class="jzzf_section" id="jzzf_section_appearance">
            <ul>
                <li>
                    <input type="checkbox" id="jzzf_default_css"><label for="jzzf_default_css">Load default theme</label>
                </li>
                <li>
                    <label for="jzzf_css">Custom CSS</label><br>
                    <textarea id="jzzf_css"></textarea>
                </li>
            </ul>
        </div>
        <div class="jzzf_section" id="jzzf_section_general">
            <input type="hidden" id="jzzf_id">
            <ul>
                <li>
                    <label for="jzzf_title">Form Title</label>
                    <input type="text" id="jzzf_title">
                </li>
                <li>
                    <label for="jzzf_name">Form ID</label>
                    <input type="text" id="jzzf_name">
                </li>
                <li>
                    <label for="jzzf_shortcode">Shortcode</label>
                    <input type="text" id="jzzf_shortcode" readonly="readonly">
                    <p class="jzzf_shortcode_info">
                        Please, copy and paste this shortcode into your page or post in order to insert this form (square brackets included).
                    </p>
                </li>
                <li>
                    <input type="checkbox" id="jzzf_realtime">
                    <label for="jzzf_realtime" class="jzzf_checkbox_label">Update output elements instantly</label>
                </li>                
            </ul>
        </div>
    </div>
    <form id="jzzf_form_form" method="post" action="#">
        <input type="hidden" id="jzzf_form_data" name="form">
        <input id="jzzf_form_save" name="save" type="button" value="Save" class="button-primary"><a href="" id="jzzf_form_cancel">Discard changes</a>
    </form>
</div>

