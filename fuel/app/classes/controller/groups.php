<?php

class Controller_Groups extends Controller_Template
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
		$data["subnav"] 	= array('groups'=> 'active' );
		$data["groupnav"] 	= array('index'=> 'active' );
		
		$view 				= View::forge('layout');
		$view->title 		= 'Group';
		$view->nav 			= View::forge('nav', $data);
		$view->content 		= View::forge('groups/index', $data);

		return $view;
	}

	public function action_create()
	{
		$data["subnav"]   = array('groups'=> 'active' );
		$data["groupnav"] = array('create'=> 'active' );
		
		$view 				= View::forge('layout');
		$view->title 		= 'Create';
		$view->nav 			= View::forge('nav', $data);
		$view->content 		= View::forge('groups/create', $data);

		return $view;
	}

	public function action_invite()
	{
	
		$data["subnav"]   = array('groups'=> 'active' );
		$data["groupnav"] = array('invite'=> 'active' );
		
		$view = View::forge('layout');
		$view->title 	= 'Invite';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('groups/invite', $data);

		return $view;
	}

	public function action_list()
	{
		$data['subnav']   = array('groups'=> 'active' );
		$data['groupnav'] = array('list'=> 'active' );
		$data['circles']  = Model_Circle::query()->get();
		
		$view = View::forge('layout');
		$view->title 	= 'List';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('groups/list', $data);

		return $view;
	}

}