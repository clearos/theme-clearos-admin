<?php

// General package information
//----------------------------

$package['name'] = 'theme-clearos-admin';
$package['title'] = 'ClearOS Admin Theme';
$package['description'] = 'The ClearOS Admin Theme';

$package['version'] = '1.9';
$package['release'] = '0.0';

$package['vendor'] = 'ClearFoundation';
$package['packager'] = 'ClearFoundation';
$package['license'] = 'Copyright ClearFoundation 2015.  All rights reserved.';
$package['credits'] = array();
    
$package['settings'] = array(
    'menu' => array(
        'lang_tag' => 'base_menu',
        'type' => 'dropdown',
        'options' => array(
            1 => 'Expanding Sidebar',
            2 => 'Category Headers',
        ),
        'required' => TRUE,
        'default' => 0,
    ),
    'hide_app_description' => array(
        'lang_tag' => 'base_hide_app_description',
        'type' => 'dropdown',
        'options' => array(
            0 => lang('base_no'),
            1 => lang('base_yes'),
        ),
        'required' => TRUE,
        'default' => 1,
    ),
    'show_recommended_apps' => array(
        'lang_tag' => 'base_show_recommended_apps',
        'type' => 'dropdown',
        'options' => array(
            0 => lang('base_no'),
            1 => lang('base_yes'),
        ),
        'required' => TRUE,
        'default' => 1,
    ),
    'marketplace' => array(
        'apps_per_page' => array(
            4 => 4,
            8 => 8,
            12 => 12,
            16 => 16,
            24 => 24,
            40 => 40,
            80 => 80,
            0 => lang('base_all')
        )
    ),
    /*
    'css' => array(
        'lang_tag' => 'base_css_style',
        'type' => 'dropdown',
        'options' => array(
            'skin-blue' => 'Blue',
            'skin-black' => 'Black',
        ),
        'required' => TRUE,
        'default' => 'blue',
    ),
    'color_1' => array(
        'lang_tag' => 'base_color_primary',
        'type' => 'color',
        'required' => FALSE,
        'default' => NULL,
    ),
    'color_2' => array(
        'lang_tag' => 'base_color_secondary',
        'type' => 'color',
        'required' => FALSE,
        'default' => NULL,
    ),
    'color_3' => array(
        'lang_tag' => 'base_color_tertiary',
        'type' => 'color',
        'required' => FALSE,
        'default' => NULL,
    ),
    */
);

// vim: ts=4 syntax=php
