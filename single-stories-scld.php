<?php
/**
 * Infinity Pro.
 *
 * This file adds the single post template to the Infinity Pro Theme.
 * 
 * Template Name: Single Story
 *
 *
 * @package Infinity
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/infinity/
 */


 remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_header', 'genesis_do_post_title');

genesis();