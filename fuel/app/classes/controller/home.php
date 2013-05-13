<?php

class Controller_Home extends Controller_Template
{

	public function action_index()
	{
		$data["subnav"] = array('home'=> 'active' );

		$view = View::forge('layout');
		$view->title 	= 'Home';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/index', $data);

		return $view;
	}
	
	public function action_login()
	{
		$data["subnav"] = array('login'=> 'active' );

		$view = View::forge('layout');
		$view->title 	= 'Login';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/login', $data);

		return $view;
	}

	public function action_logout()
	{

		$auth = Auth::instance();

		if ( $auth->logout() ){
			
			Response::redirect('/');

		}
	}

	public function action_settings()
	{
		$data["subnav"] = array('settings'=> 'active' );

		$view = View::forge('layout');
		$view->title 	= 'Settings';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/settings', $data);

		return $view;
	}

	public function action_feed()
	{
		$data["subnav"] 	= array('feed'=> 'active' );
		$data['circles']  	= Model_Circle::query()->get();

		$view = View::forge('layout');
		$view->title 	= 'Feed';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/feed', $data);

		return $view;
	}

}
