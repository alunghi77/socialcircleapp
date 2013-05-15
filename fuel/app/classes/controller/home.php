<?php

class Controller_Home extends Controller_Template
{

	public function before(){

		if( Auth::check() ){

			$media_url 	= '/assets/img/default_profile.gif';

			list(, $userid) = Auth::get_user_id();
			if ($usermedia 	= Model_Usermedia::query()->where('user_id',$userid)->get_one() )
	  			$media_url 	= '/files/profiles/user_'.$userid.'/'.$usermedia->object['rounded'];	

	      	View::set_global('current_user_fullname', Auth::get_profile_fields('fullname'));
	      	View::set_global('media_url', $media_url);
			
	    } 

		parent::before();
	}

	public function action_index()
	{
		$data["subnav"] 	= array('home'=> 'active' );

		View::set_global('pageclass', 'home_page');

		$view = View::forge('layout');
		$view->title 	= 'Home';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/index', $data);

		return $view;
	}
	
	public function action_login()
	{
		$data["subnav"] 	= array('login'=> 'active' );

		View::set_global('pageclass', 'login_page');

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
		$data["subnav"] 	= array('settings'=> 'active' );

		View::set_global('pageclass', 'settings_page');

		$user       		= \Auth::instance()->get_user_id();

        $data['user'] 		= Auth\Model\Auth_User::find($user[1]);

        $data['usermedia']  = Model_Usermedia::query()->where('user_id',$user[1])->get_one();

		$view = View::forge('layout');
		$view->title 	= 'Settings';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/settings', $data);

		return $view;
	}

	public function action_feed()
	{
		$data["subnav"] 	= array('feed'=> 'active' );
		
		View::set_global('pageclass', 'feed_page');

		$data['circles']  	= Model_Circle::query()->get();

		$view = View::forge('layout');
		$view->title 	= 'Feed';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('page/feed', $data);

		return $view;
	}

}
