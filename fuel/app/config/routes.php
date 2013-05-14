<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_404_'   => 'home/404',    // The main 404 route
	
	'login'   	=> 'home/login',
	'logout'  	=> 'home/logout',
	'settings'  => 'home/settings',
	'groups'   	=> 'groups/index',
	'feed'   	=> 'home/feed',

	/* API */
	'api/users/(:num)' 		=> 'api/users/id/$1',
	'api/circles/(:num)' 	=> 'api/circles/id/$1',
	'api/feeds/(:num)' 		=> 'api/feeds/id/$1',
	'api/comments/(:num)' 	=> 'api/comments/id/$1',

);