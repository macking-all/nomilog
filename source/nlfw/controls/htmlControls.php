<?php

function create_input_label($label,$type,$id,$class,$value,$list = null) {
    $__ = function ($v) { return $v;};
    return "<div><label for=\"{$id}\">{$label}</label>{$__(create_input($type,$id,$class,$value,$list))}</div>";
}

function create_input($type,$id,$class,$value,$list = null) {
    return match(strtolower($type)) {
        'text' => create_inputElement($type,$id,$class,$value),
        'hidden' => create_inputElement($type,$id,$class,$value),
        'option' => create_option($id,$class,$value,$list),
    };
}

function load_parts($name) {
    return file_get_contents("./{$name}");
}


function create_inputElement($type,$id,$class,$value) {
    $__ = function ($v) { return $v;};
    return "<input type=\"{$type}\" id=\"{$id}\" name=\"{$id}\" class=\"{$__(parse_class($class))}\" value=\"{$value}\" />";
}

function create_option($id,$class,$value,$list) {
    $__ = function ($v) { return $v;};
    $option = "";
    foreach($list as $k => $v) {
        $option .= "<option value=\"{$k}\"{$__(isSelected($k,$value))}>{$v}</option>\n";
    }

    return "<select id=\"{$id}\" name=\"{$id}\" class=\"{$__(parse_class($class))}\">{$option}</select>";
}

function isSelected($key,$value) {
    return match($key) {
        $value => ' selected = "selected"',
        default => '',
    };
}

function create_block_button($value,$action,$type,$id,$class){
    $__ = function ($v) { return $v;};
    return "<div>{$__(create_button($value,$action,$type,$id,$class))}</div>\n";
}

function create_button($value,$action,$type,$id,$class) {
    $__ = function ($v) { return $v;};
    return "<button type=\"{$type}\" id=\"{$id}\" class=\"{$__(parse_class($class))}\"  x-action=\"$action\" >{$value}</button>\n";
}


function parse_class($class) {
    return implode(' ',$class);
}

?>