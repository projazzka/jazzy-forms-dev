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
    
    function graph($form, $graph) { extract($graph); ?>
    <script type="text/javascript">
        jzzf_data_<?php echo $form->id ?> = <?php echo json_encode($data) ?>;
        jzzf_types_<?php echo $form->id ?> = <?php echo json_encode($types) ?>;
        jzzf_dependencies_<?php echo $form->id ?> = <?php echo json_encode($dependencies) ?>;
        jzzf_formulas_<?php echo $form->id ?> = <?php echo json_encode($formulas) ?>;
        jzzf_form_<?php echo $form->id ?> = <?php echo json_encode($form) ?>;
        jzzf_params_<?php echo $form->id ?> = <?php echo json_encode($params) ?>;
        jazzy_forms(jQuery, <?php echo $form->id ?>, jzzf_data_<?php echo $form->id ?>, jzzf_types_<?php echo $form->id ?>, jzzf_dependencies_<?php echo $form->id ?>, jzzf_formulas_<?php echo $form->id ?>, jzzf_form_<?php echo $form->id ?>, jzzf_params_<?php echo $form->id ?>);
    </script>
<?php
    }
    
    function head($form) { ?>
<div class="jzzf_form">
<ul class="jzzf_form_elements">
<?php
    }
    
    function before($element, $ahead, $first) { ?>
    <?php if($first) : ?>
  <li class="jzzf_row">
    <?php endif ?>
  <div class="<?php echo $element->classes ?>" "<?php if($element->visible===0): ?> style="display:none;"<?php endif ?>>
<?php
    }
    
    function after($element, $last) { ?>
  </div>
        <?php if($last) : ?>
  <div class="clear"></div>
  </li>
        <?php endif ?>
<?php
    }
    
    function number($element) { ?>
    <label class="jzzf_number_label jzzf_element_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label>
    <input type="text" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->default) ?>">
<?php
    }
    
    function radio($element) { ?>
    <label class="jzzf_radio_label jzzf_element_label"><?php esc_html_e($element->title) ?></label>
    <ul id="<?php $this->id($element) ?>" class="jzzf_radio">
    <?php $idx = 0; foreach($element->options as $option) { $idx++; ?>
    <li>
        <input type="radio" name="<?php $this->id($element) ?>" id="<?php echo $this->id($element) . '-' . $idx ?>"<?php if($option->default): ?> checked="checked"<?php endif ?>>
        <label class="jzzf_radio_option_label" for="<?php echo $this->id($element) . '-' . $idx ?>"><?php esc_html_e($option->title) ?></label>
    </li>
<?php
        } ?>
    </ul><?php
    }
    
    function dropdown($element) { ?>
    <label class="jzzf_element_label jzzf_dropdown_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label>
    <select id="<?php $this->id($element) ?>">
    <?php foreach($element->options as $option) : ?>
    <option<?php if($option->default): ?> selected="selected"<?php endif ?>><?php esc_html_e($option->title) ?></option>
    <?php endforeach ?>
    </select>
<?php
    }

    function checkbox($element) { ?>
    <input type="checkbox" id="<?php $this->id($element) ?>"<?php if($element->default): ?> checked="checked"<?php endif ?>>
    <label class="jzzf_checkbox_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label>
<?php
    }
    
    function hidden($element) { ?>
        <input type="hidden" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->value)?>">
<?php
    }
    
    function output($element) { ?>
        <label class="jzzf_element_label jzzf_output_label" for="<?php $this->id($element) ?>"><?php esc_html_e($element->title) ?></label>
        <input type="text" readonly="readonly" id="<?php $this->id($element) ?>"<?php if($element->invalid) : ?> value="Invalid formula"<?php endif ?>>
<?php
    }

    function update($element) { ?>
        <input type="submit" id="<?php $this->id($element) ?>" value="<?php esc_attr_e($element->title) ?>">
<?php
    }

    function heading($element) { ?>
        <?php esc_html_e($element->title) ?>
<?php
    }

    function text($element) { ?>
        <?php esc_html_e($element->title) ?>
<?php
    }

    function html($element) { ?>
        <?php echo $element->title ?>
<?php
    }


    function foot($form) { ?>
</ul>
</div>
<?php
    }
    
}
