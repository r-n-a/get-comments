<?php

/*----------------------------------------------------------------
--------------
Plugin Name: Get comments
Plugin URI: http://www.site.us/
Description: Sample plugin for get comments last comments.
Author: Nicolay Rodionov
Version: 0.1
Author URI: http://www.site.us/
------------------------------------------------------------------
------------*/

include_once('comments.php');
include_once('logic.php');
add_action('widgets_init', 'Get_comments::register_this_widget');
add_action('admin_menu', 'Get_comments::admin_this_widget');
