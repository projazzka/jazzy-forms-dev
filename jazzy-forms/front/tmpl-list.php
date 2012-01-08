<?php

class Jzzf_List_Template {
    function __construct($form) {}

    function script($form) {?>
        <script type="text/javascript" src="<?php echo plugins_url('jazzy-forms.js', JZZF_ROOT . 'front/tmpl-list.php') ?>"></script>
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
    <label class="jzzf_number_label jzzf_element_label" for="<?php echo htmlspecialchars($id) ?>"><?php echo htmlspecialchars($element->title) ?></label>
    <input type="text" id="jzzf_<?php echo htmlspecialchars($element->id) ?>" value="<?php echo htmlspecialchars($element->default) ?>">
<?php
    }
    
    function radio($element) { ?>
    <label class="jzzf_radio_label jzzf_element_label"><?php echo htmlspecialchars($element->title) ?></label>
    <ul class="jzzf_radio">
    <?php $idx = 0; foreach($element->options as $option) { $idx++; ?>
    <li>
        <input type="radio" name="jzzf_<?php echo htmlspecialchars($element->id) ?>"<?php if($option->default): ?> checked="checked"<?php endif ?>>
        <label class="jzzf_radio_option_label"><?php echo htmlspecialchars($option->title) ?></label>
    </li>
<?php
        } ?>
    </ul><?php
    }
    
    function dropdown($element) { ?>
    <label class="jzzf_element_label jzzf_dropdown_label"><?php echo htmlspecialchars($element->title) ?></label>
    <select id="jzzf_<?php echo htmlspecialchars($element->id) ?>">
    <?php foreach($element->options as $option) : ?>
    <option<?php if($option->default): ?> checked="checked"<?php endif ?>><?php echo htmlspecialchars($option->title) ?></option>
    <?php endforeach ?>
    </select>
<?php
    }

    function checkbox($element) { ?>
    <input type="checkbox" id="jzzf_<?php echo htmlspecialchars($element->id) ?>"<?php if($element->default): ?> checked="checked"<?php endif ?>>
    <label class="jzzf_checkbox_label" for="jzzf_<?php echo htmlspecialchars($element->id) ?>"><?php echo htmlspecialchars($element->title) ?>
<?php
    }
    
    function hidden($element) { ?>
        <input type="hidden" id="jzzf_<?php echo htmlspecialchars($element->id) ?>" value="<?php echo htmlspecialchars($element->value)?>">
<?php
    }
    
    function output($element) { ?>
        <label class="jzzf_element_label jzzf_output_label" for="jzzf_<?php echo htmlspecialchars($id) ?>"><?php echo htmlspecialchars($element->title) ?></label>
        <input type="text" readonly="readonly" id="jzzf_<?php echo htmlspecialchars($element->id) ?>">
<?php
    }

    function foot($form) { ?>
</ul>
</div>
<?php
    }
    
}