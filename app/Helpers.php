<?php

if (!function_exists('link_to_route_html'))
{
    function link_to_route_html($name, $html, $parameters = array(), $attributes = array())
    {
        $url = route($name, $parameters);
        return '<a href="'.$url.'"'.app('html')->attributes($attributes).'>'.$html.'</a>';
    }
}

// Generate Table with Action Buttons
function toTable($items, $options = null)
{
    $header = $atts = '';
    $header_keys = array_keys($items[0]);

    if(!is_null($options)) {
        if(array_key_exists('only', $options)) {
            $header_keys = $options['only'];
        }

        if(array_key_exists('attributes', $options)) {
            $attr = $options['attributes'];
        }
        else {
            $attr = array('class' => 'table table-condensed');
        }
    }
    else {
        $attr = array('class' => 'table table-condensed');
    }

    // Thead
    if(is_null($options) || (!isset($options['header']) || isset($options['header']) && $options['header'] != false)) {
        $header = "<thead><tr>";
        foreach ($header_keys as $value) {
            $header .= "<th>" . ucwords(str_replace('_', ' ', $value)) . "</th>";
        }

        // If Actions attribute is available for action buttons add it in header
        if(isset($options['action'])) {
            $header .= "<th style='text-align:right'>Actions</th>";
        }
        $header .= "</tr></thead>";
    }

    // Tbody
    $tbody = "<tbody>";
    foreach ($items as $values) {
        $tbody .= "<tr>";
        foreach($header_keys as $key){
            $tbody .= "<td>" . $values[$key] . "</td>";
        }

        // If Actions attribute is available for action buttons then get it from another view
        if(isset($options['action'])) {
            $action = '<td>'. view($options['action'], array('item' => $values))->render() . '</td>';
            $tbody .= "$action</tr>";
        }
    }
    $tbody .= "</tbody>";

    // Return only Tbody (if table == false)
    if(!is_null($options) && isset($options['table']) && $options['table'] == false) return $tbody;

    // Build attributes (id, class, style etc)
    if(isset($attr)) {
        foreach ($attr as $key => $value) {
            $atts .= " " . $key . "='" . $value . "'";
        }
    }

    // Return table with attributes (class, id, style etc)
    return "<table $atts>" . $header . $tbody . "</table>";
}