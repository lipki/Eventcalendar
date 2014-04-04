<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module']['eventcalendar'] = array
(
    'module' => "eventcalendar",
        'name' => "Event Calendar Module",
        'module_eventcalendar_folder' => 'Eventcalendar',
        'module_eventcalendar_addons_folder' => 'admin/eventcalendar_addons/',
        'module_eventcalendar_folder_lowercase' => 'eventcalendar',
        'module_eventcalendar_url' => admin_url() . 'module/' . 'eventcalendar' . '/',
        'module_eventcalendar_assets_folder' => base_url(). 'modules/' . 'Eventcalendar' . '/assets/',
        'module_eventcalendar_views_folder' => base_url(). 'modules/' .'Eventcalendar' . '/views/',
    'description' => "Event Calendar module.",
    'author' => "",
    'version' => "",

    'uri' => 'eventcalendar',
    'has_admin'=> TRUE,
    'has_frontend'=> TRUE,
);

return $config['module']['eventcalendar'];