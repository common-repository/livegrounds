<?php

error_reporting(0);
/* 
 | Filnamn: lg_settings.php
 | Beskrivning: Inställningar för wp-plugin.
 */

// Livegrounds server.
$lg_server = "www.livegrounds.com";
$lg_server_url = "http://" . $lg_server . "/lg_serversep2008";
 
/* Default settings that can be change later by the WP admin 
   from the livegrounds option panel. */
$lg_allow_anonymous_uploads = 1;
$lg_users_always_visible = 0;
$lg_pa_max_length = 100;
$lg_siteowner_email = "";

/* Other settings that shouldnt need to be changed.
   If they absolutely need to be changed they can be
   edited through this file. */
$plugin_url = get_bloginfo('wpurl') . "/wp-content/plugins/livegrounds";
$lg_version = "0.42";
$lg_options_editable = 'no';

/* Number of squares, horizontally and vertically, in which avatars can be placed.
   The scene consists of a grid where avatars can be placed. The row furthest
   away from the camera (with the smallest avatars) is row 0, and the row
   closest to the camera is row (scene_grid_height - 1). This is because
   when the scene is full, new avatars is placed on a new row that emerges
   closest to the camera = row number scene_grid_height for the first new row.
   The leftmost cell on each row is column 0 and the rightmost cell on each
   row is column (scene_grid_width - 1). */
$lg_scene_grid_width = 8;
$lg_scene_grid_height = 8;

$lg_max_avatars_in_grid_row = 5;
$lg_table = "lg_crowd";
$lg_table_refresh = "lg_refresh";


// Make sure the settings is stored in WP. If they dont
// exist already we create them and set them to the above
// default values. 
if (!get_option('lg_scene_grid_width')) {
	add_option('lg_scene_grid_width', $lg_scene_grid_width, 
		'max avatars on one row');
}
if (!get_option('lg_scene_grid_height')) {
	add_option('lg_scene_grid_height', $lg_scene_grid_height,
		'max rows on the scene');
}
if (!get_option('lg_max_avatars_in_grid_row')) {
	add_option('lg_max_avatars_in_grid_row', $lg_max_avatars_in_grid_row, 
		'max avatars on one row when they are randomly positioned');
}
if (!get_option('lg_options_editable')) {
	add_option('lg_options_editable', $lg_options_editable, 
		'yes if users of wp should be able to change option value');
}
if (!get_option('lg_allow_anonymous_uploads')) {
	add_option('lg_allow_anonymous_uploads', $lg_allow_anonymous_uploads, 
		'yes if anonymous users should be able to upload files.');
}
if (!get_option('lg_users_always_visible')) {
	add_option('lg_users_always_visible', $lg_users_always_visible,
		'yes if users should always be visible on the ground.');
}
if(!get_option('lg_pa_max_length')) {
	add_option('lg_pa_max_length', $lg_pa_max_length,
		'Max length of public announcement messages.');
}
if(!get_option('lg_siteowner_email')) {
	add_option('lg_siteowner_email', $lg_siteowner_email,
		'Email address of the site owner.');
}

/* Om inte ett blog-ID finns så genereras ett första gången men
   aldrig senare och ska aldrig tas bort. Blog-ID används vid
   all skickning/mottagning till/från livegrounds-servern. */
if(!get_option('lg_blog_id')){
	add_option('lg_blog_id', md5(uniqid(rand())), 'Livegrounds Blog-ID');
}

/* Ett tomt lösenord här betyder inte att det går att logga in som site owner utan
   lösenord, bara att det är inaktiverat som default tills ägaren anger email+lösen
   i wp-admin -> options -> Livegrounds. */
if(!get_option('lg_siteowner_password')) {
	add_option('lg_siteowner_password', "",'');
}
?>