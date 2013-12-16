<?php

class Jzzf_List_Template {
    
    function __construct($form) {
        $this->form = $form;
        $first = true;
    }

    function id($element) {
        echo esc_attr('jzzf_' . $this->form->id . '_' . strtolower($element->name));
    }


    function script($form) {?>
<?php
    }
    
    function theme($num) {?>
    <style type="text/css">
        @import url(<?php echo plugins_url('themes/' . ((int) $num)  . '.css', JZZF_ROOT . 'front/tmpl-list.php') ?>);
    </style>
<?php
    }
    
    function css($css) { ?>
    <style type="text/css" scoped="scoped">
        <?php print $css; ?>

    </style>
<?php
    }
    
    function graph($form, $graph) {  ?>
    <script type="text/javascript">
        var jzzf_graph_<?php echo $form->id ?> = {
            "data": <?php echo json_encode($graph->data) ?>,
            "types": <?php echo json_encode($graph->types) ?>,
            "dependencies": <?php echo json_encode($graph->dependencies) ?>,
            "formulas": <?php echo json_encode($graph->formulas) ?>,
            "templates": <?php echo json_encode($graph->templates) ?>,
            "form": <?php echo json_encode($form) ?>,
            "params": <?php echo json_encode($graph->params) ?>,
            "email": <?php echo json_encode($graph->email) ?>
        };
        var jzzf_ajax_url = "<?php esc_attr_e(admin_url('admin-ajax.php'))  ?>";
        var jzzf = new jazzy_forms(jQuery, <?php echo $form->id ?>, jzzf_graph_<?php echo $form->id ?>);
    </script>
<?php
    }
    
    function head($form) { ?>
<form class="jzzf_form jzzf_form_<?php echo $form->id ?>">
<ul class="jzzf_form_elements">
<?php
    }
    
    function before($element, $ahead, $first, $is_template) { ?>
    <?php if($first) : ?>
  <li class="jzzf_row">
    <?php endif ?>
  <div class="<?php echo $element->classes ?>" <?php if($element->visible===0): ?> style="display:none;"<?php endif ?><?php
  if($is_template): ?> id="<?php $this->id($element) ?>"<?php endif ?>>
<?php
    }
    
    function after($element, $last) { ?>
  </div>
        <?php if($last) : ?>
  <div class="clear"></div>
  <div class="jzzf_message"></div>
  </li>
        <?php endif ?>
<?php
    }
    
    function number($element) { ?>
    <label class="jzzf_number_label jzzf_element_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label><?php // avoid line-feed
    ?><input type="text" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->default) ?>">
<?php
    }

    function textarea($element) { ?>
    <label class="jzzf_textarea_label jzzf_element_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label><?php // avoid line-feed
    ?><textarea id="<?php $this->id($element) ?>"><?php esc_html_e($element->default) ?></textarea>
<?php
    }
    
    function radio($element) { ?>
    <label class="jzzf_radio_label jzzf_element_label"><?php esc_html_e($element->title) ?></label>
    <ul id="<?php $this->id($element) ?>" class="jzzf_radio">
    <?php $idx = 0; foreach($element->options as $option) { $idx++; ?>
    <li>
        <input type="radio" name="<?php $this->id($element) ?>" id="<?php echo $this->id($element) . '-' . $idx ?>"<?php if($option->default): ?> checked="checked"<?php endif ?>><?php // avoid line-feed
        ?><label class="jzzf_radio_option_label" for="<?php echo $this->id($element) . '-' . $idx ?>"><?php esc_html_e($option->title) ?></label>
    </li>
<?php
        } ?>
    </ul><?php
    }
    
    function dropdown($element) { ?>
    <label class="jzzf_element_label jzzf_dropdown_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label><?php // avoid line-feed
    ?><select id="<?php $this->id($element) ?>">
    <?php foreach($element->options as $option) : ?>
    <option<?php if($option->default): ?> selected="selected"<?php endif ?>><?php esc_html_e($option->title) ?></option>
    <?php endforeach ?>
    </select>
<?php
    }

    function checkbox($element) { ?>
    <input type="checkbox" id="<?php $this->id($element) ?>"<?php if($element->default): ?> checked="checked"<?php endif ?>><?php // avoid line-feed
    ?><label class="jzzf_checkbox_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label>
<?php
    }
    
    function hidden($element) { ?>
        <input type="hidden" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->value)?>">
<?php
    }
    
    function output($element) { ?>
        <label class="jzzf_element_label jzzf_output_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label><?php // avoid line-feed
        ?><input type="text" readonly="readonly" id="<?php $this->id($element) ?>"<?php if($element->invalid) : ?> value="Invalid formula"<?php endif ?>>
<?php
    }

    function update($element) { ?>
        <input type="button" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->title) ?>">
<?php
    }

    function email($element) { ?>
        <input type="button" class="jzzf_email_button" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->title) ?>">
<?php
    }

    function reset($element) { ?>
        <input type="reset" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->title) ?>">
<?php
    }

    function heading($element) { ?>
        <?php esc_html_e($element->title) ?>
<?php
    }

    function text($element) { ?>
        <?php echo str_replace("\n", "<br />", esc_html($element->title)) ?>
<?php
    }

    function html($element) { ?>
        <?php echo $element->title ?>
<?php
    }


    function foot($form) { ?>
</ul>
</form>
<?php
    }
    
}
