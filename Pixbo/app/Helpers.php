<?php

if (!function_exists('link_to_route_html')) {
    function link_to_route_html($name, $html, $parameters = array(), $attributes = array())
    {
        $url = route($name, $parameters);
        return '<a href="' . $url . '"' . app('html')->attributes($attributes) . '>' . $html . '</a>';
    }
}

function extractTime($time)
{
    $timeArray = explode(':', $time);
    return $timeArray;
}

function set_active($route)
{
    return (\Request::is($route . '*')) ? "active" : '';
}

function get_model_name($string=""){
	$modal = explode('.',$string);
	return $modal[count($modal)-1]; // Return the last word after any '.'
}