<?php

/**
 * Widgets handler for the ClearOS theme.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2011-2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

//////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// A N C H O R S  A N D  B U T T O N S
///////////////////////////////////////////////////////////////////////////////

/**
 * Anchor widget.
 *
 * Classes:
 * - theme-anchor-add
 * - theme-anchor-cancel
 * - theme-anchor-configure
 * - theme-anchor-delete
 * - theme-anchor-disable
 * - theme-anchor-edit
 * - theme-anchor-enable
 * - theme-anchor-next
 * - theme-anchor-ok
 * - theme-anchor-previous
 * - theme-anchor-select
 * - theme-anchor-view
 * - theme-anchor-custom (button with custom text)
 * - theme-anchor-javascript (button that does some other javascript action)
 *
 * Options:
 * - class: additional classes
 * - id: HTML id
 * - disabled: to disable button
 * - hide: to hide button
 * - no_escape_html: avoid escaping HTML
 * - state: enabled/disabled
 * - target: href target (when enabled only)
 * - tabindex: tabindex for the anchor
 *
 * TODO: review how to handle classes via the options parameter.  For example,
 * the daemon start/stop button passes special class information this way.
 *
 * @param string $url        URL
 * @param string $text       anchor text
 * @param string $importance importance of the button ('high' or 'low')
 * @param string $class      CSS class
 * @param array  $options    options
 *
 * @return HTML for anchor
 */

function theme_anchor($url, $text, $importance, $class, $options)
{
    // ID, target, tabindex
    $id = isset($options['id']) ? ' id=' . $options['id'] : '';
    $target = isset($options['target']) ? " target='" . $options['target'] . "'" : '';
    $tabindex = isset($options['tabindex']) ? " tabindex='" . $options['tabindex'] . "'" : '';

    // Do not escape HTML if requested
    if (!isset($options['no_escape_html']) || $options['no_escape_html'] == FALSE)
        $text = htmlspecialchars($text, ENT_QUOTES);

    // Additional classes
    $class = explode(' ', $class);

    // Data
    $data = '';
    if ((isset($options['data']))) {
        foreach ($options['data'] as $key => $value)
            $data .= "data-$key='$value' ";
        $data = trim($data);
    }

    $target = '';
    if (isset($options['target'])) {
        $target = " target='" . $options['target'] . "'";
        if ($options['target'] == '_blank')
            $text .= "<i class='fa fa-external-link theme-text-icon-spacing'></i>";
    }
    $tabindex = isset($options['tabindex']) ? " tabindex='" . $options['tabindex'] . "'" : '';
    if (isset($options['class']))
        $class = array_merge($class, explode(' ', $options['class']));

    // Hide and disabled options
    if (isset($options['hide']))
        $class[] = 'theme-hidden';

    if (isset($options['disabled']))
        $class[] = 'disabled';

    // Button importance
    if ($importance === 'high' || $importance === 'important')
        $importance = 'btn btn-primary';
    else if ($importance === 'low')
        $importance = 'btn btn-secondary';
    else if ($importance === 'link-only')
        $importance = '';
    else
        $importance = 'btn btn-link';

    $class[] = $importance;

    // TODO: do we ever use state = disabled?
    if (isset($options['state']) && ($options['state'] === FALSE)) {
        return  "<input disabled $data type='submit' name='' $id value='$text' class='" . implode(' ' , $class) . "' $tabindex />\n";
    } else {

        // Multi-select button
        if (is_array($url)) {
            $url_text = '';

            // TODO: many of the options above are not yet implemented
            foreach($url as $item_url => $item_text)
                $url_text .= "<li><a href='$item_url' $data>$item_text</a></li>";

            return "
            <div class='btn-group'>
              <button type='button' class='btn btn-primary'>$text</button>
              <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
                <span class='caret'></span>
                <span class='sr-only'>Toggle Dropdown</span>
              </button>
              <ul class='dropdown-menu dropdown-menu-right' role='menu'>
                $url_text
              </ul>
            </div>
            ";
        } else {
            return "<a href='$url'$id class='" . implode(' ', $class) . "'$target$tabindex $data>$text</a>";
        }
    }
}

/**
 * Submit button widget.
 *
 * Supported options:
 * - id
 *
 * Classes:
 * - theme-form-add
 * - theme-form-delete
 * - theme-form-disable
 * - theme-form-next
 * - theme-form-ok
 * - theme-form-previous
 * - theme-form-update
 * - theme-form-custom (button with custom text)
 *
 * Options:
 * - state: enabled/disabled
 * - tabindex: tabindex for the button
 *
 * @param string $name       button name,
 * @param string $text       text to be shown on the anchor
 * @param string $importance prominence of the button
 * @param string $class      CSS class
 * @param array  $options    options
 *
 * @return HTML for button
 */

function theme_form_submit($name, $text, $importance, $class, $options)
{
    $importance_class = ($importance === 'high' || $importance === 'important') ? 'btn-primary' : 'btn-secondary';

    $id = isset($options['id']) ? ' id=' . $options['id'] : '';
    $text = htmlspecialchars($text, ENT_QUOTES);
    $tabindex = isset($options['tabindex']) ? " tabindex='" . $options['tabindex'] . "'" : '';
    $hidden = isset($options['hide']) ? ' theme-hidden' : '';
    $disabled = (isset($options['disabled']) && $options['disabled']) ? " disabled='disabled'" : "";

    return "<input type='submit' name='$name'$id value='$text' class='btn $class $hidden $importance_class$tabindex' $disabled/>\n";
}

///////////////////////////////////////////////////////////////////////////////
// A N C H O R  A N D  B U T T O N  S E T S
///////////////////////////////////////////////////////////////////////////////

/**
 * Button set.
 *
 * Supported options:
 * - id
 *
 * @param array  $buttons list of buttons in HTML format
 * @param array  $options options
 * @param string $type    button set type
 *
 * @return string HTML for button set
 */

function theme_button_set($buttons, $options = array())
{
    return _theme_button_set($buttons, $options, 'normal');
}

/**
 * Field button set.
 *
 * This is the same as a button set, but used in a form with fields.
 *
 * Supported options:
 * - id
 *
 * @param array  $buttons list of buttons in HTML format
 * @param array  $options options
 *
 * @return string HTML for field button set
 */

function theme_field_button_set($buttons, $options = array())
{
    return _theme_button_set($buttons, $options, 'field');
}

/**
 * Internal button set handler.
 *
 * Supported options:
 * - id
 *
 * @param array  $buttons list of buttons in HTML format
 * @param array  $options options
 * @param string $type    button set type
 *
 * @access private
 * @return string HTML for button set
 */

function _theme_button_set($buttons, $options = NULL, $type = NULL)
{
    $id = isset($options['id']) ? " id='" . $options['id'] . "'" : "";
    $class = isset($options['class']) ? " " . $options['class'] : "";

    $button_html = '';

    $button_total = count($buttons);
    $count = 0;

    foreach ($buttons as $button)
        $button_html .= $button . "\n";

    if ($type === 'field') {
        return "<div class='btn-group$class'$id>$button_html</div>";
    } else {
        return "<div class='btn-group$class'$id>$button_html</div>";
    }
}

///////////////////////////////////////////////////////////////////////////////
// F I E L D S
///////////////////////////////////////////////////////////////////////////////

/**
 * Field set header.
 *
 * @param string $title   title
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_fieldset_header($title, $options)
{
    $id = isset($options['id']) ? ' id=' . $options['id'] : '';

    return "<div $id class='theme-form-header'>$title</div>";
}

/**
 * Field set footer.
 *
 * @return string HTML
 */

function theme_fieldset_footer()
{
    return '';
}

/**
 * Displays a single block of text instead of showing a field/value pair.
 *
 * @param string $text     text shown
 * @param array  $options  options
 *
 * @return string HTML for field view
 */

function theme_field_banner($text, $options = NULL)
{
    return "
        <div class='theme-fieldview'>
            $text
        </div>
    ";
}

/**
 * Checkbox field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of checkbox element
 * @param string $value    value of checkbox
 * @param string $label    label for checkbox field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_checkbox($name, $value, $label, $error, $input_id, $options)
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';

    $select_html = ($value) ? ' checked' : '';

    $add_classes = '';
    if (isset($options['class'])) {
        if (is_array($options['class']))
            $add_classes = implode(' ', $options['class']);
        else
            $add_classes = explode(' ', $options['class']);
    }

    return "
        <div id='$field_id_html' class='form-group theme-field-checkboxes $hide_field'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right'>
                <input type='checkbox' name='$name' id='$input_id' class='form-control theme-control-no-border $add_classes' $select_html value='1'>
            </div>
        </div>
    ";
}

/**
 * Text color input field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of text input element
 * @param string $value    value of text input
 * @param string $label    label for text input field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_color($name, $value, $label, $error, $input_id, $options = NULL)
{
    return _theme_field_common($name, $value, $label, $error, $input_id, $options, 'text');
}

/**
 * Dropdown field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of dropdown element
 * @param string $value    value of dropdown
 * @param string $label    label for dropdown field
 * @param string $error    validation error message
 * @param array  $values   hash list of values for dropdown
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_dropdown($name, $value, $label, $error, $values, $input_id, $options)
{
    $input_id_html = " id='" . $input_id . "'";
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $add_classes = '';
    if (isset($options['class'])) {
        if (is_array($options['class']))
            $add_classes = implode(' ', $options['class']);
        else
            $add_classes = explode(' ', $options['class']);
    }

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    if (isset($options['no-field']))
        return form_dropdown($name, $values, $value, "class='form-control theme-no-field theme-dropdown $add_classes'$input_id_html") . " $error_html";
    else
        return "
            <div id='$field_id_html' class='form-group theme-field-dropdown'>
                <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
                <div class='col-sm-7 theme-field-right'>" .
                    form_dropdown($name, $values, $value, "class='form-control theme-dropdown $add_classes'$input_id_html") . " $error_html
                </div>
            </div>
        ";
}

/**
 * File upload input field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of text input element
 * @param string $value    value of text input
 * @param string $label    label for text input field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_file($name, $value, $label, $error, $input_id, $options = NULL)
{
    return _theme_field_common($name, $value, $label, $error, $input_id, $options, 'file');
}

/**
 * Display an info line in a form.
 *
 * @param string $id      HTML ID
 * @param string $label   label
 * @param string $text    text
 * @param array  $options options
 *
 * @return string HTML output
 */

function theme_field_info($id, $label, $text, $options = NULL)
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $id . '_label';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';

    return "
        <div id='$field_id_html' class='form-group theme-field-info" . $hide_field . "'>
            <label class='col-sm-5 control-label' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right'><span class='form-control'>$text</span></div>
        </div>
    ";
}

/**
 * Text input field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of text input element
 * @param string $value    value of text input
 * @param string $label    label for text input field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_input($name, $value, $label, $error, $input_id, $options = NULL)
{
    return _theme_field_common($name, $value, $label, $error, $input_id, $options, 'text');
}

/**
 * Multi-select dropdown field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string  $name     name of dropdown element
 * @param string  $value    value of dropdown
 * @param string  $label    label for dropdown field
 * @param string  $error    validation error message
 * @param array   $values   hash list of values for dropdown
 * @param string  $input_id input ID
 * @param array   $options  options
 *
 * @return string HTML
 */

function theme_field_multiselect_dropdown($name, $value, $label, $error, $values, $input_id, $options)
{
    $input_id_html = " id='" . $input_id . "'";
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $add_classes = '';
    if (isset($options['class'])) {
        if (is_array($options['class']))
            $add_classes = implode(' ', $options['class']);
        else
            $add_classes = explode(' ', $options['class']);
    }

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    return "
        <div id='$field_id_html' class='form-group theme-multiselect-dropdown'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right'>" . form_multiselect($name, $values, $value, "class='form-control theme-dropdown $add_classes'$input_id_html") . " $error_html</div>
        </div>
    ";
}

/**
 * Password input field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of pasword input element
 * @param string $value    value of pasword input
 * @param string $label    label for pasword input field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_password($name, $value, $label, $error, $input_id, $options = NULL)
{
    return _theme_field_common($name, $value, $label, $error, $input_id, $options, 'password');
}

/**
 * Text area field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of text area element
 * @param string $value    value of text area
 * @param string $label    label for text area field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_textarea($name, $value, $label, $error, $input_id, $options = NULL)
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    $add_classes = '';
    if (isset($options['class'])) {
        if (is_array($options['class']))
            $add_classes = implode(' ', $options['class']);
        else
            $add_classes = explode(' ', $options['class']);
    }

    if (isset($options['no_label'])) {
        return "
            <div id='$field_id_html' class='form-group theme-field-textarea" . $hide_field . "'>
                <div class='col-sm-12 theme-field-right theme-field-textarea-box'>
                  <textarea name='$name' id='$input_id' class='form-control $add_classes'>$value</textarea>$error_html
                </div>
                <label class='control-label' for='$input_id' id='$label_id_html'></label>
            </div>
        ";
    } else {
        return "
            <div id='$field_id_html' class='form-group theme-field-textarea" . $hide_field . "'>
                <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
                <div class='col-sm-7 theme-field-right theme-field-textarea-box'>
                  <textarea name='$name' id='$input_id' class='form-control $add_classes'>$value</textarea>$error_html
                </div>
            </div>
        ";
    }
}

/**
 * Enable/disable toggle field.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @param string $name     name of toggle input element
 * @param string $value    value of toggle input
 * @param string $label    label for toggle input field
 * @param string $error    validation error message
 * @param array  $values    hash list of values for dropdown
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_field_toggle_enable_disable($name, $selected, $label, $error, $values, $input_id, $options)
{
    $input_id_html = " id='" . $input_id . "'";
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $add_classes = '';

    if (isset($options['class'])) {
        if (is_array($options['class']))
            $add_classes = implode(' ', $options['class']);
        else
            $add_classes = explode(' ', $options['class']);
    }

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    return "
        <div id='$field_id_html' class='form-group theme-field-toggle'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right'>" .
            form_dropdown($name, $values, $selected, "class='form-control theme-dropdown $add_classes'$input_id_html") . " $error_html
            </div>
        </div>
    ";
}

/**
 * Input field in view-only mode.
 *
 * Supported options:
 * - field_id
 * - label_id
 *
 * @param string $label    label for text input field
 * @param string $text     text shown
 * @param string $name     name of text input element
 * @param string $value    value of text input
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML for field view
 */

function theme_field_view($label, $text, $name = NULL, $value = NULL, $input_id = NULL, $options = NULL)
{
    if (is_null($input_id))
        $input_id = 'clearos_' . mt_rand();

    if (is_null($name))
        $name = 'clearos_' . mt_rand();

    if (is_null($value))
        $value = '';

    $is_bool = '';
    if (is_bool($text)) {
        $is_bool = ' theme-control-no-border';
        // TODO FIXME
        if ($text)
            $text = "<label><i class='fa fa-check-circle'></i></label>";
        else
            $text = '-';
    }
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $text_id_html = (isset($options['text_id'])) ? $options['text_id'] : $input_id . '_text';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';

    $input_html = "<input class='hidden' name='$name' value='$value' id='$input_id'>";

    // TODO - CSS hacks below for
    if (isset($options['color-picker']) && $options['color-picker']) {
        return "
            <div id='$field_id_html' class='form-group theme-fieldview" . $hide_field . "'>
                <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
                <div class='input-group my-colorpicker2 colorpicker-element col-sm-7 theme-field-right'>
                    <span class='form-control' id='$text_id_html'>$text</span>$input_html
                    <div class='input-group-addon'></div>
                </div>
            </div>
        ";
    } else if (isset($options['no_label']) && $options['no_label']) {
        return "
            <div id='$field_id_html' class='form-group theme-fieldview" . $hide_field . "'>
                <div class='col-sm-12 theme-field-right'><span class='form-control$is_bool' id='$text_id_html'>" . preg_replace("/\n/", "<br>", $text) . "</span>$input_html</div>
                <label class='control-label' for='$input_id' id='$label_id_html'></label>
            </div>
        ";
    } else {
        return "
            <div id='$field_id_html' class='form-group theme-fieldview" . $hide_field . "'>
                <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
                <div class='col-sm-7 theme-field-right'><span class='form-control$is_bool' id='$text_id_html'>" . preg_replace("/\n/", "<br>", $text) . "</span>$input_html</div>
            </div>
        ";
    }
}

/**
 * Common field input function.
 *
 * Supported options:
 * - field_id
 * - label_id
 * - error_id
 *
 * @access private
 * @param string $name     name of text input element
 * @param string $value    value of text input
 * @param string $label    label for text input field
 * @param string $error    validation error message
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML
 */

function _theme_field_common($name, $value, $label, $error, $input_id, $options = NULL, $type)
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';
    $placeholder = (isset($options['placeholder'])) ? " placeholder='" . $options['placeholder'] . "'" : '';
    $style = '';

    if (isset($options['width']))
        $style .= "style='width: " . $options['width'] . ";'";

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    $div_class = '';

    if (isset($options['color-picker']) && $options['color-picker'])
        $div_class = ' my-colorpicker';

    return "
        <div id='$field_id_html' class='form-group theme-field-$type" . $hide_field . "'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right" . $div_class . "'>
                <div" . ((isset($options['color-picker']) && $options['color-picker']) ? " class='input-group' " : "") . ">
                    <input type='$type' name='$name' " . ($type == 'file' ? "" : "value='$value'") . " id='$input_id' $style class='form-control'" . $placeholder . "> $error_html
                " . ((isset($options['color-picker']) && $options['color-picker']) ? "
                    <div class='input-group-addon'>
                        <i></i>
                    </div>
                " : "") . "
                </div>
            </div>
        </div>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// F I E L D  R A D I O  S E T S
///////////////////////////////////////////////////////////////////////////////

/**
 * Display radio sets.
 *
 * Supported options:
 * - id
 *
 * @param string $label    label
 * @param array  $radios   list of radios in HTML format
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML for field radio set
 */

function theme_field_radio_set($label, $radios, $input_id, $options = array())
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';

    $radio_text = '';

    if ($options['orientation'] == 'horizontal')
        $radio_text .= "";

    foreach ($radios as $radio) {
        $radio_text .= $radio;
    }

    if ($options['orientation'] == 'horizontal')
        $radio_text .= '';

    return "
        <div id='$field_id_html' class='form-group theme-field-radio-set" . $hide_field . "'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right theme-field-radio-set'>$radio_text$error_html</div>
        </div>
    ";
}

/**
 * Return radio set items.
 *
 * @param string $name      name of text input element
 * @param string $group     button group
 * @param string $label     label for text input field
 * @param string $checked   checked flag
 * @param string $read_only read only flag
 * @param array  $options   options
 *
 */

function theme_field_radio_set_item($name, $group, $label, $checked, $error, $input_id, $options)
{
    return _theme_radio_set_item($name, $group, $label, $checked, $error, $input_id, $options, 'field');
}

/**
 * Display radio sets.
 *
 * Supported options:
 * - id
 *
 * @param array  $radios       list of radios in HTML format
 * @param string $input_id     input ID
 * @param array  $options      options
 *
 * @return string HTML for field radio set
 */

function theme_radio_set($radios, $input_id, $options = array())
{
    if (isset($options['hide_field']))
        $classes[] = 'theme-hidden';
    if (isset($options['vertical']))
        $classes[] = 'btn-group-vertical';
    if (isset($options['buttons']))
        $classes[] = 'btn-group';

    $radio_text = '';

    foreach ($radios as $radio)
        $radio_text .= $radio;

    return "
        <div id='$input_id' class='" . implode(' ', $classes) . "' " . (in_array('btn-group', $classes) ? "data-toggle='buttons'" : "") . ">
            $radio_text
        </div>
    ";
}

/**
 * Return radio set items.
 *
 * @param string $name      name of text input element
 * @param string $group     button group
 * @param string $label     label for text input field
 * @param string $checked   checked flag
 * @param string $read_only read only flag
 * @param array  $options   options
 *
 */

function theme_radio_set_item($name, $group, $label, $checked, $input_id, $options)
{
    return _theme_radio_set_item($name, $group, $label, $checked, NULL, $input_id, $options, 'normal');
}

/**
 * Return radio set items.
 *
 * @param string $name      name of text input element
 * @param string $group     button group
 * @param string $label     label for text input field
 * @param string $checked   checked flag
 * @param string $read_only read only flag
 * @param array  $options   options
 *
 */

function _theme_radio_set_item($name, $group, $label, $checked, $error, $input_id, $options, $type)
{
    $input_id_html = " id='" . $input_id . "'";
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';
    $select_html = ($checked) ? ' checked' : '';
    $class = (isset($options['class'])) ? ' ' . $options['class'] : '';
    $buttons_class = (isset($options['buttons'])) ? 'btn btn-default' : '';

    $error_html = (empty($error)) ? "" : "<span class='theme-validation-error' id='$error_id_html'>$error</span>";

    $image = ($options['image']) ? "<img src='" . $options['image'] . "' alt='' style='margin: 5px'>" : '';
    $label_help = ($options['label_help']) ? $options['label_help'] : '';

    $disabled = (isset($options['disabled']) && $options['disabled']) ? " disabled='disabled'" : "";
    $input = "<input type='radio' name='$group' id='$input_id' value='$name' $select_html $disabled>";

    if ($options['orientation'] == 'horizontal') {
        if ($type == 'field') {
            return "
                <div id='$field_id_html' style='float: left;'>$image<label for='$input_id' id='$label_id_html'>$label</label>$input</div>
            ";
        } else {
            return "<label class='$buttons_class $class' id='$label_id_html'>$input$label</label>";
        }
    } else {
        if ($type == 'field') {
            return "
                <div id='$field_id_html'>
                    $input<span for='$input_id' id='$label_id_html'>$label</span>$label_help
                    $image
                </div>
            ";
        } else {
            if (isset($image)) {
                $html = theme_row_open() .
                    theme_column_open(7) .
                    "<div class='theme-radioset'>
                    $input<label class='$buttons_class $class' id='$label_id_html'>$label</label><p>$label_help</p>
                    </div>" .
                    theme_column_close() .
                    theme_column_open(5) . $image . theme_column_close() .
                    theme_row_close()
                ;
                return $html;
            } else {
                return "<label class='$buttons_class $class' id='$label_id_html'>$input$label</label>";
            }
        }
    }
}

///////////////////////////////////////////////////////////////////////////////
// F I E L D  S L I D E R S
///////////////////////////////////////////////////////////////////////////////

/**
 * Display a slider as part of a form field.
 *
 * @param string $label   form field label
 * @param string $id      HTML ID
 * @param int    $value   value
 * @param int    $min     minimum
 * @param int    $max     maximum
 * @param int    $step    step
 * @param array  $options options
 *
 * @return string HTML output
 */

function theme_field_slider($label, $id, $value, $min, $max, $step, $options)
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $id . '_label';

    return "
        <div id='$field_id_html' class='form-group theme-field-info'>
            <label for='$id' id='$label_id_html' class='col-sm-5 control-label'>$label</label>
            <div class='col-sm-7 theme-field-right'>
                <div id='$id-container' style='padding-top: 7px;'>
                   <input type='text' id='$id' value='' class='slider form-control' data-slider-min='$min' data-slider-max='$max' data-slider-step='$step' data-slider-value='$value' data-slider-orientation='horizontal' data-slider-selection='before' data-slider-tooltip='show' data-slider-id='red'>
                </div>
            </div>
        </div>
        <script type='text/javascript'>
          $(function() {
            $('#$id-container input').slider();
          });
        </script>
    ";
}

/**
 * Display field slider set.
 *
 * @param array  $sliders  list of sliders in HTML format
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML for field slider set
 */

function theme_field_slider_set($sliders, $input_id, $options = array())
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $input_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $input_id . '_label';
    $error_id_html = (isset($options['error_id'])) ? $options['error_id'] : $input_id . '_error';

    if (isset($options['hide_field']))
        $classes[] = 'theme-hidden';

    $slider_text = '';

    foreach ($sliders as $slider)
        $slider_text .= $slider;

    return "
        <div id='$field_id_html' class='form-group theme-field-slider-set" . $hide_field . "'>
            <label class='col-sm-5 control-label' for='$input_id' id='$label_id_html'>$label</label>
            <div class='col-sm-7 theme-field-right theme-field-slider-set'>$slider_text$error_html</div>
        </div>
    ";
}

/**
 * Display slider set.
 *
 * @param array  $sliders  list of sliders in HTML format
 * @param string $input_id input ID
 * @param array  $options  options
 *
 * @return string HTML for field slider set
 */

function theme_slider_set($sliders, $input_id, $options = array())
{
    $col_start = '';
    $col_end = '';
    if (isset($options['hide_field']))
        $classes[] = 'theme-hidden';

    if (isset($options['use_columns'])) {
        $col_start = "<div class='col-sm-" . $options['use_columns'] . "'>";
        $col_end = "</div>";
    }

    $slider_text = '';

    foreach ($sliders as $slider)
        $slider_text .= $col_start . $slider . $col_end;

    if (isset($options['use_columns']) && count($sliders) < 12) {
        $slider_text .= "<div class='col-sm-" . (12 - count($sliders)) . "'></div>";
    }
    return "
        <div id='$input_id' class='form-group clearfix'>
            $slider_text
        </div>
        <script type='text/javascript'>
          $(function() {
            $('#$input_id input').slider();
          });
        </script>
    ";
}

/**
 * Return slider set item.
 *
 * @param string $input_id    input ID
 * @param int    $value       value
 * @param int    $min         minimum
 * @param int    $max         maximum
 * @param int    $step        step
 * @param string $orientation orientation
 * @param array  $options     options
 *
 */

function theme_slider_set_item($input_id, $value, $min, $max, $step, $orientation, $options)
{
    return "
       <input type='text' value='' class='slider form-control' data-slider-min='$min' data-slider-max='$max' data-slider-step='$step' data-slider-value='$value' data-slider-orientation='$orientation' data-slider-selection='before' data-slider-tooltip='show' data-slider-id='red'>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// P R O G R E S S  B A R S
///////////////////////////////////////////////////////////////////////////////

/**
 * Display a progress bar as part of a form field.
 *
 * Supported options:
 * - field_id
 * - label_id
 *
 * @param string $label   form field label
 * @param string $id      HTML ID
 * @param array  $options options
 *
 * @return string HTML for text input field
 */

function theme_field_progress_bar($label, $id, $options = array())
{
    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $id . '_label';
    $value = (isset($options['value'])) ? $options['value'] : 0;

    return "
        <div id='$field_id_html' class='form-group theme-field-info'>
            <label id='$label_id_html' class='col-sm-5 control-label'>$label</label>
            <div class='col-sm-7 theme-field-right'>
                <div id='$id-container' class='progress progress-sm'>
                  <div id='$id' class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$value' aria-valuemin='0' aria-valuemax='100' style='width: $value%;'></div>
                </div>
            </div>
        </div>
    ";
}

/**
 * Display a progress bar as standalone entity.
 *
 * @param string $id      HTML ID
 * @param array  $options options
 *
 * @return string HTML output
 */

function theme_progress_bar($id, $options)
{
    $value = (isset($options['value'])) ? $options['value'] : 0;
    $height = (isset($options['height'])) ? "style='height: " . $options['height'] . "px; margin-bottom: 5px'" : "";
    $no_animation = (isset($options['no_animation']) && $options['no_animation']) ? ' theme-progress-bar-no-animation' : '';
    return "<div id='$id-container' class='progress progress-sm' $height>\n" .
           "   <div id='$id' class='progress-bar progress-bar-success$no_animation' " .
           " role='progressbar' aria-valuenow='$value' aria-valuemin='0' aria-valuemax='100' style='width: $value%;'></div>" .
           "</div>\n"
    ;
}

///////////////////////////////////////////////////////////////////////////////
// L O G I N  F O R M
///////////////////////////////////////////////////////////////////////////////

function theme_login_form($redirect, $languages, $lang, $errmsg, $options = NULL)
{
    $ip = (empty($options['ip'])) ? '' : " @ " . $options['ip'] . "";

    echo "<div class='login_box'>";
    echo "  <div class='login_left'><div class='login_logo'> <i class='ci-ClearOS'></i></div>";
    echo "</div>";
    echo "<div class='login_right'>";
    echo "  <div class='title'>" . lang('base_login') . "$ip</div>";
    echo form_open('base/session/login/' . $redirect);
    echo field_input('clearos_username', '', "<i class='fa fa-user'></i> " . lang('base_username'));
    echo field_password('clearos_password', '', "<i class='fa fa-lock'></i> " . lang('base_password'));

    if (count($languages) > 1)
        echo field_dropdown('code', $languages, $lang, "<i class='fa fa-language'></i> " . lang('base_language'));


    echo theme_field_button_set(
        array(form_submit_custom('submit', lang('base_login'), 'high'))
    );

    if ($errmsg)
        echo "<div class='theme-validation-error'>$errmsg</div>";

    echo form_close();
    echo "  </div>";
    echo "</div>";
}

///////////////////////////////////////////////////////////////////////////////
// F O R M S
///////////////////////////////////////////////////////////////////////////////

/**
 * Set class in form for custom styling.
 *
 * @param array  $options    options
 *
 * @return string HTML
 */

function theme_form_classes($options = array())
{
    $classes = array();
    if (empty($options)) {
        $classes[] = 'form-horizontal';
    } else if (isset($options['class'])) {
        if (is_array($options['class']))
            $classes = $options['class'];
        else
            $classes = preg_split('/\s+/', $options['class']);
    }
    return $classes;
}

/**
 * Form Open.
 *
 * @param string $action     action
 * @param string $attributes attributes
 * @param array  $hidden     hidden
 * @param array  $options    options
 *
 * @return string HTML
 */

function theme_form_open($action = '', $attributes = '', $hidden = array(), $options = array())
{
    return my_form_open($action, $attributes, $hidden, $options);
}

/**
 * Form banner.
 *
 * Supported options:
 * - id
 *
 * @param string $html    html payload
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_form_banner($html, $options)
{
    $id_html = (isset($options['id'])) ? " id='" . $options['id'] . "'" : '';

    return "<p $id_html>$html</p>";
}

/**
 * Form footer.
 *
 * Supported options:
 * - loading
 * - buttons
 *
 * @param array $options options
 *
 * @return string HTML
 */

function theme_form_footer($options)
{
    $loading = '';
    $buttons = '';
    if (isset($options['loading']))
        $loading = "
            <div class='overlay clearos-loading-overlay'></div>
            <div class='theme-form-loading clearos-loading-overlay'>" .
                theme_loading('1.25em', lang('base_loading...'), array('icon-below' => TRUE)) . "
            </div>
        ";
    if (isset($options['buttons']))
        $buttons = theme_button_set($options['buttons']);

    return "
                </div>
                <div class='box-footer text-right'>$buttons</div>
                $loading
            </div>
    ";
}

/**
 * Form header.
 *
 * Supported options:
 * - id
 *
 * @param string $title form title
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_form_header($title, $options)
{
    $id_html = (isset($options['id'])) ? $options['id'] : 'options_' . rand(0, 1000);
    $status_id_html = (isset($options['id'])) ? "status_" . $options['id'] : 'status_options_' . rand(0, 1000);

    return "
        <div class='box box-primary' id='$id_html'>
            " . ($title != NULL ? "
            <div class='box-header'>
                <h3 class='box-title'>$title</h3>
            </div>
            " : "") . "
            <div class='box-body'>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// S I D E B A R  W I D G E T
///////////////////////////////////////////////////////////////////////////////

/**
 * Sidebar banner.
 *
 * Supported options:
 * - id
 *
 * @param string $html    html payload
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_sidebar_banner($html, $options)
{
    $id_html = (isset($options['id'])) ? " id='" . $options['id'] . "'" : '';

    return "
        <tr class='theme-form-header'$id_html>
            <td colspan='2' class='theme-form-banner'>$html</td>
        </tr>
    ";
}

/**
 * Sidebar footer.
 *
 * @return string HTML
 */

function theme_sidebar_footer()
{
    return "</table>";
}

/**
 * Sidebar header.
 *
 * Supported options:
 * - id
 *
 * @param string $title form title
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_sidebar_header($title, $options)
{
    $id_html = (isset($options['id'])) ? " id='" . $options['id'] . "'" : '';
    $status_id_html = (isset($options['id'])) ? " id='status_" . $options['id'] . "'" : '';

    if (isset($options['id'])) {
        return "<table border='0' cellpadding='0' cellspacing='0' class='theme-form-wrapper'$id_html>
            <tr class='theme-form-header'>
                <td><span class='theme-form-header-heading'>$title</span></td>
                <td align='right'><span class='theme-form-header-status' $status_id_html>&nbsp;</span></td>
            </tr>
        ";
    } else {
        return "<table border='0' cellpadding='0' cellspacing='0' class='theme-form-wrapper'$id_html>
            <tr class='theme-form-header'>
                <td colspan='2'><span class='theme-form-header-heading'>$title</span></td>
            </tr>
        ";
    }
}

/**
 * Sidebar key value.
 *
 * Supported options:
 * - id
 * - value_id
 *
 * @param string $value   value
 * @param string $label   label
 * @param string $base_id base ID
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_sidebar_value($value, $label, $base_id, $options)
{
    if (empty($base_id))
        $base_id = 'clearos_sidebar_' . mt_rand();

    $field_id_html = (isset($options['field_id'])) ? $options['field_id'] : $base_id . '_field';
    $label_id_html = (isset($options['label_id'])) ? $options['label_id'] : $base_id . '_label';
    $text_id_html = (isset($options['text_id'])) ? $options['text_id'] : $base_id . '_text';
    $hide_field = (isset($options['hide_field'])) ? ' theme-hidden' : '';
    $input_html = "<input type='hidden' name='$base_id' value='$value' id='$base_id'>";

    return "
        <tr id='$field_id_html' class='theme-fieldview" . $hide_field . "'>
            <td class='theme-field-left'><label for='$base_id' id='$label_id_html'>$label</label></td>
            <td class='theme-field-right'><span id='$text_id_html'>$value</span>$input_html</td>
        </tr>
    ";
}

/**
 * Sidebar text.
 *
 * Supported options:
 * - id
 *
 * @param string $html    html payload
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_sidebar_text($html, $options)
{
    $id_html = (isset($options['id'])) ? " id='" . $options['id'] . "'" : '';
    $align = (isset($options['align'])) ? " align='" . $options['align'] . "'" : '';

    return "
        <tr$id_html>
            <td colspan='2'$align>$html</td>
        </tr>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// C H A R T  W I D G E T
///////////////////////////////////////////////////////////////////////////////

/**
 * Chart widget.
 *
 * Supported options:
 * - id
 *
 * @param string $title   form title
 * @param string $payload payload
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_chart_container($title, $chart_id, $options)
{
    $id_html = (isset($options['id'])) ? " id='" . $options['id'] . "'" : '';

    $action = ($options['action']) ? $options['action'] : '';
    $footer_content = ($options['footer']) ? $options['footer'] : '';
    $size = 'theme-chart-medium';
    $override_size = '';
    $data = '';
    if ((isset($options['class']))) {
        // Additional classes
        if (is_array($options['class']))
            $class = $options['class'];
        else
            $class = explode(' ', $options['class']);
    }
    if ((isset($options['data']))) {
        foreach ($options['data'] as $key => $value)
            $data .= "data-$key='$value' ";
        $data = trim($data);
    }
    if (isset($options['chart-size'])) {
        if (preg_match('/^(\d+)x(\d+)$/', $options['chart-size'], $match)) {
            $override_size = "style='width: " . $match[1] . "px; height: " . $match[2] . "px;'";
            $size = '';
        } else if ($options['chart-size'] == 'tiny')
            $size = 'theme-chart-xs';
        else if ($options['chart-size'] == 'small')
            $size = 'theme-chart-small';
        else if ($options['chart-size'] == 'medium')
            $size = 'theme-chart-medium';
        else if ($options['chart-size'] == 'large')
            $size = 'theme-chart-large';
    }

    $loading = '';
    if (isset($options['loading']))
        $loading = "
            <div class='overlay clearos-loading-overlay'></div>
            <div class='theme-form-loading clearos-loading-overlay'>" .
                theme_loading('1.25em', lang('base_loading...'), array('icon-below' => TRUE)) . "
            </div>
        ";

    return "
        <div class='box theme-clear'$id_html>
          <div class='box-header'>
            <div class='theme-box-tools pull-right'>$action</div>
            <h3 class='box-title'>$title</h3>
          </div>
          <div class='box-body'><div class='theme-chart-container $size " . implode(' ', $class) . "' id='$chart_id' $override_size $data></div></div>
          <div class='box-footer'>$footer_content</div>
          $loading
        </div>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// T A B  V I E W
///////////////////////////////////////////////////////////////////////////////

/**
 * Tabular content.
 *
 * @param array $tabs tabs
 *
 * @return string HTML
 */

function theme_tab($tabs)
{
    $html = "<div id='tabs' class='ui-tabs ui-widget ui-widget-content'>\n
<div>\n
<ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header'>\n
    ";

    $tab_content = "";
    foreach ($tabs as $key => $tab) {
        $html .= "<li class='ui-state-default ui-corner-top'>
<a href='#tabs-" . $key . "'>" . $tab['title'] . "</a></li>\n";
        $tab_content .= "<div id='tabs-" . $key .
"' class='clearos_tabs ui-tabs ui-widget ui-widget-content'>" . $tab['content'] . "</div>";
    }
    $html .= "</ul>\n";
    $html .= $tab_content;
    $html .= "</div>\n";
    $html .= "</div>\n";
    $html .= "<script type='text/javascript'>
$(function(){
$('#tabs').tabs({
selected: 0
});
});
</script>";

    return $html;
}

///////////////////////////////////////////////////////////////////////////////
// L O A D I N G  I C O N
///////////////////////////////////////////////////////////////////////////////

/**
 * Loading/wait state in progress.
 *
 * @param string $size    size (small, normal)
 * @param string $text    text to display
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_loading($size, $text = '', $options = NULL)
{
    $id = '';
    $font_size = '';
    $center = '';
    $classes = '';

    if (isset($options['id']))
        $id = "id='" . $options['id'] . "'";
    if (isset($options['center']))
        $center = "theme-center-text";
    if (isset($options['class']))
        $classes = $options['class'];
    if (preg_match('/\d+em$/', $size)) {
        $font_size = "style='font-size: $size;'";
    } else if (preg_match('/\d+px$/', $size)) {
        $font_size = "style='font-size: $size;'";
    }

    if (isset($options['icon-below']))
        return "<div $id class='theme-loading-wrapper $center $classes'><div $font_size>$text</div><div $font_size><i class='fa fa-spinner fa-spin'></i></div></div>";
    elseif (isset($options['icon-above']))
        return "<div $id class='theme-loading-wrapper $center $classes'><i class='fa fa-spinner fa-spin'></i><div>$text</div></div>";
    else
        return "<div $id class='theme-loading-wrapper $classes'><i class='fa fa-spinner fa-spin' $font_size></i><span style='padding-left: 5px;' $font_size>$text</span></div>";
}

///////////////////////////////////////////////////////////////////////////////
// T A B L E S
///////////////////////////////////////////////////////////////////////////////

/**
 * Action table.
 *
 * @param string $title   table title
 * @param array  $items   items
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_action_table($title, $anchors, $items, $options = NULL)
{
    $action_col = FALSE;

    // Anchors
    //--------

    $add_html = (empty($anchors)) ? '&nbsp; ' : button_set($anchors);

    // Table ID
    //---------

    if (isset($options['id']))
        $dom_id = $options['id'];
    else
        $dom_id = 'tbl_id_' . rand(0, 1000);

    // Item parsing
    //-------------

    $item_html = '';

    foreach ($items as $item) {
        $item_html .= "\t<tr>\n";
        $item_html .= "\t\t<td>" . $item['title'] . "</td>\n";
        $item_html .= "\t\t<td class='table-buttonset-column'>" . button_set($item['anchors']) . "</td>\n";
        $item_html .= "\t</tr>\n";
    }

    // Action table
    //-------------

    $dom_id_var = preg_replace('/\./', '_', $dom_id);
    $dom_id_selector = preg_replace('/\./', '\\\\\\.', $dom_id);

    return "

<div class='box'>
  <div class='box-header'>
    <div class='theme-box-tools pull-right'>$add_html</div>
    <h3 class='box-title'>$title</h3>
  </div>
  <div class='box-body'>
    <table class='table table-striped' id='$dom_id'>
      <thead>
        <tr class='theme-hidden'>
          <th>Item</th>
          <th>Action</th>
         </tr>
      </thead>
     <tbody>
  $item_html
     </tbody>
    </table>
  </div>
</div>
<script type='text/javascript'>
  function get_table_$dom_id_var() {
    return $('#" . $dom_id_selector . "').dataTable({
                \"bJQueryUI\": true,
        \"bInfo\": false,
                \"bPaginate\": false,
                \"bFilter\": false,
                \"bSort\": false,
                \"sPaginationType\": \"full_numbers\"
    });
  }
  $(document).ready(function() {
    get_table_$dom_id_var();
  });
</script>
    ";
}

/**
 * Summary table.
 *
 * @param string $title   table title
 * @param array  $anchors list anchors
 * @param array  $headers headers
 * @param array  $items   items
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_summary_table($title, $anchors, $headers, $items, $options = NULL)
{
    $columns = count($headers) + 1;

    // Header parsing
    //---------------

    $first_column_fixed_sort = "[ 0, 'asc' ]";

    // Tabs are just for clean indentation HTML output
    $header_html = (isset($options['row-enable-disable']) ? '<th></th>' : '');
    $footer_html = $header_html;
    $empty_row = (isset($options['row-enable-disable']) ? '<td></td>' : '');
    $no_container = (isset($options['no_container']) ? TRUE : FALSE);

    foreach ($headers as $index => $header) {
        $responsive_class = '';
        if ($index == 0 && isset($options['grouping']) && $options['grouping'])
            $responsive_class = " class='never'";
        else if (isset($options['grouping']) && $options['grouping'])
            $responsive_class = " class='" . $options['responsive'][$index - 1] . "'";
        else if (isset($options['responsive']) && isset($options['responsive'][$index]))
            $responsive_class = " class='" . $options['responsive'][$index] . "'";
        $header_html .= "\n\t\t" . "<th$responsive_class>$header</th>";
        $footer_html .= "\n\t\t" . "<th><span style='display:none'>&nbsp;</span></th>";
        $empty_row .= '<td>&nbsp; </td>';
    }


    // Action column?
    $action_col = TRUE;
    if (isset($options['no_action']) && $options['no_action'])
        $action_col = FALSE;

    // No title in the action header
    if ($action_col) {
        $responsive_class = '';
        if (isset($options['responsive']) && isset($options['responsive'][$columns]))
            $responsive_class = " class='" . $options['responsive'][$columns] . "'";
        $header_html .= "\n\t\t" . "<th$responsive_class>" . (isset($options['action_header']) ? $options['action_header'] : lang('base_action')) . "</th>";
        $footer_html .= "\n\t\t" . "<th><span style='display:none'>&nbsp;</span></th>";
        $empty_row .= "<td>&nbsp; </td>";
    }

    // Anchors
    //--------

    if (is_array($anchors))
        $add_html = (empty($anchors)) ? '&nbsp; ' : button_set($anchors);
    else
        $add_html = $anchors;

    // Table ID (used for variable naming too)
    if (isset($options['id']))
        $dom_id = $options['id'];
    else
        $dom_id = 'tbl_' . preg_replace('/[^a-z0-9\-_:\.]/','', strtolower($title));

    // Item parsing
    //-------------

    if (empty($items)) {
        //Why do we have this empty row?  Messes up no data
        //$item_html = "<tr>\n$empty_row</tr>\n";
    } else {
        $item_html = '';

        foreach ($items as $item) {
            $item_html .= "\t<tr" . (isset($item['row_id']) ? " data-row-id='" . $item['row_id'] . "'" : '') . ">\n";
            if (isset($item['current_state']) && $item['current_state'] === TRUE) {
                $item_html .= "
                    <td>
                      <i class='theme-summary-table-entry-state theme-text-good-status fa fa-power-off'>
                        <span class='theme-hidden'>0</span>
                      </i>
                    </td>\n
                ";
            } else if (isset($item['current_state']) && $item['current_state'] === FALSE) {
                $item_html .= "
                    <td>
                      <i class='theme-summary-table-entry-state theme-text-bad-status fa fa-power-off'>
                        <span class='theme-hidden'>1</span>
                      </i>
                    </td>\n
                ";
            } else if (isset($options['row-enable-disable'])) {
                // Developer forgot to set enable/disable toggles in item array...need this to keep table td's in check
                $item_html .= "
                    <td>
                      <i class='theme-summary-table-entry-state fa fa-question'>
                        <span class='theme-hidden'>2</span>
                      </i>
                    </td>\n
                ";
            }

            foreach ($item['details'] as $value)
                $item_html .= "\t\t" . "<td>$value</td>\n";

            if ($action_col)
                $item_html .= "\t\t<td class='table-buttonset-column'>" . $item['anchors'] . "</td>";
            $item_html .= "\t</tr>\n";
        }
    }

    // Number of rows
    //---------------

    $default_rows = 10;

    // Show a reasonable number of entries
    if ((count($items) > 100) || (isset($options['paginate_large']) && $options['paginate_large'])) {
        $row_options = '[5, 10, 25, 50, 100, 200, 250, 500, -1], [5, 10, 25, 50, 100, 200, 250, 500, "' . lang('base_all') . '"]';
    } else {
        if ($default_rows >= 100)
            $default_rows = 100;

        // If we're using server side processing (eg. expecting large tables) disable 'all' option in number of rows to show.
        // It can/will crush UI experience if there's hundreds of thousands of records
        if (isset($options['ajax']))
            $row_options = '[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]';
        else
            $row_options = '[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "' . lang('base_all') . '"]';
    }

    // Page specified...don't guess.
    if (!empty($options['default_rows']))
        $default_rows = $options['default_rows'];

    // Size
    //-----

    if (isset($options['table_size']))
        $size_class = ($options['table_size'] == 'large') ? 'theme-summary-table-large' : 'theme-summary-table-small';
    else
        $size_class = 'theme-summary-table-large';

    // Paginate
    // --------

    if (isset($options['paginate'])) {
        $paginate = $options['paginate'];
    } else {
        $paginate = FALSE;
        if ((count($items) > 10) || (isset($options['paginate']) && $options['paginate']))
            $paginate = TRUE;
    }

    // Filter
    // ------

    $filter = FALSE;
    if ((count($items) > 10) || (isset($options['filter']) && $options['filter']))
        $filter = TRUE;

    // Server side processing
    // ----------------------
    $server_side = '';
    if (isset($options['ajax'])) {
        $server_side = "'processing': true,\n\t\t'serverSide': true,\n\t\t'ajax': '" . $options['ajax'] . "', 'autoWidth': false,";
        $paginate = TRUE;
        $filter = TRUE;
    }

    // Empty table
    if (isset($options['empty_table_message']))
        $empty_table = "
            \"sEmptyTable\": \"" . $options['empty_table_message'] . "\"
        ";
    else
        $empty_table = '';

    // Sort
    //-----

    $sort = TRUE;
    if (isset($options['sort']) && !$options['sort'])
        $sort = FALSE;
    $sorting_cols = '"bSortable": false, "aTargets": [ ' . ($action_col ? '-1' : '') . ' ]';

    if (isset($options['sort']) && is_array($options['sort']))
                $sorting_cols = '"bSortable": false, "aTargets": [ ' . implode(',', $options['sort']) . ' ]';

    // Sorting type option
    // This is a pretty big hack job...pretty tough to expose all the functionality datatables have
    $sorting_type = '';
    if (isset($options['sorting-type'])) {
        $sorting_type = "\"columns\": [\n";

        foreach ($options['sorting-type'] as $s_type) {
            if ($s_type == NULL) {
                $sorting_type .= "              null,\n";
            } else {
                // Map int/string/ip to datables values
                if ($s_type == 'int')
                    $datatables_type = 'num';
                else if ($s_type == 'float')
                    $datatables_type = 'num';
                else if ($s_type == 'date')
                    $datatables_type = 'date';
                else if ($s_type == 'string')
                    $datatables_type = 'string';
                else if ($s_type == 'title-numeric')
                    $datatables_type = 'title-numeric';
                else
                    $datatables_type = 'html';

                $sorting_type .= "              {\"type\": \"" . $datatables_type . "\"},\n";
            }
        }

        // IE8 - strip off trailing comma (sigh)
        $sorting_type = preg_replace("/,\n$/", "\n", $sorting_type);

        $sorting_type .= "          ],";
    }

    $row_reorder = '';
    if (isset($options['row-reorder']))
        $row_reorder = '.rowReordering()';

    $col_widths = '';
    if (isset($options['col-widths'])) {
        $col_widths .= "\"columns\": [\n";
        foreach ($options['col-widths'] as $width)
            $col_widths .= "{ 'width': " . ($width == NULL ? "null" : "'$width'") . "},\n";
        $col_widths .= "],\n";
    }

    // Default sort
    if (isset($options['sort-default-col'])) {
        if (isset($options['sort-default-dir']))
            $first_column_fixed_sort = "[ " . $options['sort-default-col'] . ", '" . $options['sort-default-dir'] . "' ]";
        else
            $first_column_fixed_sort = "[ " . $options['sort-default-col'] . ", 'asc' ]";
    }

        // Grouping
        //---------

        if (isset($options['grouping']) && $options['grouping']) {
                $first_column_visible = 'false';
                $first_column_fixed_sort = "[ 0, 'asc' ]";
                $group_javascript = "
        \"fnDrawCallback\": function ( oSettings ) {
            if ( oSettings.aiDisplay.length == 0 )
            {
                return;
            }

            var nTrs = $('#$dom_id tbody tr');
            var iColspan = nTrs[0].getElementsByTagName('td').length;
            var sLastGroup = \"\";
            for ( var i=0 ; i<nTrs.length ; i++ )
            {
                var iDisplayIndex = oSettings._iDisplayStart + i;
                var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
                if ( sGroup != sLastGroup )
                {
                    var nGroup = document.createElement( 'tr' );
                    var nCell = document.createElement( 'td' );
                    nCell.colSpan = iColspan;
                    nCell.className = \"clearos-list-grouping\";
                    nCell.innerHTML = sGroup;
                    nGroup.appendChild( nCell );
                    nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
                    sLastGroup = sGroup;
                }
            }
        },
                ";
        } else {
                $first_column_visible = 'true';
                $group_javascript = '';
        }

    // Summary table
    //--------------

    // FIXME: dom IDS with periods are valid, but some massaging is required.
    // Implement below in other places.
    $dom_id_var = preg_replace('/\.|-/', '_', $dom_id);
    $dom_id_selector = preg_replace('/\./', '\\\\\\.', $dom_id);

    return "
<div class='box'>
  <div class='box-header'>
    <div class='theme-box-tools pull-right'>$add_html</div>
    <h3 class='box-title'>$title</h3>
  </div>
  <div class='box-body'>
    <table class='table table-striped $size_class " . (isset($options['responsive']) && $options['responsive'] == 'disabled' ? '' : 'my-responsive') . "' id='$dom_id'>
      <thead>
        <tr>$header_html</tr>
      </thead>
      <tbody>
        $item_html
      </tbody>
      <tfoot>$footer_html</tfoot>
    </table>
  </div>
</div>
<script type='text/javascript'>
  var responsive_layout = '" . (isset($options['responsive']) && $options['responsive'] == 'disabled' ? 'false' : 'true') . "';
  function get_table_$dom_id_var() {
    // Remove responsiveness??
    if (typeof(Storage) !== 'undefined') {
        if (localStorage.getItem('rhs-' + my_location.basename) != undefined && localStorage.getItem('rhs-' + my_location.basename) == 'off')
            responsive_layout = 'false';
    }
    return $('#" . $dom_id_selector . "').dataTable({
        'columnDefs': [
            { $sorting_cols },
            { 'bVisible': $first_column_visible, 'aTargets': [ 0 ] }
        ],
        'sDom': '<\"row\"<\"col-xs-7\"l><\"col-xs-5\"f>r>t<\"row\"<\"col-xs-4\"i><\"col-xs-8\"p>>',
        'responsive': (responsive_layout == 'false' ? false : true),
        'language': {
            'lengthMenu': '" . lang('base_show') . " _MENU_ " . lang('base_rows') . "',
            'search': '',
            'sProcessing': '',
            'searchPlaceholder': '" . lang('base_search') . "',
            'paginate': {
                'previous': '<i class=\"fa fa-angle-left\"></i>',
                'next': '<i class=\"fa fa-angle-right\"></i>'
            },
            " . $empty_table . "
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', '" . $dom_id_var . "-row-' + iDataIndex)
        },
        $server_side
        $col_widths
        'stateSave': true,
        'stateDuration': 60 * 60 * 24 * 365,
        'bRetrieve': true,
        'iDisplayLength': $default_rows,
        'aLengthMenu': [$row_options],
        'bPaginate': " . ($paginate ? 'true' : 'false') . ",
        'bInfo': " . ($paginate ? 'true' : 'false') . ",
        'bFilter': " . ($filter ? 'true' : 'false') . ",
        'bSort': " . ($sort ? 'true' : 'false') . ",
        $sorting_type
        $group_javascript
        'order': [ $first_column_fixed_sort ]
    })$row_reorder;
  }
  $(document).ready(function() {
    $.fn.dataTable.ext.pager.numbers_length = 4;
    get_table_$dom_id_var();
  });
</script>
    ";
}

/**
 * List table.
 *
 * @param string $title   table title
 * @param array  $anchors list anchors
 * @param array  $headers headers
 * @param array  $items   items
 * @param array  $options options
 *
 * Options:
 *  id: DOM ID
 *  group: flag for grouping
 *
 * @return string HTML
 */

function theme_list_table($title, $anchors, $headers, $items, $options = NULL)
{
    $columns = count($headers) + 1;

    // Header parsing
    //---------------

    // Tabs are just for clean indentation HTML output
    $header_html = '';

    foreach ($headers as $index => $header) {
        $responsive_class = '';
        if ($index == 0 && isset($options['grouping']) && $options['grouping'])
            $responsive_class = " class='never'";
        else if (isset($options['grouping']) && $options['grouping'])
            $responsive_class = " class='" . $options['responsive'][$index - 1] . "'";
        else if (isset($options['responsive']) && isset($options['responsive'][$index]))
            $responsive_class = " class='" . $options['responsive'][$index] . "'";
        $header_html .= "\n\t\t" . "<th$responsive_class>$header</th>";
    }

    // Empty table
    if (isset($options['empty_table_message']))
        $empty_table = "
            \"sEmptyTable\": \"" . $options['empty_table_message'] . "\",
        ";
    else
        $empty_table = '';

    // Search
    $filter = 'false';
    if (isset($options['filter']) && $options['filter'])
        $filter = 'true';

    // Action column?
    $action_col = TRUE;
    if (isset($options['no_action']) && $options['no_action'])
        $action_col = FALSE;

    // No title in the action header
    if ($action_col) {
        $responsive_class = '';
        if (isset($options['responsive']) && isset($options['responsive'][$columns]))
            $responsive_class = " class='" . $options['responsive'][$columns] . "'";
        $header_html .= "\n\t\t" . "<th$responsive_class>" . (isset($options['action_header']) ? $options['action_header'] : lang('base_action')) . "</th>";
    }

    // Add button
    //-----------

    $add_html = (empty($anchors)) ? '&nbsp; ' : button_set($anchors);

    // Table ID (used for variable naming too)
    if (isset($options['id']))
        $dom_id = $options['id'];
    else
        $dom_id = 'tbl_id_' . rand(0, 1000);

        // Grouping
        //---------

        if (isset($options['grouping']) && $options['grouping']) {
                $first_column_visible = 'false';
                $first_column_fixed_sort = "[ 0, 'asc' ]";
                $group_javascript = "
        \"fnDrawCallback\": function ( oSettings ) {
            if ( oSettings.aiDisplay.length == 0 )
            {
                return;
            }

            var nTrs = $('#$dom_id tbody tr');
            var iColspan = nTrs[0].getElementsByTagName('td').length;
            var sLastGroup = \"\";
            for ( var i=0 ; i<nTrs.length ; i++ )
            {
                var iDisplayIndex = oSettings._iDisplayStart + i;
                var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
                if ( sGroup != sLastGroup )
                {
                    var nGroup = document.createElement( 'tr' );
                    var nCell = document.createElement( 'td' );
                    nCell.colSpan = iColspan;
                    nCell.className = \"clearos-list-grouping\";
                    nCell.innerHTML = sGroup;
                    nGroup.appendChild( nCell );
                    nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
                    sLastGroup = sGroup;
                }
            }
        },
                ";
        } else {
                $first_column_visible = 'true';
                $first_column_fixed_sort = '';
                $group_javascript = '';
        }

    // Item parsing
    //-------------

    $item_html = '';

    foreach ($items as $item) {
        $item_html .= "\t<tr>\n";

        foreach ($item['details'] as $value)
            $item_html .= "\t\t" . "<td>$value</td>\n";

        if (isset($options['read_only']) && $options['read_only']) {
            $type = ($item['state']) ? "<i class='fa fa-check-circle'></i>" : '';
            $item_html .= "\t\t<td>$type</td>";
        } else {
            $select_html = ($item['state']) ? 'checked' : '';
            $item_html .= "\t\t<td class='table-buttonset-column'><input type='checkbox' name='" . $item['name'] . "' $select_html></td>\n";
        }

        $item_html .= "\t</tr>\n";
    }

    // List table
    //-----------

    return "

<div class='box'>
  <div class='box-header'>
    <div class='theme-box-tools pull-right'>$add_html</div>
    <h3 class='box-title'>$title</h3>
  </div>
  <div class='box-body'>
    <table cellspacing='0' cellpadding='0' width='100%' border='0' class='table " . (isset($options['responsive']) && $options['responsive'] == 'disabled' ? '' : 'responsive') . " table-striped' id='$dom_id'>
     <thead>
      <tr>$header_html
      </tr>
     </thead>
     <tbody>
$item_html
     </tbody>
    </table>
  </div>
</div>
<script type='text/javascript'>
$(document).ready(function() {
        var table_" . $dom_id . " = $('#" . $dom_id . "').dataTable({
                \"aoColumnDefs\": [
                        { \"bSortable\": false, \"aTargets\": [ " . ($action_col ? "-1" : "") . " ] },
                        { \"bVisible\": $first_column_visible, \"aTargets\": [ 0 ] }
                ],
        'sDom': '<\"row\"<\"col-xs-7\"l><\"col-xs-5\"f>r>t<\"row\"<\"col-xs-8\"i><\"col-xs-4\"p>>',
        'language': {
            'search': '',
            'sProcessing': '',
            'searchPlaceholder': '" . lang('base_search') . "',
            " . $empty_table . "
        },
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', '" . $dom_id . "-row-' + iDataIndex)
        },
                \"bJQueryUI\": true,
                \"bPaginate\": false,
                \"stateSave\": true,
                \"bFilter\": $filter,
                $group_javascript
                \"aaSortingFixed\": [ $first_column_fixed_sort ],
                \"sPaginationType\": \"full_numbers\"
    });
});
</script>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// G E N E R I C  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Box content.
 *
 * Use this function when the content is small
 *
 * @param string $content content
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_box_content($content, $options = NULL)
{
    $id = (isset($options['id'])) ? "id='" . $options['id'] . "'" : "";
    $classes = (isset($options['class'])) ? $options['class'] : "";
    return "<div $id class='box-body theme-clear $classes'>$content</div>";
}

/**
 * Close box element.
 *
 * @return string HTML
 */

function theme_box_close()
{
    return "</div>";
}

/**
 * Box content open.
 *
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_box_content_open($options = NULL)
{
    return "<div class='box-body theme-clear'>";
}

/**
 * Box content close.
 *
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_box_content_close($options = NULL)
{
    return "</div>";
}

/**
 * Box footer.
 *
 * @param string $footer  footer content
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_box_footer($id = NULL, $footer = '', $options = NULL)
{
    $id_html = ($id != NULL ? " id='" . $id . "'" : '');
    $classes = (isset($options['class'])) ? ' ' . $options['class'] : '';
    $loading = '';
    if (isset($options['loading']))
        $loading = "
            <div class='overlay clearos-loading-overlay'></div>
            <div class='theme-form-loading clearos-loading-overlay'>" .
                theme_loading('1.25em', lang('base_loading...'), array('icon-below' => TRUE)) . "
            </div>
        ";
    return "
        <div class='box-footer$classes'$id_html>$footer</div>
        $loading
    ";
}

/**
 * Open box element.
 *
 * Supported options:
 * - id
 * - class
 * - anchors
 *
 * @param string $title box title
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_box_open($title, $options)
{
    $id_html = (isset($options['id'])) ? $options['id'] : 'options_' . rand(0, 1000);
    $classes = (isset($options['class'])) ? $options['class'] : '';
    $anchors = (isset($options['anchors'])) ? "<div class='theme-box-tools pull-right'>" . $options['anchors'] . "</div>": '';
    return "
        <div class='box $classes' id='$id_html'>
            " . ($title != NULL ? "
            <div class='box-header'>
                $anchors
                <h3 class='box-title' id='" . $id_html . "_title'>$title</h3>
            </div>
            " : "")
    ;
}



function app_box_open($title, $options)
{
    $id_html = (isset($options['id'])) ? $options['id'] : 'options_' . rand(0, 1000);
    $classes = (isset($options['class'])) ? ' ' . $options['class'] : '';
    $anchors = (isset($options['anchors'])) ? "<div style='float: right; padding-top: 10px; margin-right: 10px;'>" . $options['anchors'] . "</div>": '';
    return "
        <div class='$classes' id='$id_html'>
            " . ($title != NULL ? "
            <div class='box-header'>
                <h3 class='box-title' id='" . $id_html . "_title'>$title</h3>$anchors
            </div>
           " : "")
    ;
}


function app_box_close($options = NULL)
{
    return "</div>";
}


/**
 * Open a row (eg. Bootstrap grid).
 *
 * @param array  $options options
 *
 * Options:
 *  id: DOM ID
 *  class: class(es)
 *
 * @return string HTML
 */

function theme_row_open($options = NULL)
{
    $id = (isset($options['id'])) ? " id='" . $options['id'] . "'" : "";
    $class = (isset($options['class'])) ? " " . $options['class'] : "";

    return "<div" . $id . " class='row" . $class . "'>";
}

/**
 * Close a row (eg. Bootstrap grid).
 *
 * @param array  $options options
 *
 * Options:
 *
 * @return string HTML
 */

function theme_row_close($options = NULL)
{
    return "</div>";
}

/**
 * Open a column (eg. Bootstrap grid).
 *
 * @param int $desktop column counter (based on 12 grid column) for desktop
 * @param int $tablet  column counter (based on 12 grid column) for tablet
 * @param int $phone   column counter (based on 12 grid column) for phone
 * @param array  $options options
 *
 * Options:
 *  id: DOM ID
 *  class: class(es)
 *
 * @return string HTML
 */


function theme_column_open($desktop, $tablet = NULL, $phone = NULL, $options = NULL)
{
    $id = (isset($options['id'])) ? " id='" . $options['id'] . "'" : "";
    $class = (isset($options['class'])) ? " " . $options['class'] : "";
    $xtr_class = '';
    if ((int)$desktop == 0)
        $desktop = 12;
    if ($tablet != NULL && (int)$tablet != 0)
        $xtr_class .= " col-sm-" . $tablet;
    if ($phone != NULL && (int)$phone != 0)
        $xtr_class .= " col-sm-" . $phone;

    // Based on 12 column Bootstrap grid system
    return "<div" . $id . " class='col-md-$desktop$xtr_class$class'>";
}

/**
 * Close a row (eg. Bootstrap grid).
 *
 * @param array  $options options
 *
 * Options:
 *
 * @return string HTML
 */

function theme_column_close($options = NULL)
{
    return "</div>";
}

///////////////////////////////////////////////////////////////////////////////
// I N F O  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays a standard infobox.
 *
 * Infobox types:
 * - warning  (bad, but we can cope)
 * - highlight (here's something you should know...)
 *
 * @param string $type    type of infobox
 * @param string $title   table title
 * @param string $message message
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_infobox($type, $title, $message, $options = NULL)
{
    $class = array(
        'theme-infobox',
        'alert'
    );
    if ($type === 'critical') {
        $class[] = 'alert-danger';
        $iconclass = 'fa fa-times-circle';
    } else if ($type === 'warning') {
        $class[] = 'alert-warning';
        $iconclass = 'fa fa-exclamation-triangle';
    } else if ($type === 'info') {
        $class[] = 'alert-info';
        $iconclass = 'fa fa-info';
    } else {
        $class[] = 'alert-success';
        $iconclass = 'fa fa-check-circle';
    }

    $id = isset($options['id']) ? ' id=' . $options['id'] : '';
    if (isset($options['hidden']))
        $class[] = 'theme-hidden';
    $buttons = "";
    if (isset($options['buttons']))
        $buttons = "<div class='text-center' style='padding: 15px;'>" . theme_button_set($options['buttons']) . '</div>';

    return "
        <div class='" . implode(' ', $class) . "' $id>
            <div class='theme-infobox-icon'><i class='$iconclass'></i></div>
            <div class='theme-infobox-title'>$title</div>
            <div class='theme-infobox-content'>$message</div>
            $buttons
        </div>

    ";
}

/**
 * Displays a standard infobox with a page redirect anchor.
 *
 * Infobox types:
 *
 * @param string $title    title
 * @param string $message  message
 * @param string $url      url
 * @param string $url_text link text
 * @param array  $options options
 *
 * @return string HTML
 */

function theme_infobox_and_redirect($title, $message, $url, $link_text, $options = NULL)
{
    $message .= "<div class='theme-infobox-anchor'>" . theme_anchor($url, $link_text, 'high', '') . "</div>";
    return theme_infobox('info', $title, $message, $options);
}

///////////////////////////////////////////////////////////////////////////////
// D I A L O G  B O X E S
///////////////////////////////////////////////////////////////////////////////

function theme_dialogbox_confirm_delete($message, $items, $ok_anchor, $cancel_anchor)
{
    $items_html = '';

    foreach ($items as $item)
        $items_html = "<li>$item</li>\n";

    $items_html = "<ul>\n$items_html\n</ul>\n";

    $message = "
        <p>$message</p>
        <div>$items_html</div>
        <div class='text-center'>" . theme_button_set(array(anchor_ok($confirm_uri), anchor_cancel($cancel_uri))) . "</div>
    ";

    return theme_infobox('warning', lang('base_confirmation_required'), $message);
}

function theme_dialogbox_confirm($message, $ok_anchor, $cancel_anchor, $options)
{
    return theme_confirm(lang('base_confirmation_required'), $ok_anchor, $cancel_anchor, $message, $options);
}

/**
 * Modal info.
 *
 * @param string $id      DOM id
 * @param string $title   title
 * @param string $message message
 * @param array  $options options
 *
 * @return HTML for anchor
 */
function theme_modal_info($id, $title, $message, $options = NULL)
{

    // May have more than one modal dialog...ensure close buttons have unique dom ID's
    $close_id = 'modal-close-' . rand(0, 100);
    $buttons = array(
        anchor_ok('#', 'high', array('id' => $close_id))
    );
    $type = 'info';
    $icon = 'fa-info-circle';
    if (isset($options['type'])) {
        if ($options['type'] == 'warning') {
            $type = 'warning';
            $icon = 'fa-exclamation-triangle';
        }
    }
    $on_close = '';
    if (isset($options['redirect_on_close']))
        $on_close = "window.location = '" . $options['redirect_on_close'] . "';";
    elseif (isset($options['call_back']))
        $on_close = $options['call_back'];

    return "
            <div id='$id' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='$id' aria-hidden='true' style='z-index: 9999;'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <div class='theme-modal-info $type'><i class='fa $icon'></i></div><h4 id='$id-title'>$title</h4>
                  </div>
                  <div class='modal-body'>
                    <div id='$id-message'>$message</div>
                  </div>
                  <div class='modal-footer'>
                    " . _theme_button_set($buttons) . "
                  </div>
                </div>
              </div>
            </div>
            <script type='text/javascript'>
              $('#$close_id').click(function(e) {
                  e.preventDefault();
                  $('#$id').modal('hide');
                  $on_close
              });
            </script>
    ";
}

/**
 * Modal confirmation form.
 *
 * @param string $title   title
 * @param string $message message
 * @param mixed  $confirm confirmation URL or array containing JS
 * @param array  $trigger array identifing either id or class that triggers the dialog to open (eg. array('id' => 'open_dialog'))
 * @param string $form_id optional form ID.  If provided, confirmation will submit this form
 * @param string $id      DOM ID of the entire dialog
 * @param array  $options options
 *
 * @return HTML for anchor
 */
function theme_modal_confirm($title, $message, $confirm, $trigger, $form_id = NULL, $id = NULL, $options = NULL)
{

    $unique = rand(0, 100);
    if ($id == NULL)
        $id = 'modal-confirm-container' . $unique;
    else
        $unique = $id;
    $stay_open_on_confirm = FALSE;
    if (isset($options['stay_open_on_confirm']))
        $stay_open_on_confirm = TRUE;

    // May have more than one modal dialog...ensure confirm/close buttons have unique dom ID's
    $confirm_id = "modal-confirm-$unique";
    $close_id = "modal-close-$unique";
    $buttons = array(
        anchor_custom(($form_id == null && !is_array($confirm) ? $confirm : "#"), lang('base_confirm'), 'high', array('id' => $confirm_id)),
        anchor_cancel('#', 'low', array('id' => $close_id))
    );

    $js_lines = "";
    if (is_array($confirm)) {
        foreach ($confirm as $line)
            $js_lines .= $line . "\n";
    }
    return "
            <div id='" . $id . "' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='$id' aria-hidden='true' style='z-index: 9999;'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4>$title</h4>
                  </div>
                  <div class='modal-body'>
                    <div>$message</div>
                  </div>
                  <div class='modal-footer'>
                    " . _theme_button_set($buttons) . "
                  </div>
                </div>
              </div>
            </div>
            <script type='text/javascript'>
                " . ($trigger == null ? "" : "
                $('" . (array_key_exists('id', $trigger) ? "#" . $trigger['id'] : "." . $trigger['class']) . "').click(function(e) {
                    e.preventDefault();
                    $('#" . $id . "').modal({backdrop: 'static'});
                }); ") . "
                $('#$close_id').click(function(e) {
                    e.preventDefault();
                    $('#" . $id . "').modal('hide');
                });
                " . ($stay_open_on_confirm ? "" : ($form_id != null ? "
                $('#$confirm_id').click(function() {
                    $('#" . $id . "').modal('hide');
                    $('#$form_id').submit();
                });
                " : (is_array($confirm) ? "
                $('#$confirm_id').click(function() {
                    $('#" . $id . "').modal('hide');
                    " . $js_lines . "
                });
                " : ""))) . "
            </script>
    ";
}

/**
 * Modal input form.
 *
 * @param string $title    title
 * @param string $message  message
 * @param array  $trigger  trigger
 * @param string $input_id DOM ID of element to update
 * @param string $id       DOM ID
 * @param array  $options  options
 *
 * @return HTML for anchor
 */
function theme_modal_input($title, $message, $trigger, $input_id, $id = null, $options)
{

    if ($id == null)
        $id = 'modal-input-' . rand(0,50);

    $buttons = array(
        theme_form_submit('submit', lang('base_submit'), 'high', null, array('id' => 'modal-input-submit')),
        anchor_cancel('#', 'low', array('id' => 'modal-input-close'))
    );

    $js_lines = "";
    return "
            <div id='" . $id . "' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='$id' aria-hidden='true' style='z-index: 9999;'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h4>$title</h4>
                  </div>
                  <div class='modal-body'>
                    <p>$message</p>
                    <div style='text-align: center;'><input type='text' name='mi-$input_id' id='mi-$input_id' value='' class='form-control'></div>
                  </div>
                  <div class='modal-footer'>
                    " . _theme_button_set($buttons) . "
                  </div>
                </div>
              </div>
            </div>
            <script type='text/javascript'>
                $(document).ready(function() {
                    $('" . (array_key_exists('id', $trigger) ? "#" . $trigger['id'] : "." . $trigger['class']) . "').click(function(e) {
                        e.preventDefault();
                        $('#" . $id . "').modal({backdrop: 'static'});
                    });
                    $('#modal-input-close').click(function(e) {
                        e.preventDefault();
                        $('#" . $id . "').modal('hide');
                    });
                    $('#modal-input-submit').click(function(e) {
                        e.preventDefault();
                        if ($('#mi-" . $input_id . "').val() != '') {
                            $('#" . $input_id . "').val($('#mi-" . $input_id . "').val());
                            $('#" . $id . "').modal('hide');
                            " . (isset($options['callback']) ? $options['callback'] : "") . "
                        }
                    });
                    $('#" . $id . "').on('shown.bs.modal', function () {
                        $('#mi-" . $input_id . "').focus();
                    })
                });
            </script>
    ";
}


function theme_confirm($title, $confirm_uri, $cancel_uri, $message, $options = null)
{
    $message = "
        <p>$message</p>
        <div class='text-center'>" . theme_button_set(array(anchor_ok($confirm_uri), anchor_cancel($cancel_uri))) . "</div>
    ";

    return theme_infobox('warning', $title, $message, $options);
}

function theme_confirm_delete($title, $confirm_uri, $cancel_uri, $items, $message, $options)
{
    foreach ($items as $item)
        $items_html = "<li>$item</li>\n";

    $items_html = "<ul>\n$items_html\n</ul>\n";

    $message = "
        <p>$message</p>
        <div>$items_html</div>
        <div class='text-center'>" . theme_button_set(array(anchor_ok($confirm_uri), anchor_cancel($cancel_uri))) . "</div>
    ";

    return theme_infobox('warning', $title, $message);
}

///////////////////////////////////////////////////////////////////////////////
// W I Z A R D  I N T R O  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays an intro box when in wizard mode.
 *
 */

function theme_wizard_intro_box($data, $options)
{
    return theme_container("
        <div class='theme-wizard-intro-title'>" . $data['wizard_name'] . "</div>
        <div class='theme-wizard-intro-icon-container'>
          <div class='theme-wizard-intro-icon'>" .  theme_app_logo($data['basename']) . "</div>
        </div>
        <div class='theme-wizard-intro-description clearfix'>" . $data['wizard_description'] . "</div>
    ");
}

///////////////////////////////////////////////////////////////////////////////
// S I M P L E  C O N T A I N E R
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays a container.
 *
 */

function theme_container($content, $options = array())
{
    return "
        <div class='theme-container'>
           $content
        </div>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// H E L P  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays a help box.
 *
 * The available data for display:
 * - $name - app name
 * - $category - category
 * - $subcategory - subcategory
 * - $description - description
 * - $user_guide_url - URL to the user guide
 * - $support_url - URL to support
 */

function theme_help_box($data)
{
    if (!empty($data['user_guide_url'])) {
        $user_guide_link = "
            <div class='theme-help-box-assets-icons theme-help-box-user-guide'>
                <a target='_blank' href='" . $data['user_guide_url'] . "'>" . $data['user_guide_url_text'] . "</a>
            </div>
        ";
    } else {
        $user_guide_link = "";
    }

    if (!empty($data['support_url'])) {
        $support_link = "
            <div class='theme-help-box-assets-icons theme-help-box-support'>
                <a target='_blank' href='" . $data['support_url'] . "'>" . $data['support_url_text'] . "</a>
            </div>
        ";
    } else {
        $support_link = "";
    }

    if ($support_link || $user_guide_link) {
        $help_box_assets = "
            <div class='theme-help-box-assets'>
                <div class='theme-help-box-assets-style'>
                    $user_guide_link
                    $support_link
                </div>
            </div>
        ";
    } else {
        $help_box_assets = '';
    }

    $action = '';
    if (isset($data['action']))
        $action = anchor_custom(
            $data['action']['url'],
            $data['action']['text'],
            $data['action']['priority'],
            $data['action']['js']
        );

    return
        "<div class='theme-help-box-container hidden-xs'>
             <div class='theme-help-box-content'>
                 <div class='theme-help-box-icon'>" . theme_app_logo($data['basename'], array('no_container' => true)) . "</div>
                 <div class='theme-help-box-description'>" . $data['description'] . "</div>
             </div>
        </div>";
}

///////////////////////////////////////////////////////////////////////////////
// I N L I N E  H E L P  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays an inline box.
 *
 * Inline help is displayed on some pages, notably on app pages that are shown
 * before the network is configured (install wizard, graphical console).
 *
 * The available data for display:
 * - $name - app name
 */

function theme_inline_help_box($data)
{
    $help = '';

    $index = 0;
    foreach ($data['inline_help'] as $heading => $text) {
        $help .= "<h3 id='inline-help-title-$index'>$heading</h3>";
        $help .= "<p id='inline-help-content-$index'>$text</p>";
        $index++;
    }

    $html = theme_container("
        <h3 class='theme-inline-help-title'>" . lang('base_help') . "</h3>
        <div class='theme-inline-help'>$help</div>
        <div id='inline-help-hook'></div>
    ");

    return $html;
}

/**
 * Displays a pagination widget.
 *
 */

function theme_paginate($url, $pages = 0, $active = 0, $max = 5, $options = null)
{
    $options['id'] = isset($options['id']) ? $options['id'] : 'paginate';

    $offset = 0;

    if ($active > (int) ($max / 2))
        $offset = $active - $pages / ($max * 2);

    $offset = round($offset, 0, PHP_ROUND_HALF_DOWN);
    if ($active > $offset + $max)
        $offset = $pages - $max + 1;
    else if ($pages <= $active + $max / 2)
        $offset = $pages - $max + 1;

    if ($pages < $max)
        $max = $pages;

    $buttons = array();
    $buttons[] = anchor_custom(
        $url . '/0',
        "&laquo;", 'high',
        array('id' => 'paginate_first', 'no_escape_html' => true, 'class' => 'theme-paginate-button')
    );
    $buttons[] = anchor_custom(
        $url . '/' . ($active > 0 ? $active - 1 : 0),
        "&lsaquo;", 'high',
        array('id' => 'paginate_prev', 'no_escape_html' => true, 'class' => 'theme-paginate-button')
    );

    for ($index = $offset; $index < $max + $offset; $index++)
        $buttons[] = anchor_custom(
                        $url . '/' . $index, $index, 'low',
                        ($index == $active ? array('id' => "paginate_$index", 'class' => 'theme-paginate-active') : array('id' => "paginate_$index"))
                    );

    $buttons[] = anchor_custom(
        $url . '/' . ($pages > $active ? $active + 1 : $pages),
        "&rsaquo;", 'high',
        array('id' => 'paginate_next', "no_escape_html" => true, 'class' => 'theme-paginate-button')
    );
    $buttons[] = anchor_custom(
        $url . '/' . $pages,
        "&raquo;", 'high',
        array('id' => 'paginate_last', "no_escape_html" => true, 'class' => 'theme-paginate-button')
    );

    return theme_button_set($buttons, $options);
}

///////////////////////////////////////////////////////////////////////////////
// A P P  S U M M A R Y  B O X
///////////////////////////////////////////////////////////////////////////////

/**
 * Displays a summary box.
 *
 * The available data for display:
 * - $name - app name
 * - $tooltip -  tooltip
 * - $version - version number (e.g. 4.7)
 * - $release - release number (e.g. 31.1, so version-release is 4.7-31.1)
 * - $vendor - vendor
 *
 * If this application is included in the marketplace, the following
 * information is also available.
 *
 * - $subscription_expiration - subscription expiration (if applicable)
 * - $install_status - install status ("up-to-date" or "update available")
 * - $marketplace_chart - a relevant chart object
 */

function theme_summary_box($data)
{
    clearos_load_language('base');

    if (empty($data['tooltip']))
        $data['tooltip'] = '';

    if ($data['show_marketplace']) {
        $buttons = array();
        $buttons[] = anchor_custom('/app/marketplace/view/' . $data['basename'], lang('base_details'));
        if (isset($data['delete_dependency']))
            $buttons[] = anchor_custom('/app/marketplace/uninstall/' . $data['basename'], lang('base_uninstall'));
        $buttons[] = anchor_custom('#', lang('base_rate_app'), 'high', array('id' => 'app-' . $data['basename'], 'class' => 'sidebar-review-app'));
        $marketplace_html = "<div class='marketplace-links'>" . theme_button_set($buttons) . "</div>";

        if (isset($data['show_recommended_apps']) && $data['show_recommended_apps'])
            $marketplace_html .=  "<div id='sidebar-recommended-apps'></div>";

    } else {
        $marketplace_html = '';
    }

    $vendor = "";
    $pkg_data = "";
    if (isset($data['powered_by'])) {
        if ($data['powered_by']['vendor'] != NULL)
            $vendor = "
                    <div class='row'>
                        <div class='col-xs-6 theme-field'>" . lang('base_vendor') . "</div>
                        <div class='col-xs-6'>" .
                        (isset($data['powered_by']['vendor']['url']) ? "<a href='" . $data['powered_by']['vendor']['url'] . "' target='_blank'>" : "") .
                        $data['powered_by']['vendor']['name'] .
                        (isset($data['powered_by']['vendor']['url']) ? "</a>" : "") .
                        "</div>
                    </div>
            ";

        if (isset($data['powered_by']['packages'])) {
            $first = true;
            foreach ($data['powered_by']['packages'] as $pkg) {
                $pkg_data .= "
                    <div class='row'>
                        <div class='col-xs-6 theme-field'>" . ($first ? lang('base_powered_by') : "") . "</div>
                        <div class='col-xs-6'>" .
                        (isset($pkg['url']) ? "<a href='" . $pkg['url'] . "' target='_blank'>" : "") .
                        $pkg['name'] . " <span class='theme-powered-by-version'>" . $pkg['version'] . "</span>" .
                        (isset($pkg['url']) ? "</a>" : "") . "
                        </div>
                    </div>
                ";
                $first = false;
            }
        }
    }
    $html = theme_container("
        <div class='box-header'><h3 class='box-title'>" . $data['name'] . "</h3></div>
        <div class='box-body theme-clear' id='theme_app_sidebar'>
            <div class='row'>
                <div class='col-xs-6 theme-field'>" . lang('base_maintainer') . "</div>
                <div class='col-xs-6'>" . $data['vendor'] . "</div>
            </div>
            <div class='row'>
                <div class='col-xs-6 theme-field'>" . lang('base_app_version') . "</div>
                <div class='col-xs-6'>" . $data['version'] . '-' . $data['release'] . "</div>
            </div>" .
            $vendor .
            $pkg_data . "
            <div id='sidebar_daemon_status' class='row theme-hidden'>
                <div class='col-xs-6 theme-field'>" . lang('base_status') . "</div>
                <div class='col-xs-6' id='clearos_daemon_status'>" . theme_loading('small') . "</div>
            </div>
            <div id='sidebar_daemon_action' class='row theme-hidden'>
                <div class='col-xs-6 theme-field'>" . lang('base_action') . "</div>
                <div class='col-xs-6' id='sidebar_daemon_action_controls'>" . anchor_custom('#', '---', 'high', array('id' => 'clearos_daemon_action')) . "</div>
            </div>
            <div id='sidebar_additional_info_row' class='row theme-hidden'>
                <div class='col-xs-6 theme-field'>" . lang('base_additional_info') . "</div>
                <div class='col-xs-6' id='sidebar_additional_info'>" . theme_loading('small') . "</div>
            </div>
            $marketplace_html
        </div>
        " . theme_marketplace_review($data['basename']) . "
        <div class='box-footer'></div>"
    );

    return $html;
}

/**
 * Returns tips and hints modal.
 *
 * @return string menu HTML output
 */

function theme_tips_and_hints($tooltips)
{
    if (is_array($tooltips)) {
        $tips = "<ul class='theme-tooltips'>";
        foreach ($tooltips as $tip)
            $tips .= "<li>$tip</li>";
        $tips .= "</ul>";
    } else {
        $tips = $tooltips;
    }

    return theme_modal_info('app-tips-content', lang('base_tips_and_hints'), $tips);
}

/**
 * Get an icon.
 *
 * @param string $name     name of icon
 * @param array  $options  options
 *
 * @return string HTML
 */

function theme_icon($name, $options = NULL)
{
    $id = (isset($options['id'])) ? " id='" . $options['id'] . "'" : "";

    $class = array();
    if ((isset($options['class']))) {
        // Additional classes
        if (is_array($options['class']))
            $class = $options['class'];
        else
            $class = explode(' ', $options['class']);
    }
    // These map to Font-Awesome icon set found at
    // http://fortawesome.github.io/Font-Awesome/icons/
    if ($name == 'speedometer')
        $icon = 'tachometer';
    else if ($name == 'info')
        $icon = 'info-circle';
    else if ($name == 'warning')
        $icon = 'warning';
    else if ($name == 'critical')
        $icon = 'exclamation-circle';
    else if ($name == 'flag')
        $icon = 'flag';
    else if ($name == 'settings')
        $icon = 'gear';
    else
        $icon = 'question-circle';

    return "<i $id class='fa fa-$icon " . implode(' ' , $class) . "'></i>";
}

///////////////////////////////////////////////////////////////////////////////
// A P P   L O G O
///////////////////////////////////////////////////////////////////////////////

/**
 * Get a image.
 *
 * @param string $name     name of image
 * @param string $basename basename where image request called from
 * @param array  $options  options
 *
 * Supported types: svg, png and gif
 *
 * Options:
 *  id: DOM ID
 *  size: DOM ID
 *  alttext: Alt text
 *  class: class(es)
 *
 * @return string HTML
 */

function theme_image($name, $basename, $options = NULL)
{
    $override_size = "";
    $id = (isset($options['id'])) ? " id='" . $options['id'] . "'" : "";
    $class = array();
    if ((isset($options['class']))) {
        // Additional classes
        if (is_array($options['class']))
            $class = $options['class'];
        else
            $class = explode(' ', $options['class']);
    }
    if (isset($options['size'])) {
        if (preg_match('/^(\d+)x(\d+)$/', $options['size'], $match)) {
            $override_size = "style='width: " . $match[1] . "px; height: " . $match[2] . "px;'";
            $size = '';
        } else {
            $class[] = $options['size'];
        }
    }
    $alt = (isset($options['alt'])) ? " " . $options['alt'] : "";
    $color = (isset($options['color'])) ? " " . $options['color'] : "";

    if (preg_match('/\.svg$/', $name)) {
        // First check app htdocs
        $filename = clearos_app_base($basename) . '/htdocs/' . $name;
        if (!file_exists($filename))
            $filename = clearos_theme_path('ClearOS-Admin') . "/img/missing.svg";

        // Now check for theme override
        if (file_exists(clearos_theme_path('ClearOS-Admin') . "/img/$name"))
            $filename = clearos_theme_path('ClearOS-Admin') . "/img/$name";
        return "<div $id class='" . implode(' ' , $class) . "' $override_size>" . file_get_contents($filename) . "</div>";
    } else {
        // First check app htdocs
        $src = clearos_app_htdocs($basename) . '/' . $name;
        $filename = clearos_app_base($basename) . '/htdocs/' . $name;
        if (!file_exists($filename))
            $src = clearos_theme_url('ClearOS-Admin') . "/img/missing.svg";
        // Now check for theme override
        if (file_exists(clearos_theme_path('ClearOS-Admin') . "/img/$name"))
            $src = clearos_theme_url('ClearOS-Admin') . "/img/$name";

        return "<img src='" . $src . "' $id class='" . implode(' ' , $class) . "' $override_size>";
    }
}

/**
 * Get an app logo.
 *
 * @param string $basename app base name
 * @param array  $options  options
 *
 * Options:
 *  id: DOM ID
 *  size: DOM ID
 *  alttext: Alt text
 *  class: class(es)
 *
 * @return string HTML
 */

function theme_app_logo($basename, $options = NULL)
{
    $id = (isset($options['id'])) ? " id='" . $options['id'] . "'" : "";
    $class = (isset($options['class'])) ? " " . $options['class'] : "";
    $alt = (isset($options['alt'])) ? " " . $options['alt'] : "";
    $size = (isset($options['size'])) ? " " . $options['size'] : "";
    $color = (isset($options['color'])) ? " " . $options['color'] : "";
    $no_container = (isset($options['no_container'])) ? TRUE : FALSE;
    $filename = clearos_theme_path('ClearOS-Admin') . '/img/placeholder.svg';
    if (file_exists(clearos_app_base($basename) . "/htdocs/$basename.svg"))
        $filename = clearos_app_base($basename) . "/htdocs/$basename.svg";
    else if (file_exists(CLEAROS_CACHE_DIR . "/mp-logo-$basename.svg"))
        $filename = CLEAROS_CACHE_DIR . "/mp-logo-$basename.svg";

    if ($no_container)
        return file_get_contents($filename);
    else
        return "
            <div class='theme-app-logo-container box'>
                <div id='app-logo-$basename' class='theme-app-logo box-body$class'>
                    " . file_get_contents($filename) . "
                </div>
            </div>
        ";
}

/**
 * Get and display a screenshot set.
 *
 * @param string $id      DOM id
 * @param array  $images  array of metadata
 * @param array  $options options
 *
 * Options:
 *  TODO
 *
 * @return string HTML
 */

function theme_screenshot_set($id, $images, $options)
{
    // TODO add support for images array if not ajax pulled

    return "
        <div class='image-row'>
            <div id='$id' class='image-set'></div>
        </div>
    ";
}

///////////////////////////////////////////////////////////////////////////////
// M A R K E T P L A C E
///////////////////////////////////////////////////////////////////////////////

/**
 * Get marketplace filter.
 *
 * @param string $name     name of filter
 * @param array  $values   values to select from
 * @param string $selected selected option
 * @param array  $options  options
 *
 * Options:
 *
 * @return string HTML
 */

function theme_marketplace_filter($name, $values, $selected = 'all', $options)
{
    $class = (isset($options['class'])) ? " " . $options['class'] : "";

    $html =  "<div class='col-md-3'>";
    $html .= "    <select id='filter_$name' name='filter_$name' class='marketplace-filter filter-event form-control'>";
    foreach ($values as $key => $readable)
        $html .= "        <option value='$key'" . ($selected === $key ? ' SELECTED' : '') . ">$readable</option>\n";
    $html .= "    </select>";
    $html .= "</div>";
    return $html;
}

/**
 * Get marketplace search.
 *
 * @param string $search_string search string
 *
 * @return string HTML
 */

function theme_marketplace_search($search_string = NULL)
{
    // No form here...goes with filter options
    $html = "
        <div class='input-group'>
            <input type='text' name='search' id='search'" .
            ($search_string != NULL ? " value='$search_string'" : "") . " class='form-control'" .
            ($search_string == NULL ? " placeholder='" . lang('base_search') . "...'" : "") . ">
            <span class='input-group-btn'>" .
                ($search_string != NULL ? "<button type='submit' name='search_cancel' value='1' class='btn btn-primary'><i class='fa fa-search'></i></button>" : " <button type='submit' name='q' class='btn btn-primary'><i class='fa fa-search'></i></button> ") . "


            </span>
        </div>
    ";
    return $html;
}

/**
 * Get marketplace developer field metadata.
 *
 * @param string $id      DOM id
 * @param string $field   Human readable field name
 * @param array  $options Options
 *
 * @return string HTML
 */

function theme_marketplace_developer_field($id, $field, $options = NULL)
{
    $icon = 'fa-question';
    if (preg_match('/.*org$/', $id))
        $icon = 'fa-building';
    else if (preg_match('/.*contact$/', $id))
        $icon = 'fa-user';
    else if (preg_match('/.*email$/', $id))
        $icon = 'fa-envelope-o';
    else if (preg_match('/.*website$/', $id))
        $icon = 'fa-globe';
    $html = "
        <div class='marketplace-devel-container'>
            <div class='marketplace-devel-icon'><i class='fa $icon'></i></div>
            <div class='marketplace-devel-field'>$field:</div>
            <div id='$id' class='marketplace-devel-value'></div>
        </div>
    ";
    return $html;
}

/**
 * Get marketplace developer field metadata.
 *
 * @param string $basename  basename
 *
 * @return string HTML
 */

function theme_marketplace_review($basename)
{
    clearos_load_language('marketplace');
    $buttons = array(
        anchor_custom("#", lang('marketplace_submit_review'), 'high', array('id' => 'submit_review')),
        anchor_cancel('#', 'low', array('id' => 'cancel_review'))
    );

    return "
        <div id='review-form' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='review-form' aria-hidden='true'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                <h2>" . lang('marketplace_write_a_review') . "</h2>
              </div>\n
              <div class='modal-body'>" .
                form_open('marketplace/view/' . $basename, array('id' => 'app-review-form')) .
                theme_row_open() .
                theme_column_open(3) . lang('marketplace_app') . theme_column_close() .
                theme_column_open(9) . "<span id='review-app-name'></span>" . theme_column_close() .
                theme_row_close() .
                theme_row_open() .
                theme_column_open(3) . lang('marketplace_rating') . theme_column_close() .
                theme_column_open(9) . "
                    <i class='app-rating-action theme-star fa fa-star' id='star1'></i>
                    <i class='app-rating-action theme-star fa fa-star' id='star2'></i>
                    <i class='app-rating-action theme-star fa fa-star' id='star3'></i>
                    <i class='app-rating-action theme-star fa fa-star' id='star4'></i>
                    <i class='app-rating-action theme-star fa fa-star' id='star5'></i>
                    <input type='hidden' name='rating' id='review-rating' value='0' />" .
                theme_column_close() .
                theme_row_close() .
                theme_row_open() .
                theme_column_open(3) . lang('marketplace_comment') . theme_column_close() .
                theme_column_open(9) . "
                    <textarea id='review-comment' class='marketplace-comment-box'></textarea>
                    <div id='char-remaining' class='theme-smaller-text'>1000 " . lang('marketplace_remaining') . "</div>" .
                theme_column_close() .
                theme_row_close() .
                theme_row_open() .
                theme_column_open(3) . lang('marketplace_submitted_by') . theme_column_close() .
                theme_column_open(9) . "
                    <input type='text' class='theme-full-width' id='review-pseudonym' name='review-pseudonym' value='' />" .
                theme_column_close() .
                theme_row_close() .
                theme_row_open() . "
                <input type='hidden' name='review-basename' id='review-basename' value='$basename' />
                <div id='review-message-bar' class='theme-errmsg-separator'></div>" .
                theme_row_close() .
                form_close() . "
              </div>
              <div class='modal-footer'>
                 " . _theme_button_set($buttons) . "
              </div>
            </div>
          </div>
        </div>
        <script type='text/javascript'>
            $('#review-comment').keyup(function() {
                var charLength = $(this).val().length;
                $('#char-remaining').html(1000 - charLength + ' " . lang('marketplace_remaining') . "');
            });

            $('#cancel_review').click(function(e) {
                e.preventDefault();
                $('#review-form').modal('hide');
            });
            $('#submit_review').click(function() {
                submit_review();
            });
            $('.app-rating-action').on('click', function() {
                rating = this.id.substr(4,5);
                for (var starindex = 1; starindex <= 5; starindex++) {
                    if (rating >= starindex)
                        $('#star' + starindex).addClass('on');
                    else
                        $('#star' + starindex).removeClass('on');
                }
                $('#review-rating').val(rating);
            });
        </script>" .
        theme_modal_confirm(lang('base_warning'), lang('marketplace_confirm_review_replace'), array("submit_review(true);"), NULL, NULL, 'confirm-review-replace')
    ;
}

/**
 * Get marketplace layout.
 *
 * @return string HTML
 */

function theme_marketplace_layout()
{
    echo "<div id='marketplace-app-container' class='row'></div>";
    echo "<div style='clear: both;'></div>";
}

///////////////////////////////////////////////////////////////////////////////
// C O N T R O L  P A N E L
///////////////////////////////////////////////////////////////////////////////

// Note: this theme does not use the "control panel" view so this function
// is here just for sanity checking during development!

function theme_control_panel($form_data)
{
    $items = '';

    foreach ($form_data as $form => $details)
        $items .= "<li><a rel='external' href='$form'>" . $details['title'] . "</a></li>\n";

    return "
        <div class='theme-control-panel'>
            <ul>
                $items
            </ul>
        </div>
    ";
}

function pr($arr)
{
    return "<pre>".print_r($arr).'</pre>';
}
