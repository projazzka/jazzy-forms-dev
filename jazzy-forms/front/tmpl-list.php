<?php

class Jzzf_List_Template {
    function __construct($form) {}

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
    <style type="text/css">
        <?php print $css; ?>

    </style>
<?php
    }
    
    function graph($graph) { extract($graph); ?>
    <script type="text/javascript">
        jzzf_data = <?php echo json_encode($data) ?>;
        jzzf_types = <?php echo json_encode($types) ?>;
        jzzf_dependencies = <?php echo json_encode($dependencies) ?>;
        jzzf_formulas = <?php echo json_encode($formulas) ?>;
    </script>
<?php
    }
    
    function head($form) { ?>
<div class="jzzf_form">
<ul>
<?php
    }
    
    function before($element) { ?>
  <li class="jzzf_element">
<?php
    }
    
    function after($element) { ?>
  </li>
<?php
    }
    
    function number($element) { ?>
    <label class="jzzf_number_label jzzf_element_label" for="jzzf_<?php esc_attr_e($element->name) ?>"><?php esc_html_e($element->title) ?></label>
    <input type="text" id="jzzf_<?php esc_attr_e($element->name) ?>" value="<?php esc_attr_e($element->default) ?>">
<?php
    }
    
    function radio($element) { ?>
    <label class="jzzf_radio_label jzzf_element_label"><?php esc_html_e($element->title) ?></label>
    <ul class="jzzf_radio">
    <?php $idx = 0; foreach($element->options as $option) { $idx++; ?>
    <li>
        <input type="radio" name="jzzf_<?php esc_attr_e($element->name) ?>"<?php if($option->default): ?> checked="checked"<?php endif ?>>
        <label class="jzzf_radio_option_label"><?php esc_html_e($option->title) ?></label>
    </li>
<?php
        } ?>
    </ul><?php
    }
    
    function dropdown($element) { ?>
    <label class="jzzf_element_label jzzf_dropdown_label"><?php esc_html_e($element->title) ?></label>
    <select id="jzzf_<?php esc_attr_e($element->name) ?>">
    <?php foreach($element->options as $option) : ?>
    <option<?php if($option->default): ?> checked="checked"<?php endif ?>><?php esc_html_e($option->title) ?></option>
    <?php endforeach ?>
    </select>
<?php
    }

    function checkbox($element) { ?>
    <input type="checkbox" id="jzzf_<?php esc_attr_e($element->name) ?>"<?php if($element->default): ?> checked="checked"<?php endif ?>>
    <label class="jzzf_checkbox_label" for="jzzf_<?php esc_attr_e($element->name) ?>"><?php esc_html_e($element->title) ?>
<?php
    }
    
    function hidden($element) { ?>
        <input type="hidden" id="jzzf_<?php esc_attr_e($element->name) ?>" value="<?php esc_attr_e($element->value)?>">
<?php
    }
    
    function output($element) { ?>
        <label class="jzzf_element_label jzzf_output_label" for="jzzf_<?php esc_attr_e($name) ?>"><?php esc_html_e($element->title) ?></label>
        <input type="text" readonly="readonly" id="jzzf_<?php esc_attr_e($element->name) ?>"<?php if($element->invalid) : ?> value="Invalid formula"<?php endif ?>>
<?php
    }

    function update($element) { ?>
        <input type="submit" id="jzzf_<?php esc_attr_e($element->name) ?>" value="<?php esc_attr_e($element->title) ?>">
<?php
    }

    function foot($form) { ?>
</ul>
</div>
<?php
    }
    
}