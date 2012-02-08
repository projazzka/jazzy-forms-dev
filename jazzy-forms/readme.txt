=== Jazzy Forms ===
Contributors: jazzigor
Donate link: http://www.jazzyforms.com/
Tags: forms, form generator, calculator, price calculator, cost estimate
Requires at least: 3.2.1
Tested up to: 3.3.1
Stable tag: 0.9.3

Jazzy Forms is an online form generator that performs instant calculations. It's ideal for inter-active price calculators.

== Description ==

Jazzy Forms is an online form generator that performs instant calculations. It's ideal for inter-active price calculators.

Features:

* Form insertion into posts or pages
* Easy form set-up with drag and drop
* Real-time formula evaluation

Form elements:

* Number entry
* Radio buttons
* Drop-down menu
* Check-boxes
* Output
* Update button

This is an early release. Features like input validation, data collection or Email are still being worked on.

== Installation ==

Install and activate the plugin. See the Frequently Asked Questions (FAQ) section on how to set up forms and insert them into your site.

== Frequently Asked Questions ==

= Where is the Jazzy Forms administration screen? =

This software adds a "Forms" item to WordPress'es menu in the sidebar. That's where you set up your forms.

= How to create a new form ? =

On the Forms screen, add a new form, then drag the desired elements into it, change their titles and settings. Finally don't forget to hit the Save button.

= How to insert a form on my site? =

Simply insert the following shortcode in the post or page you want the form to appear in:

[jazzy form="FORM_ID"]

Replace FORM_ID with the ID of the form you want to add. The complete shortcode for your form is also displayed on its administration screen in the "General" tab. Copy and paste it from there.

= Is there a way to insert a form without a shortcode? =

The short code is useful for posts or pages, without the need of any coding. Alternatively programmers and theme designers can also use the corresponding PHP functions to do so.

Place the following code in the header, before a call to wp_head(), in order to queue Jazzy Forms' JavaScript scripts:
`<?php jzzf_queue() ?>`

To insert a form with ID "form_id" do the following:
`<?php jzzf_form('form_id') ?>`

This prints out the form to the screen. If you need to process the output in any way use something like this:
`<?php echo jzzf_form('form_id', null, true) ?>`

There are also corresponding WordPress actions:
`<?php do_action('jzzf_queue') ?>`
`<?php do_action('jzzf_form', 'form_id') ?>`

= Is there a way to use a Jazzy Form within a widget? =

There is no Jazzy Forms widget yet, but you can use the shortcode within WordPress'es default "Text" widget with minor trickery: use the `<?php jzzf_queue() ?>` in order to queue Jazzy Forms' JavaScript as described in the previous section. Then add the following line somewhere, e.g. at the and of your theme's "functions.php" file: `add_filter('widget_text','do_shortcode');`
With this line the Text widget handles shortcodes.

= What are element IDs good for ? =

Each element is assigned a so called ID (identifier) that you can choose. These IDs are used to reference the form elements' values in formulas. IDs must start with a letter (a-z) and be all lower-case characters or numbers. Special characters or white space are not permitted.

= What's the format or syntax of a formula ? =

Formulas are thought to have a similar notation to what you are probably used to from popular spreadsheet programs. An example could be:

`(base_price + price * quantity) * (1 + tax/100)`

where "base_price", "price", "quantity" and "tax" are IDs of other existing form elements.

= Do you accept donations? =

Thank you. For this project your feedback, your ideas and suggestions are much more valuable for me than your money! So please drop me an email instead.

= Is there a list of known issues? =

Yes, Jazzy Forms is still at an early stage. Bugs and enhancement request are tracked [here](https://github.com/l90r/jazzy-forms-dev/issues?sort=created&direction=desc&state=open).

= I have a suggestion =

Bug reports and support requests are handled in the official WordPress forum. You can also get in touch with me at jazzyforms@gmail.com and twitter.com/jazzyforms .

I would love to gain insight about the way you are using this software and the things you are missing. Please help me building up a really useful product.

== Screenshots ==

== Changelog ==

= 0.9.3 =
* Fix on fix: properly treat uppercase and underscore character in IDs and formulas
* Correctly treat invalid/unexpected characters in formulas
* Correctly display "Checked by default" setting
* Third argument in IF function to be optional 

= 0.9.2 =
* Ignore uppercase/lowercase for variable and function names
* Allow multiple forms on one page
* Add logical functions (IF, AND, NOT, OR) and comparison operators
* Add basic maths functions (SQRT, trigonometric...)
* Fix numeric precision
* Fix default selection for dropdown menus

= 0.9.1 =
* Correctly handle character sets and collations (including Russian)
* Fixed values for radio buttons
* Accept whitespace in formulas
* Adding insertion/queueing functions for the use in themes instead of the shortcode
* Fixed post insertion that sporadically caused partial loss of WordPress HTML code

= 0.9 =
* Initial release (beta)

== Upgrade Notice ==
