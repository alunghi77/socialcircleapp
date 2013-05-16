<?php

class Controller_Circles extends Controller_Template
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
		$data['subnav']   	= array('groups'=> 'active' );
		$data['groupnav'] 	= array('list'=> 'active' );

		View::set_global('pageclass', 'circle_page');

		$data['circles']  = Model_Circle::query()
								->related('members')
								->related('members.user')
								->related('circlemedia')
								->order_by('created_at', 'desc')
								->get();

		
		$view = View::forge('layout');
		$view->title 	= 'List';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('circles/list', $data);

		return $view;
	}

	public function action_create()
	{
		$data["subnav"]   	= array('groups'=> 'active' );
		$data["groupnav"] 	= array('create'=> 'active' );

		View::set_global('pageclass', 'circle_page');
		
		$view 				= View::forge('layout');
		$view->title 		= 'Create';
		$view->nav 			= View::forge('nav', $data);
		$view->content 		= View::forge('circles/create', $data);

		return $view;
	}

	public function action_edit($id = false)
	{
		if((!$circles = Model_Circle::query()
							->related('members')
							->related('members.user')
							->related('circlemedia')
							->where('id',$id)
							->get_one()))
			return Response::forge(View::forge('errors/404'), 404);

		$data["subnav"]   	= array('groups'=> 'active' );
		$data["groupnav"] 	= array('create'=> 'active' );
		$data["circle"] 	= $circles;

		View::set_global('pageclass', 'circle_page');
		
		$view 				= View::forge('layout');
		$view->title 		= 'Create';
		$view->nav 			= View::forge('nav', $data);
		$view->content 		= View::forge('circles/edit', $data);

		return $view;
	}

	public function action_invite()
	{
	
		$data["subnav"]   	= array('groups'=> 'active' );
		$data["groupnav"] 	= array('invite'=> 'active' );
		
		View::set_global('pageclass', 'circle_page');
		
		$view = View::forge('layout');
		$view->title 	= 'Invite';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('circles/invite', $data);

		return $view;
	}

	public function action_list()
	{
		$data['subnav']   	= array('groups'=> 'active' );
		$data['groupnav'] 	= array('list'=> 'active' );

		View::set_global('pageclass', 'circle_page');

		$data['circles']  = Model_Circle::query()
								->related('members')
								->related('members.user')
								->related('circlemedia')
								->order_by('created_at', 'desc')
								->get();

		
		$view = View::forge('layout');
		$view->title 	= 'List';
		$view->nav 		= View::forge('nav', $data);
		$view->content 	= View::forge('circles/list', $data);

		return $view;
	}

}