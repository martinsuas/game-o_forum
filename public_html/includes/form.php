<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/22/2016
 * Time: 7:15 PM
 */

/**
 * @param  string   $name  Reference name.
 */
function create_textbox($name, $maxlength=20, $size=20, $email=false) {
    echo '<input type="';
    // Check if e-mail
    if (!$email)  echo 'text';  else echo 'email';
    // Continue building textbox
    echo '" name="' . $name
        . '" size="' . $size . '" maxlength="' . $maxlength .'" value="';
    // Check for stickiness
    if (isset($_POST[$name])) echo $_POST[$name];
    echo '"/>';
}


function create_password_textbox($name, $maxlength=40, $size=20) {
    echo '<input type="password" name="' . $name
        . '" size="' . $size . '" maxlength="' . $maxlength . '" />';
}

function create_date($name) {
    echo '<input type="date" name="' . $name . '" value="';
    if (isset($_POST[$name])) echo $_POST[$name];
    echo '">';
}

/**
 * @param  string   $name  Reference name.
 * @param  string   $value Value of radio option
 */
function create_radio($name, $value) {
    echo '<input type="radio" name="' . $name . '" value="' . $value . '"';
    // Check for stickiness
    if (isset($_POST[$name]) && ($_POST[$name] == $value))
        echo 'checked="checked"';
    echo "/>$value &nbsp";
}

/**
 * @param  string   $name  Reference name.
 * @param  string   $value Value of multiselect option
 */
function create_option($name, $value, $text="") {
    echo '<option value="' . $value . '"';
    // Check for stickiness
    if (isset($_POST[$name]) && ($_POST[$name] == $value))
        echo 'selected="selected"';
    echo "/>";
    if ($text="")
        echo $value;
    else
        echo $text;
}

/**
 * @param  string   $name  Reference name.
 */
function update_textbox($name, $value, $maxlength=20, $size=20, $email=false) {
    $r = '<input type="';
    // Check if e-mail
    if (!$email)
        $r .= 'text';
    else
        $r .=  'email';
    // Continue building textbox
    $r .=  '" name="' . $name
        . '" size="' . $size . '" maxlength="' . $maxlength .'" value="' . $value . '"/>';
    return $r;
}

function update_date($name, $value) {
    return '<input type="date" name="' . $name . '" value="' . $value . '">';
}

/**
 * @param  string   $name  Reference name.
 * @param  string   $value Value of radio option
 */
function update_radio($name, $current, $value) {
    $r = '<input type="radio" name="' . $name . '" value="' . $value . '" ';
    // Check for stickiness
    if ($current == $value)
        $r .=  'checked="checked"';
    $r .=  "/>$value &nbsp";
    return $r;
}

/**
 * REQUIRES UPDATE - as if now, it would would only if one multiselected value is present.
 * @param  string   $name  Reference name.
 * @param  string   $value Value of multiselect option
 */
function update_option($name, $current, $value, $text="") {
    $r = '<option value="' . $value . '"';
    // Check for stickiness
    if ($current = $value )
        $r .=  'selected="selected"';
    if ($text="")
        $r .=  $value;
    else
        $r .=  $text;
    $r .=  "/>";
    return $r;
}