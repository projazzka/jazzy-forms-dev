<?php

class Jzzf_List_Template {
    function __construct($form) {}
    
    function head($form) { ?>
<ul>
<?php
    }
    
    function before($element) { ?>
  <li>
<?php
    }
    
    function after($element) { ?>
  </li>
<?php
    }
    
    function number($element) { ?>
    <label for="<?php echo htmlspecialchars($id) ?>"><?php echo htmlspecialchars($element->title) ?></label>
    <input type="text" id="<?php echo htmlspecialchars($element->id) ?>">
<?php
    }
    
    function radio($element) { ?>
    <label><?php echo htmlspecialchars($element->title) ?></label>
    <?php $idx = 0; foreach($element->options as $option) { $idx++; ?>
    <input type="radio"><label><?php echo htmlspecialchars($option->title) ?></label>    
<?php
        }
    }
    
    function dropdown($element) { ?>
    <label><?php echo htmlspecialchars($element->title) ?></label>
    <select id="<?php echo htmlspecialchars($element->id) ?>">
    <?php foreach($element->options as $option) : ?>
    <option><label><?php echo htmlspecialchars($option->title) ?></option>
    <?php endforeach ?>
    </select>
<?php
    }

    function hidden($element) { ?>
        <input type="hidden" id="<?php echo htmlspecialchars($element->id) ?>" value="<?php echo htmlspecialchars($element->value)?>">
<?php
    }
    
    function output($element) { ?>
        <label for="<?php echo htmlspecialchars($id) ?>"><?php echo htmlspecialchars($element->title) ?></label>
        <input type="text" readonly="readonly" id="<?php echo htmlspecialchars($element->id) ?>">
<?php
    }

    function foot($form) { ?>
</ul>
<?php
    }
    
}