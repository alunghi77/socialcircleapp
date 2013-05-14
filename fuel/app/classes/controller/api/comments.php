<?php

class Controller_Api_Comments extends Controller_Api
{

	public function get_index(){

		return parent::error('Method not allowed.', 405);

	}

	/**
	 * GET /comments/<feed_id>
	 *
	 * Get all comments for post <post_id>
	 *
	 * @param $post_id
	 *
	 **/
	public function get_id( $feed_id = false ){

		$status 	= Input::get('status', 'public');
		$limit  	= Input::get('limit', false);
		$offset 	= Input::get('offset', false);

		$comments 	= Model_Feed_Comment::query()
						->where('status',$status)
						->related('user')
						->where('feed_id',$feed_id)
						->order_by('created_at','asc');
		if($offset)
			$comments->offset($offset);

		if($limit)
			$comments->limit($limit);
		
		$comments = $comments->get();

		if( !$comments )
			return parent::error('Not Found.', 404);
	
		$comments_arr = array();

		foreach( $comments as $comment ){

			$comments_arr[] = array(

				'id' => $comment->id,
				'message' 	=> $comment->message,
				'posted_by' =>  array(
					'name' 		=> ucwords($comment->user->username),
					// 'user_id' 	=> $comment->user->id,
					// 'fb_id' 	=> $comment->user->profile_fields['fb_id'],
					// 'profile_pic_url' => $comment->user->profile_fields['profile_pic'],
				),
				'created_at' => Date::time_ago($comment->created_at),

			);

		}

		return parent::success('OK.', 200, array('data' => $comments_arr));

	}

	#####################
	#
	# Error
	#
	#####################

	/**
	 * DELETE /comments/<id>
	 *
	 * Delete comment at <id>
	 *
	 * @param $id
	 *
	 **/
	public function delete_id( $id = false ){

		if (!Auth::has_access('comments.delete'))
			return parent::error('Unauthorized', 401);
			
		if( !$comment = Model_Comment::find($id) )
			return parent::error('Not Found', 404);
		
		$comment->delete(true);

		return parent::success('OK.', 200 );

	}


	/**
	 * POST /comments/<feed_id>
	 *
	 * Creates a new comment for post <feed_id>
	 *
	 * @param $post_id
	 *
	 **/
	public function post_id( $feed_id = false )
	{
	
		if (!($post = Model_Feed::find($feed_id)))
			return parent::error('Not Found', 404);

		$comment 			= new Model_Feed_Comment();
		$comment->user_id 	= $this->_uid;	
		$comment->feed_id 	= $feed_id;	
		$comment->message 	= Input::post('message');
		$comment->status 	= 'public';
		$comment->save();

		$this->_data = array( 

			'id' => $comment->id,
			'message' 	=> $comment->message,
			'posted_by' =>  array(
				'name' 		=> ucwords($comment->user->username),
					// 'user_id' 	=> $comment->user->id,
					// 'fb_id' 	=> $comment->user->profile_fields['fb_id'],
					// 'profile_pic_url' => $comment->user->profile_fields['profile_pic'],
			),
			'created_at' => Date::time_ago($comment->created_at),

		);

		return parent::success('Created.', 201, array('data' => $this->_data));

	}

}
