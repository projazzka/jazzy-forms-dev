=== Jazzy Forms ===
Contributors: jazzigor
Donate link: http://www.jazzyforms.com/?utm_source=wordpress&utm_medium=plugin_directory&utm_term=&utm_content=&utm_campaign=donate
Tags: forms, form generator, form builder, calculator, price calculator, cost estimate, quote, email
Requires at least: 3.2.1
Tested up to: 3.8
Stable tag: 1.1.1

Online form builder, ideal for cost-estimates and calculations

== Description ==

Jazzy Forms is an online form generator that performs instant calculations. It's ideal for inter-active price calculators and for sending out cost estimates by email.

* Form insertion into posts or pages
* Easy form set-up with drag and drop
* Email
* Real-time evaluation of spreadsheet-like formulas
* Comprehensive functions library
* Hidden elements
* Rich number formatting
* Flexible (vertical or side-by-side) layout
* Formula placeholders in text output elements
* Required/obligatory fields and error messages

Form elements:

* Single/Multi-line input
* Radio buttons
* Drop-down menu
* Check-boxes
* Output
* Update button
* Reset button
* Email button
* Text/Heading/HTML

[Official web site](http://www.jazzyforms.com/?utm_source=wordpress&utm_medium=plugin_directory&utm_term=&utm_content=&utm_campaign=official)

== Installation ==

Install and activate the plugin. See the Frequently Asked Questions (FAQ) section on how to set up forms and insert them into your site.

== Frequently Asked Questions ==

= Where is the Jazzy Forms administration screen? =

This software adds a "Forms" item to WordPress'es menu in the sidebar. That's where you set up your forms.

= How to create a new form ? =

On the Forms screen, add a new form, then drag the desired elements into it, change their titles and settings. Finally don't forget to hit the Save button.

= How to insert a form on my site? =

Simply insert the following shortcode in the post or page you want the form to appear in:

`[jazzy form="FORM_ID"]`

Replace FORM_ID with the ID of the form you want to add. The complete shortcode for your form is also displayed on its administration screen in the "General" tab. Copy and paste it from there.

= Is there a way to insert a form without a shortcode? =

The short code is useful for posts or pages, without the need of any coding. Alternatively programmers and theme designers can also use the corresponding PHP functions to do so.

Place the following code in the header, before a call to wp_head(), in order to queue Jazzy Forms' JavaScript scripts:
`<?php jzzf_enqueue() ?>`

To insert a form with ID "form_id" do the following:
`<?php jzzf_form('form_id') ?>`

This prints out the form to the screen. If you need to process the output in any way use something like this:
`<?php echo jzzf_form('form_id', null, true) ?>`

There are also corresponding WordPress actions:
`<?php do_action('jzzf_enqueue') ?>`
`<?php do_action('jzzf_form', 'form_id') ?>`

= Is there a way to use a Jazzy Form within a widget? =

There is no Jazzy Forms widget yet, but you can use the shortcode within WordPress'es default "Text" widget with minor trickery: use the `<?php jzzf_queue() ?>` in order to queue Jazzy Forms' JavaScript as described in the previous section. Then add the following line somewhere, e.g. at the and of your theme's "functions.php" file: `add_filter('widget_text','do_shortcode');`
With this line the Text widget handles shortcodes.

= What are element IDs good for ? =

Each element is assigned a so called ID (identifier) that you can choose. These IDs are used to reference the form elements' values in formulas. IDs must start with a letter (a-z) and be all lower-case characters or numbers. Special characters or white space are not permitted.

= Is there any documentation? =

It is in the works. You can take a look at its current state [here](http://www.jazzyforms.com/documentation/?utm_source=wordpress&utm_medium=plugin_directory&utm_term=&utm_content=&utm_campaign=faq_docu)

= What's the format or syntax of a formula ? =

Formulas are thought to have a similar notation to what you are probably used to from popular spreadsheet programs. An example could be:

`(base_price + price * quantity) * (1 + tax/100)`

where "base_price", "price", "quantity" and "tax" are IDs of other existing form elements.
You can see a list of available functions [here](http://www.jazzyforms.com/documentation/functions?utm_source=wordpress&utm_medium=plugin_directory&utm_term=&utm_content=&utm_campaign=faq_functions)

= Can I use results in text output fields? =

Yes, you can use text, heading and HTML elements with formulas. Wrap these formulas in double curly braces like in the following example:

`Dear {{name}}, your cost estimate is {{total+fee}}.`

= Do you accept donations? =

Thank you. For this project your feedback, your ideas and suggestions are much more valuable for me than your money! So please drop me an email instead.

= I have a suggestion =

Bug reports and support requests are handled in the official WordPress forum. You can also get in touch with me at jazzyforms@gmail.com and twitter.com/jazzyforms .

I would love to gain insight about the way you are using this software and the things you are missing. Please help me building up a really useful product.

== Screenshots ==

== Changelog ==

= 1.1.1 =
* Fix operator precedence
* Avoid excessive recursion (nested functions error)
* Avoid conflicts in backend menu position

= 1.1 =
* Support for percentage notation
* Extend LABEL function to checkboxes
* SELECTED and CHECKED functions
* Several backend fixes

= 1.0 =
* Required fields and corresponding validation
* Minor backend layout fixes for 3.8
* Frontend stylesheet not to affect default button styling
* Improve compability with Firefox' stylesheet importing
* Improve compability with plugins that move scripts to the footer

= 0.11 =
* Backend: form and element duplication
* Backend: automatically propose element IDs based on titles
* fix IF function: now works correctly without third argument

= 0.10.1 =
* Negation operation to work with non-numbers, e.g. -x
* Re-calculate formula when reset button is hit
* Allow the IF function to circumvent errors (lazy evaluation)
* Logarithm, square root and rounding functions to throw appropriate errors
* Improve email compatibility

= 0.10 =
* performance improvements
* label(id) function to access the label of currently selected dropdown option/radio button
* formatted(id) function to get the textual representation of a field's formatted content
* text concatenation operator (&) and support for formulas with text output
* mitigate the risk of extra linebreaks being introduced by external text filters
* new textarea element
* fix number formatting for very large and small numbers
* detect circular dependencies
* spreadsheet-like error codes
* fixed 3w validation

= 0.9.10 =
* Take into account text elements without placeholders (urgent fix)

= 0.9.9 =
* Real-time templating (evaluate placeholders in text/heading/html elements)
* Enhance analaysis and logging tools under the hood
* Avoid issues with outdated cached JS scripts

= 0.9.8 =
* Email fix: complete Cc and Bcc implementation
* Email fix: don't fail for numeric values
* Email fix: send emails for users that are not logged in (!)
* Email fix: respect wp_mail()'s return value
* Improve compatibility with WPMU
* New functions: MROUND, logarithm and exponential functions

= 0.9.7 =
* Emergency update (missing file in v0.9.6)

= 0.9.6 (do not install) =
* Email (using placeholders and inline formulas)
* Reset button
* Fixed IE8 compatibility issues
* Enhanced usability of text/heading elements (use textareas)
* Enhanced debugging (optional logging)

= 0.9.5 =
* Fix updating procedure (support automatic updates)
* Improve performance
* Element visibility (hide/show elements)
* Support long titles, formulas and CSS definitions
* Number formatting
* Horizontal (side-by-side) layout
* Custom extra CSS/HTML classes for elements

= 0.9.4 =
* Some GUI polishing
* Treat quotes correctly on the back-end
* Avoid crashes/freeze on formulas with unbalanced paranthesis
* Add extra elements for text, heading and raw HTML
* Make real-time updating optional
* Generate valid HTML5 code

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
