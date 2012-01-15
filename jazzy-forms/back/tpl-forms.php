<script id="jzzf_tmpl_common" type="text/html">
<li class="jzzf_element">
    <input type="hidden" value="{{id}}" class="jzzf_element_id">
    <input type="hidden" value="{{counter}}" class="jzzf_element_counter">
    <div class="jzzf_element_header">
        <span class="jzzf_type jzzf_type_{{type}}">[{{typeString}}]</span>
        <span class="jzzf_header_title">{{title}}</span>
        <a href="#" class="jzzf_element_delete">(x)</a>
    </div>
    <div class="jzzf_element_body">
        <fieldset>
            <ul class="jzzf_element_parameters">
                <li>
                    <input type="hidden" class="jzzf_element_type" value="{{type}}">
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
        <legend>Formula</legend>
        <label for="jzzf_element_{{counter}}_formula">Formula</label>
        <input type="text" id="jzzf_element_{{counter}}_formula" class="jzzf_element_formula" value="{{formula}}">
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_options" type="text/html">
        <fieldset>
            <legend>Options</legend>
            <table class="jzzf_option_table">
            <thead><tr>
                <th></th>
                <th>Default</th>
                <th>Title</th>
                <th>Value</th>
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
                    <td class="jzzf_option_drag">[drag]</td>
                    <td><input type="radio" name="jzzf_radio_{{counter}}" class="jzzf_option_default" {{#default}}checked="checked"{{/default}}></td>
                    <td><input type="hidden" value="{{id}}" class="jzzf_option_id"><input type="text" value="{{title}}" class="jzzf_option_title"></td>
                    <td><input type="text" value="{{value}}" class="jzzf_option_value"></td>
                    <td><a href="" class="jzzf_option_delete">(x)</a></td>
                </tr>
</script>
<script type="text/javascript">//<![CDATA[
    var jzzf_forms = <?php echo json_encode($forms) ?>;
//]]></script>
<h2>Jazzy Forms</h2>
<div id="jzzf_selection">
    <form id="jzzf_delete_form" method="post" action="#">
    <select id="jzzf_selector">
<?php $i=0; foreach($forms as $form) : ?>
        <option value="<?php echo $i++ ?>"><?php echo htmlspecialchars($form->title) ?></option>
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
<div id="message" class="updated" <?php if(!$msg): ?>style="display:none"<?php endif ?>><p><?php echo htmlspecialchars($msg) ?></p></div>
<div id="jzzf_form">
    <ul id="jzzf_tabs">
        <li jzzf_section="elements">Elements</li>
        <li jzzf_section="appearance">Appearance</li>
        <li jzzf_section="general" >General</li>
    </ul>
    <div id="jzzf_main">
        <div class="jzzf_section" id="jzzf_section_elements">
            <div id="jzzf_elements_toolbox">
                <div id="jzzf_elements_toolbox_description">Click or drag to add</div>
                <ul id="jzzf_elements_toolbox_items">
                    <li jzzf_type="n">Number Entry</li>
                    <li jzzf_type="d">Drop-down Menu</li>
                    <li jzzf_type="r">Radio Buttons</li>
                    <li jzzf_type="c">Checkbox</li>
                    <li jzzf_type="f">Output</li>
                </ul>
            </div>
            <div id="jzzf_elements">
                Form Elements
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
                    <label for="jzzf_css">Custom CSS</label>
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
                
            </ul>
        </div>
    </div>
    <form id="jzzf_form_form" method="post" action="#">
        <input type="hidden" id="jzzf_form_data" name="form">
        <input id="jzzf_form_save" name="save" type="button" value="Save" class="button-primary"><a href="" id="jzzf_form_cancel">Discard changes</a>
    </form>
</div>

