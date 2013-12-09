<script id="jzzf_tmpl_common_raw" type="text/html">
<li class="jzzf_element">
    <input type="hidden" value="{{id}}" class="jzzf_element_id">
    <input type="hidden" value="{{counter}}" class="jzzf_element_counter">
    <input type="hidden" class="jzzf_element_type" value="{{type}}">
    <div class="jzzf_element_header">
        <div class="jzzf_type jzzf_type_{{type}}"></div>
        <span class="jzzf_header_title">{{display_title}}</span>
        <a href="#" class="jzzf_element_delete" title="Delete Element"></a>
        <a href="#" class="jzzf_element_clone" title="Clone Element"></a>
    </div>
    <div class="jzzf_element_body">
</script>
<script id="jzzf_tmpl_common" type="text/html">
{{>common_raw}}
        <fieldset class="jzzf_div_fixed">
            <ul class="jzzf_element_parameters">
                <li>
                    <label for="jzzf_element_{{counter}}_title">Title</label>
                    <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title jzzf_smartid_source" value="{{title}}">
                </li>
                <li>
                    <label for="jzzf_element_{{counter}}_name">ID</label>
                    <input type="text" id="jzzf_element_{{counter}}_name" class="jzzf_element_name jzzf_smartid" value="{{name}}">
                </li>
            </ul>
        </fieldset>
</script>
<script id="jzzf_tmpl_foot" type="text/html">
        <fieldset class="jzzf_div_collapsable jzzf_div_collapsed">
            <h3 class="jzzf_toggler"><div></div>Appearance</h3>
            <div class="jzzf_collapsable_body">
                <ul>
                    <li>
                        <label for="jzzf_element_{{counter}}_classes">Custom CSS classes</label>
                        <input type="text" id="jzzf_element_{{counter}}_classes" class="jzzf_element_classes" value="{{classes}}">
                    </li>
                    <li>
                        <label for="jzzf_element_{{counter}}_divisions">Width</label>
                        <select id="jzzf_element_{{counter}}_divisions" class="jzzf_element_divisions" value="{{classes}}">
                            <option value="1" {{#divisions_1}}selected="selected"{{/divisions_1}}>1/1 (Full)</option>
                            <option value="2" {{#divisions_2}}selected="selected"{{/divisions_2}}>1/2 (Half)</option>
                            <option value="3" {{#divisions_3}}selected="selected"{{/divisions_3}}>1/3 (Third)</option>
                            <option value="4" {{#divisions_4}}selected="selected"{{/divisions_4}}>1/4 (Quarter)</option>
                        </select>
                    </li>
                    <li>
                        <input type="checkbox" id="jzzf_element_{{counter}}_break" class="jzzf_element_break" {{#break}}checked="checked"{{/break}}>
                        <label for="jzzf_element_{{counter}}_break">Start new row</label>
                    </li>
                </ul>
            </div>
        </fieldset>
{{>visibility}}
    </div>
</li>
</script>
<script id="jzzf_tmpl_visibility" type="text/html">
        <fieldset class="jzzf_div_collapsable jzzf_div_collapsed">
            <h3 class="jzzf_toggler"><div></div>Visibility</h3>
            <div class="jzzf_collapsable_body">
                <ul>
                    <li>
                        <label for="jzzf_element_{{counter}}_visible">Show element...</label>
                        <select id="jzzf_element_{{counter}}_visible" class="jzzf_element_visible">
                            <option value="1" {{#visible_always}}selected="selected"{{/visible_always}}>Always</option>
                            <option value="0" {{#visible_never}}selected="selected"{{/visible_never}}>Never</option>
                        </select>
                    </li>
                </ul>
            </div>
        </fieldset>
</script>
<script id="jzzf_tmpl_validation" type="text/html">
        <fieldset class="jzzf_div_collapsable jzzf_div_collapsed">
            <h3 class="jzzf_toggler"><div></div>Validation</h3>
            <div class="jzzf_collapsable_body">
                <ul>
                    <li>
                        <input type="checkbox" id="jzzf_element_{{counter}}_required" class="jzzf_element_required" {{#required}}checked="checked"{{/required}}>
                        <label for="jzzf_element_{{counter}}_required">Required</label>
                    </li>
                    <li>
                        <label for="jzzf_element_{{counter}}_missing">Error text if missing</label>
                        <input type="text" id="jzzf_element_{{counter}}_missing" class="jzzf_element_missing" value="{{missing}}">
                    </li>
                </ul>
            </div>
        </fieldset>
</script>
<script id="jzzf_tmpl_n" type="text/html">
{{>common}}
        <fieldset class="jzzf_div_collapsable">
            <h3 class="jzzf_toggler"><div></div>Value</h3>
            <div class="jzzf_collapsable_body">
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
            </div>
        </fieldset>
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_a" type="text/html">
{{>common}}
        <fieldset class="jzzf_div_collapsable">
            <h3 class="jzzf_toggler"><div></div>Value</h3>
            <div class="jzzf_collapsable_body">
                <ul>
                    <li>
                        <label for="jzzf_element_{{id}}_default">Default text</label>
                        <input type="text" id="jzzf_element_{{id}}_default" class="jzzf_element_default" value="{{default}}">
                    </li>
                </ul>
            </div>
        </fieldset>
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_d" type="text/html">
{{>common}}
{{>options}}
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_r" type="text/html">
{{>common}}
{{>options}}
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_c" type="text/html">
{{>common}}
    <fieldset class="jzzf_div_collapsable">
        <h3 class="jzzf_toggler"><div></div>Values</h3>
        <div class="jzzf_collapsable_body">
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
        </div>
    </fieldset>
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_f" type="text/html">
{{>common}}
    <fieldset class="jzzf_div_collapsable">
        <h3 class="jzzf_toggler"><div></div>Formula</h3>
        <div class="jzzf_collapsable_body">
            <ul>
                <li>
                    <label for="jzzf_element_{{counter}}_formula">Formula</label>
                    <input type="text" id="jzzf_element_{{counter}}_formula" class="jzzf_element_formula" value="{{formula}}">
                </li>
            </ul>
        </div>
    </fieldset>
        <fieldset class="jzzf_div_collapsable jzzf_div_collapsed">
            <h3 class="jzzf_toggler"><div></div>Number format</h3>
            <div class="jzzf_collapsable_body">
                <ul>
                    <li>
                        <label for="jzzf_element_{{counter}}_prefix">Unit before number</label>
                        <input type="text" id="jzzf_element_{{counter}}_prefix" class="jzzf_element_prefix" value="{{prefix}}">
                    </li>
                    <li>
                        <label for="jzzf_element_{{counter}}_postfix">Unit after number</label>
                        <input type="text" id="jzzf_element_{{counter}}_postfix" class="jzzf_element_postfix" value="{{postfix}}">
                    </li>
                    <li>
                        <label for="jzzf_element_{{id}}_zeros">Leading zeros</label>
                        <select id="jzzf_element_{{id}}_zeros" class="jzzf_element_zeros">
                        {{#zeros_options}}
                            <option value="{{value}}"{{#selected}} selected="selected"{{/selected}}>{{value}}</option>
                        {{/zeros_options}}
                        </select>
                    </li>
                    <li>
                        <label for="jzzf_element_{{id}}_decimals">Decimals</label>
                        <select id="jzzf_element_{{id}}_decimals" class="jzzf_element_decimals">
                        {{#decimals_options}}
                            <option value="{{value}}"{{#selected}} selected="selected"{{/selected}}>{{value}}</option>
                        {{/decimals_options}}
                        </select>
                    </li>
                    <li>
                        <input type="checkbox" id="jzzf_element_{{id}}_fixed" class="jzzf_element_fixed" value="1"{{#fixed}} checked="checked"{{/fixed}}>
                        <label for="jzzf_element_{{id}}_fixed">Fixed decimals</label>
                        </select>
                    </li>
                    <li>
                        <label for="jzzf_element_{{id}}_thousands">Thousands separator</label>
                        <select id="jzzf_element_{{id}}_thousands" class="jzzf_element_thousands">
                            <option value=""{{#thousands_none}} selected="selected"{{/thousands_none}}>None</option>
                            <option value=" "{{#thousands_space}} selected="selected"{{/thousands_space}}>White space ( )</option>
                            <option value=","{{#thousands_comma}} selected="selected"{{/thousands_comma}}>Comma (,)</option>
                            <option value="."{{#thousands_point}} selected="selected"{{/thousands_point}}>Point (.)</option>
                        </select>
                    </li>
                    <li>
                        <label for="jzzf_element_{{id}}_point">Decimal point</label>
                        <select id="jzzf_element_{{id}}_point" class="jzzf_element_point">
                            <option value="."{{#point_point}} selected="selected"{{/point_point}}>Point (.)</option>
                            <option value=","{{#point_comma}} selected="selected"{{/point_comma}}>Comma (,)</option>
                        </select>
                    </li>
                </ul>
            </div>
        </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_u" type="text/html">
{{>common}}
{{>foot}}
</script>
<script id="jzzf_tmpl_x" type="text/html">
{{>common}}
{{>foot}}
</script>
<script id="jzzf_tmpl_e" type="text/html">
{{>common}}
<fieldset class="jzzf_div_fixed">See the Email tab for email settings.</fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_t" type="text/html">
{{>common_raw}}
    <fieldset class="jzzf_div_fixed">
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">Text</label>
                <textarea id="jzzf_element_{{counter}}_title" class="jzzf_element_title jzzf_smartid_source">{{title}}</textarea>
            </li>
            <li>
                <label for="jzzf_element_{{counter}}_name">ID</label>
                <input type="text" id="jzzf_element_{{counter}}_name" class="jzzf_element_name jzzf_smartid" value="{{name}}">
            </li>
        </ul>
    </fieldset>
{{>validation}}
{{>foot}}
</script>
<script id="jzzf_tmpl_h" type="text/html">
{{>common_raw}}
    <fieldset class="jzzf_div_fixed">
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">Heading</label>
                <input type="text" id="jzzf_element_{{counter}}_title" class="jzzf_element_title jzzf_smartid_source" value="{{title}}">
            </li>
            <li>
                <label for="jzzf_element_{{counter}}_name">ID</label>
                <input type="text" id="jzzf_element_{{counter}}_name" class="jzzf_element_name jzzf_smartid" value="{{name}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>
<script id="jzzf_tmpl_m" type="text/html">
{{>common_raw}}
    <fieldset class="jzzf_div_fixed">
        <ul>
            <li>
                <label for="jzzf_element_{{counter}}_title">HTML code</label>
                <textarea id="jzzf_element_{{counter}}_title" class="jzzf_element_title jzzf_smartid_source">{{title}}</textarea>
            </li>
            <li>
                <label for="jzzf_element_{{counter}}_name">ID</label>
                <input type="text" id="jzzf_element_{{counter}}_name" class="jzzf_element_name jzzf_smartid" value="{{name}}">
            </li>
        </ul>
    </fieldset>
{{>foot}}
</script>

<script id="jzzf_tmpl_options" type="text/html">
        <fieldset class="jzzf_div_collapsable">
            <h3 class="jzzf_toggler"><div></div>Options</h3>
            <div class="jzzf_collapsable_body">
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
            </div>
        </fieldset>
</script>
<script id="jzzf_tmpl_option" type="text/html">
                <tr class="jzzf_option">
                    <td class="jzzf_column_drag jzzf_option_drag">&nbsp;</td>
                    <td class="jzzf_column_default"><input type="radio" name="jzzf_radio_{{counter}}" class="jzzf_option_default" {{#default}}checked="checked"{{/default}}></td>
                    <td class="jzzf_column_title"><input type="hidden" value="{{id}}" class="jzzf_option_id"><input type="text" value="{{title}}" class="jzzf_option_title"></td>
                    <td class="jzzf_column_value"><input type="text" value="{{value}}" class="jzzf_option_value"></td>
                    <td><a href="" class="jzzf_option_delete"></a></td>
                </tr>
</script>
<script type="text/javascript">//<![CDATA[
    var jzzf_forms = <?php echo json_encode($forms) ?>;
//]]></script>
<h2>Jazzy Forms</h2>
<div class="jzzf_head" id="jzzf_selection">
    <div class="jzzf_selection_label">
        Select a form:
    </div>
    <form id="jzzf_delete_form" method="post" action="#">
    <div class="jzzf_selection_main">
        <select id="jzzf_selector">
    <?php $i=0; foreach($forms as $form) : ?>
            <option value="<?php echo $i++ ?>"<?php if($form->id == $current) :?> selected="selected"<?php endif ?>><?php echo esc_attr($form->title) ?></option>
    <?php endforeach; ?>
        </select>
    </div>
    <div class="jzzf_selection_action">
        <input id="jzzf_delete" name="delete" type="hidden" value="0">
        <a id="jzzf_selector_new" href="">New</a> <a id="jzzf_selector_clone" href="">Clone</a> <a id="jzzf_selector_delete" href="">Delete</a>
    </div>
    </form>
</div>
<div class="jzzf_head" id="jzzf_new_form">
    <div class="jzzf_selection_label">
        New Form Title:
    </div>
    <div class="jzzf_selection_main">
        <input type="text" id="jzzf_new_form_title" name="jzzf_new_form_title" value="New Form">
    </div>
</div>
<div id="message" class="updated" <?php if(!$msg): ?>style="display:none"<?php endif ?>><p><?php esc_html_e($msg) ?></p></div>
<div id="jzzf_form">
    <ul id="jzzf_tabs">
        <li jzzf_section="elements">Elements</li>
        <li jzzf_section="validation">Validation</li>
        <li jzzf_section="appearance">Appearance</li>
        <li jzzf_section="email">Email</li>
        <li jzzf_section="general" >General</li>
    </ul>
    <div id="jzzf_main">
        <div class="jzzf_section" id="jzzf_section_elements">
            <div class="jzzf_elements_toolbox">
            <div class="jzzf_column_heading" id="jzzf_elements_toolbox_description">Available form elements</div>
                <ul id="jzzf_toolbox_input" class="jzzf_elements_toolbox_items">
                    <li jzzf_type="n"><div class="jzzf_type jzzf_type_n"></div>Input</li>
                    <li jzzf_type="a"><div class="jzzf_type jzzf_type_a"></div>Text Area</li>
                    <li jzzf_type="d"><div class="jzzf_type jzzf_type_d"></div>Drop-down Menu</li>
                    <li jzzf_type="r"><div class="jzzf_type jzzf_type_r"></div>Radio Buttons</li>
                    <li jzzf_type="c"><div class="jzzf_type jzzf_type_c"></div>Checkbox</li>
                    <li jzzf_type="f"><div class="jzzf_type jzzf_type_f"></div>Output</li>
                </ul>
                <ul id="jzzf_toolbox_buttons" class="jzzf_elements_toolbox_items">
                    <li jzzf_type="u"><div class="jzzf_type jzzf_type_u"></div>Update Button</li>
                    <li jzzf_type="x"><div class="jzzf_type jzzf_type_x"></div>Reset Button</li>
                    <li jzzf_type="e"><div class="jzzf_type jzzf_type_e"></div>Email Button</li>
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
        <div class="jzzf_section" id="jzzf_section_validation">
            <ul>
                <li>
                    <label for="jzzf_incomplete">Error text if required fields are missing</label><br>
                    <textarea id="jzzf_incomplete"></textarea>
                </li>
            </ul>
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
        <div class="jzzf_section" id="jzzf_section_email">
            <div class="jzzf_email_disclaimer">
                Please add an Email button to activate Email.
            </div>
            <div class="jzzf_email_settings">
                <div class="jzzf_help">
                    You can use placeholders enclosed by double curly braces here to display user input or calculated values referenced by their IDs, or even the results of inline formulas. <br/><br/> Examples:<br/><br/>
                    <ul class="jzzf_examples">
                        <li><pre>Hello {{name}}!</pre></li>
                        <li><pre>From: {{name}} <{{email}}></pre></li>
                        <li><pre>The sum of {{a}} and {{b}} is {{a+b}}</pre></li>
                    </ul>
                </div>
                <ul>
                    <li>
                        <label for="jzzf_email_to">To</label>
                        <input type="text" id="jzzf_email_to">
                    </li>
                    <li>
                        <label for="jzzf_email_from">From</label>
                        <input type="text" id="jzzf_email_from">
                    </li>
                    <li>
                        <label for="jzzf_email_cc">CC</label>
                        <input type="text" id="jzzf_email_cc">
                    </li>
                    <li>
                        <label for="jzzf_email_bcc">BCC</label>
                        <input type="text" id="jzzf_email_bcc">
                    </li>
                    <li>
                        <label for="jzzf_email_subject">Subject</label>
                        <input type="text" id="jzzf_email_subject">
                    </li>
                    <li>
                        <label for="jzzf_email_message">Message</label><br>
                        <textarea id="jzzf_email_message"></textarea>
                    </li>
                </ul>
                <div class="jzzf_subsection_heading">Status messages</div>
                <ul>
                    <li>
                        <label for="jzzf_email_sending">Sending</label>
                        <input type="text" id="jzzf_email_sending">
                    </li>
                    <li>
                        <label for="jzzf_email_ok">Success</label>
                        <input type="text" id="jzzf_email_ok">
                    </li>
                    <li>
                        <label for="jzzf_email_fail">Failure</label>
                        <input type="text" id="jzzf_email_fail">
                    </li>
                </ul>
            </div>
        </div>
        <div class="jzzf_section" id="jzzf_section_general" class="jzzf_smartid_section">
            <input type="hidden" id="jzzf_id">
            <ul>
                <li>
                    <label for="jzzf_title">Form Title</label>
                    <input type="text" id="jzzf_title" class="jzzf_smartid_source">
                </li>
                <li>
                    <label for="jzzf_name">Form ID</label>
                    <input type="text" id="jzzf_name" class="jzzf_smartid">
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
        <input id="jzzf_form_save" name="save" type="button" value="Save" class="button-primary"><a href="" id="jzzf_form_cancel">Cancel</a>
    </form>
    <div class="jzzf_doculink">For documentation and more click <a href="http://www.jazzyforms.com/?utm_source=wordpress&utm_medium=admin_panel&utm_term=&utm_content=&utm_campaign=footer_<?php echo JZZF_VERSION_STRING ?>">here</a></div>
</div>

