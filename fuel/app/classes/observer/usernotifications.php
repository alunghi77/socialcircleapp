<?php

class Observer_UserNotifications extends \Orm\Observer
{
	/**
	 * Currently logged in user id
	 *
	 */
	private $_user_uid;

	public function __construct(){

		$user     	= \Auth::instance()->get_user_id();
        $this->_user_uid  	= $user[1];
	}

	/**
	 * On create post
	 *
	 */
	public function after_insert(Orm\Model $model){

		# on create --> save notification

		\Event::trigger('notification_save', array( 
			'user_id' 		=> $model->id, 
			'post_id' 		=> 0,
			'comment_id' 	=> 0,
			'action'		=> 'created',
			'content_type'	=> 'user'  
			)
		);

	}

	/**
	 * On update post
	 *
	 */
	public function before_update(Orm\Model $model)
	{

		# on update --> save notification

		Event::trigger('notification_save', array( 
			'user_id' 		=> $model->id, 
			'post_id' 		=> 0,
			'comment_id' 	=> 0,
			'action'		=> 'updated',
			'content_type'	=> 'user'  
			)
		);
		
	}

}