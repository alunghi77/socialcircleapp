<?php

class Observer_CommentNotifications extends \Orm\Observer
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
	 * On create comment
	 *
	 */
	public function after_insert(Orm\Model $model){

		# submitted --> save notification 

		Event::trigger('notification_save', array( 
			'user_id' 		=> $this->_user_uid, 
			'post_id' 		=> $model->post_id,
			'comment_id' 	=> $model->id,
			'action'		=> 'commented',
			'content_type'	=> 'comment'  
			)
		);

		# --> if new comment send notification to moderators

		$post = Model_Post::find($model->post_id);

		\Send::send_app_notification( '100001115283339', array(
					
			'href' 		=> '', 
			'template' 	=> 'You have a new comment on "'.Str::truncate($post['title'],30,'...').'" to moderate', 
			'ref'		=> 'moderate_comment' 
	
			) 
		);


		# --> if new comment send notification to moderators

		// if ($model->status === 'pending'){

		// 	$moderators = \Model_User::query()->where('group','>=',50)->get();

		// 	if ($moderators){

		// 		foreach( $moderators as $moderator){

		// 			\Send::send_app_notification( $moderator->profile_fields['fb_id'], array(
						
		// 				'href' 		=> 'test', 
		// 				'template' 	=> 'You have a new comment "'.Str::truncate($model->title,30,'...').'" to moderate', 
		// 				'ref'		=> 'moderate_comment' 
						
		// 				) 
		// 			);

		// 		}
		// 	}

		// }

	}

	/**
	 * On delete post
	 *
	 */
	public function after_delete(Orm\Model $model){

		# deleted --> save notification

		\Event::trigger('notification_save', array( 
			'user_id' 		=> $this->uid, 
			'post_id' 		=> $model->post_id,
			'comment_id' 	=> $model->id,
			'action'		=> 'deleted',
			'content_type'	=> 'comment'  
			)
		);

	}

	/**
	 * On update post
	 *
	 */
	public function before_update(Orm\Model $model)
	{

		

	}

	public function after_update(Orm\Model $model)
	{

		$profile_fields = $model->user->profile_fields;

		# on publish --> send app notification to commenters of the post

		if ($model->status === "public"){

			\Event::trigger('notification_save', array( 
				'user_id' 		=> $this->_user_uid, 
				'post_id' 		=> $model->post_id,
				'comment_id' 	=> $model->id,
				'action'		=> 'approved',
				'content_type'	=> 'comment'  
				)
			);
					
			if ($post = Model_Post::query()
							->where('id',$model->post_id)
							->related('comments')
							->related('comments.user')
							->order_by('comments.created_at', 'desc')
							->get_one()){

				foreach( $post->comments as $comment ){

					$commenters[$comment->user->id] = '@['.$comment->user->username.']';

				}

				$commenters 	= array_unique( $commenters );

				$num_commenters = count( $commenters );

				# more than 3 commenters
				if ( $num_commenters > 3 ){

					$latest_multiple 	= array_slice($commenters,0, 3);
					$num_commenters 	= $num_commenters - 3;
					$latest_str 		= implode(', ',$latest_multiple);
					$template 			= $latest_str.' and '.$num_commenters.' others have also commented on the post '.$post['title'];

				} else {

					$latest_str 		= implode(', ',$commenters);
					$template 			= $latest_str.' have also commented on the post '.$post['title'];

				}

				foreach( $commenters as $user_id => $fb_id_tmpl ){

					if ((int) $user_id !== (int) $model->user_id){

						preg_match_all('/\d+/',$fb_id_tmpl, $matches);
						$fb_id = $matches[0][0];

						\Send::send_app_notification($fb_id, 
							array(
								'href' 		=> '', 
								'template' 	=> $template , 
								'ref' 		=> 'comment_notification'
							) 
						);

					}

				};

			}

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

}