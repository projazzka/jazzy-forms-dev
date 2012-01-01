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
        Dropdown menu (to be implementd)
<?php
    }

    function hidden($element) { ?>
        Hidden element (to be implementd)
<?php
    }
    
    function foot($form) { ?>
</ul>
<?php
    }
    
}