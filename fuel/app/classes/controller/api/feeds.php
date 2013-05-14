<?php

class Controller_Api_Feeds extends Controller_Api
{

	/**
	 * GET /feeds
	 *
	 **/
	public function get_index()
	{

		# - auth
    	
    	# - params


		# - validation
		if ( !($feeds = Model_Feed::query()->get()) )
			return parent::error('Not Found', 404);

		# - prepare response

		# - send response
		return parent::success('Created.', 201, array('data' => Format::forge( $feeds )->to_array() ));

	}

	/**
	 * GET /feeds/<circle_id>
	 *
	 **/
	public function get_id($id = false)
	{
		
		# - auth
    	if ( !($data = Model_Circle::query()
					->related('feeds')
					->related('feeds.media')
					->related('members')
					->related('members.user')
					->related('feeds.comments')
					->related('feeds.user')
					->where('id',$id)
					->order_by('feeds.created_at','desc')
					->get_one()) )
			return parent::error('Not Found', 404);

    	# - params

		# - validation

		# - prepare response

		// print '<pre>';
		// var_dump( $data->feeds );

		// exit();

		$result = array( 
			'id' 		=> $data['id'],
			'name' 		=> $data['name'],
			'meta'		=> $data['meta'],
			'slug' 		=> 'none',
			'members' 	=> array(),  # list of members of the circle
			'feeds' 	=> array(),  # list of feed items
			'status'	=> $data['status'],
			'time_ago'	=> (time() - 24 * 60 * 60 < $data['created_at']) ? Date::time_ago($data['created_at']) : Date::forge($data['created_at'])->format("%d/%m/%Y %H:%M", true),
		);

		# Members
		$members_arr = array();

		if (count( $data->members ) > 0 ){

			foreach( $data->members as $item ){

				$members_arr['data'][] = array(

					'id' => $item->id,
					'created_at' => $item->user->created_at,

				);
			}

			$result['members'] = array( 
				'total' => count($members_arr['data']),
				'data' => $members_arr['data']
			);

		}

		# Feeds
		$feeds_arr = array();

		if (count( $data->feeds ) > 0 ){

			foreach( $data->feeds as $item ){

				$comments = array();

				foreach($item->comments as $comment){

					$comments[] = array(
						'id' => $comment->id,
						'message' 	=> $comment->message,
						'posted_by' =>  array(
							'name' 	=> ucwords($comment->user->username),
						),
						'time_ago' => Date::time_ago($comment->created_at),
					);

				}

				$feeds_arr['data'][] = array(

					'id' 		=> $item->id,
					'message' 	=> $item->message,
					'media' 	=> $item->media,
					'comments'  => $comments,
					'posted_by' => array(
						'id' 	=> $item->user->id,
						'username' => $item->user->username,
						),
					'created_at' => $item->user->created_at,

				);
			}

			$result['feeds'] = array( 
				'total' => count($feeds_arr['data']),
				'data' => $feeds_arr['data']
			);

		}

		$result['created_at'] = $data['created_at'];	

		# - send response
		return parent::success('Created.', 201, array('data' => $result ));

	}

	/**
	 * POST /feeds
	 *
	 **/
	public function post_index()
	{
		# - auth
    	
    	# - params

    	$message	= Input::post('discussion'); 
    	$media_data	= Input::post('media_data'); 
		$circle_id 	= Input::post('circle_id');

		$user_id 	= $this->_uid;
		$status 	= 'public';
		
		# - validation

		$feed 		 		= new Model_Feed();
		$feed->message 		= $message;
		$feed->circle_id 	= $circle_id;
		$feed->user_id    	= $user_id;

		# - resize & crop image data
		$image_sizes 	= $this->save_image($media_data['image_src']);

		$media_data['image_src'] 	= $image_sizes['cropped_mobile']; 
		$media_data['image_sizes'] 	= $image_sizes;

		$feed->media 		= new Model_Media( array('object' => $media_data) );
		$feed->status  		= $status;
		
		$feed->save();

		# - prepare response
		Arr::set($this->_data, 'id', $feed->id); 

		# - send response
		return parent::success('Created.', 201, array('data' => $this->_data));

	}


	/**
	 * POST /feeds/<id>
	 *
	 **/
	public function post_id()
	{




	}


	# save image from url
	private function save_image( $url = null ){

		if (is_null($url))
			return false;

        $post_image  = \Request::forge($url, array('driver' => 'curl', 'set_options' => array(CURLOPT_HEADER => false)))->execute();

        if (is_null($post_image))
			return false;

        $ext         = str_replace('image/','',$post_image->response_info('content_type'));

        $unique_id   = uniqid();

        if (!file_exists( DOCROOT.'files'.DS.'posts' ))
            File::create_dir( DOCROOT.'files'.DS,'posts', 0777 );

        File::create( DOCROOT.'files'.DS.'feeds'.DS,$unique_id.'.'.$ext, $post_image );

        Image::load(DOCROOT.'files'.DS.'feeds'.DS.$unique_id.'.'.$ext)->crop_resize(365,365)->save_pa('cropped_');			# 270px x 170px cropped
		Image::load(DOCROOT.'files'.DS.'feeds'.DS.$unique_id.'.'.$ext)->crop_resize(540,340)->save_pa('cropped_mobile_'); 	# 540px x 340px cropped
		Image::load(DOCROOT.'files'.DS.'feeds'.DS.$unique_id.'.'.$ext)->resize(380,null)->save_pa('resized_'); 				# 360 x ? resized	

        $cropped 		= DS.'files'.DS.'feeds'.DS.'cropped_'.$unique_id.'.'.$ext;	
        $cropped_mobile = DS.'files'.DS.'feeds'.DS.'cropped_mobile_'.$unique_id.'.'.$ext;							
		$resized 		= DS.'files'.DS.'feeds'.DS.'resized_'.$unique_id.'.'.$ext;	
        $original_size  = DS.'files'.DS.'feeds'.DS.$unique_id.'.'.$ext;

        return array( 

        	'cropped' 			=> $cropped,
        	'cropped_mobile' 	=> $cropped_mobile,
        	'resized' 			=> $resized,
        	'original_size' 	=> $original_size

        );

    }

}