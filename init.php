<?php defined('SYSPATH') or die('No direct script access.');

Route::set('twitterfeed', 'twitterfeed')
	->defaults(array(
		'controller' => 'twitterfeed',
		'action'     => 'view',
	));