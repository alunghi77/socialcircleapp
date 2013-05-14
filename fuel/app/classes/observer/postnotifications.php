<?php

class Observer_PostNotifications extends \Orm\Observer
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

		# submitted --> save notification 

		\Event::trigger('notification_save', array( 
			'user_id' 		=> $this->_user_uid, 
			'post_id' 		=> $model->id,
			'comment_id' 	=> 0,
			'action'		=> 'submitted',
			'content_type'	=> 'post'  
			)
		);

		$user = Model_User::find($model->user_id);

		# --> if new post send notification to moderators

		if ($model->category === 'post' and $model->status === 'pending'){

			\Send::send_app_notification( '100001115283339', array(
						
				'href' 		=> '', 
				'template' 	=> '@['.$user['profile_fields']['fb_id'].'] has submitted a new post "'.Str::truncate($model->title,30,'...').'"', 
				'ref'		=> 'moderate_post'
				
				) 
			);

			// $moderators = \Model_User::query()->where('group','>',50)->get();

			// if ($moderators){

			// 	foreach( $moderators as $moderator){

			// 		\Send::send_app_notification( $moderator->profile_fields['fb_id'], array(
						
			// 			'href' 		=> '', 
			// 			'template' 	=> '@['.$user['profile_fields']['fb_id'].'] has submitted a new post "'.Str::truncate($model->title,30,'...').'"', 
			// 			'ref'		=> 'moderate_post'
						
			// 			) 
			// 		);

			// 	}
			// }

		}
	}

	/**
	 * On delete post
	 *
	 */
	public function after_delete(Orm\Model $model){

		# deleted --> save notification

		\Event::trigger('notification_save', array( 
			'user_id' 		=> $this->_user_uid, 
			'post_id' 		=> $model->id,
			'comment_id' 	=> 0,
			'action'		=> 'deleted',
			'content_type'	=> 'post'  
			)
		);

	}

	/**
	 * On update post
	 *
	 */
	public function before_update(Orm\Model $model)
	{

		if (Input::param("status") !== $model->status ){

			# change_status --> save notification

			\Event::trigger('notification_save', array( 
				'user_id' 		=> $this->_user_uid, 
				'post_id' 		=> $model->id,
				'comment_id' 	=> 0,
				'action'		=> $model->status,
				'content_type'	=> 'post'  
				)
			);

		} else {

			# update post --> save notification

			\Event::trigger('notification_save', array( 
				'user_id' 		=> $this->_user_uid, 
				'post_id' 		=> $model->id,
				'comment_id' 	=> 0,
				'action'		=> 'updated',
				'content_type'	=> 'post'  
				)
			);

		}

	}

	public function after_save(Orm\Model $model)
	{

		$profile_fields = $model->user->profile_fields;

		# on publish --> send app notification to facebook user

		if (Input::param("status") === "public"){

			\Send::send_app_notification( $profile_fields['fb_id'], 
				array(
					'href' 		=> '', 
					'template' 	=> 'Your post '.$model->title.' has been approved', 
					'ref' 		=> 'user_post_approved_'.str_replace('http://gdlnk.to/','',$model->gdlink),
				) 
			);

			# on publish --> Post to users wall if enabled in user settings

			if (isset($profile_fields['post_to_facebook']) and $profile_fields['post_to_facebook'] === "1"){

				$postdata = array(

					'message' 		=> '',
					'caption'    	=> 'Young and Laced Collective',
			 		'link'    		=> Uri::create( $model->gdlink ),
			 		'picture' 		=> Uri::create( $model->media->object['image_src'] ),
			 		'name'    		=> $model->title,
			 		'description'	=> $model->message,
				);

				\Send::send_to_facebook_wall( $profile_fields['fb_id'], $postdata );

			}

		}	

	}

	public function after_update(Orm\Model $model)
	{

		$profile_fields = $model->user->profile_fields;

		# on publish --> send app notification to commenters of the post

		if ($model->status === "public"){

			\Event::trigger('notification_save', array( 
				'user_id' 		=> $model->user_id, 
				'post_id' 		=> $model->id,
				'comment_id' 	=> 0,
				'action'		=> 'approved',
				'content_type'	=> 'post'  
				)
			);
		}
	}

}