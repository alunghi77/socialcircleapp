<?php

class Controller_Api_Circles extends Controller_Api
{

	/**
	 * GET /circles
	 *
	 **/
	public function get_index()
	{

		# - auth
    	
    	# - params


		# - validation

		$circles = Model_Circle::query()->get();

		# - prepare response

		# - send response
		return parent::success('Created.', 201, array('data' => Format::forge( $circles )->to_array() ));

	}

	/**
	 * GET /circles
	 *
	 **/
	public function get_id()
	{

		# - auth
		if((!$circles = Model_Circle::query()
							->related('members')
							->related('members.user')
							->related('circlemedia')
							->where('id',$id)
							->get_one()))
			return parent::error('Not found', 404);
    	
    	# - params


		# - validation

		# - prepare response

		circle

		# - send response
		return parent::success('Created.', 201, array('data' => Format::forge( $circles )->to_array() ));


	}

	/**
	 * POST /circles
	 *
	 **/
	public function post_index()
	{

		# - auth
    	
    	# - params

    	$name		= Input::post('name');
		$desc 		= Input::post('desc');
		$meta   	= Input::post('meta', 'empty');
		$status 	= Input::post('status','public');
		$invitees 	= Input::post('invitees', array()); #list of user ids
		$data['media_url']	= Input::post('media_url',"0");

		# - validation

		$circle 		 = new Model_Circle();
		$circle->name 	 = $name;
		$circle->desc 	 = $desc;
		$circle->meta    = $meta;
		$circle->status  = $status;

		$circle->save();

		$data['circle']['id'] = $circle->id;

		$circle->circlemedia[] = new Model_Circlemedia( array(
			'object' 	=> $this->save_profile_image($data),
			'type' 		=> 'profile',
		));

		$circle->save();
		
		foreach($invitees as $user_id){

			$circle->members[] = new Model_Circles_Member( 
				array(
				'user_id' => $user_id,
				'status'  => 'pending', 
				)
			);

		}

		# add user that created circle
		$circle->members[] = new Model_Circles_Member( 
			array(
			'user_id' => $this->_uid,
			'status'  => 'approved', 
			)
		);
		
		$circle->save();

		# - prepare response
		Arr::set($this->_data, 'id', $circle->id); 

		# - send response
		return parent::success('Created.', 201, array('data' => $this->_data));

	}


	/**
	 * POST /circles/<id>
	 *
	 **/
	public function post_id( $id = false )
	{
		# Auth

		if((!$circle = Model_Circle::query()
							->related('members')
							->related('members.user')
							->related('circlemedia')
							->where('id',$id)
							->get_one()))
			return parent::error('Not found', 404);

		# Params

		$name		= Input::post('name');
		$desc 		= Input::post('desc');
		$meta   	= Input::post('meta', 'empty');
		$status 	= Input::post('status','public');
		$invitees 	= Input::post('invitees', array()); #list of user ids
		$data['media_url']	= Input::post('media_url',"0");

		# Model

		$circle->name 	 = $name;
		$circle->desc 	 = $desc;
		$circle->meta    = $meta;
		$circle->status  = $status;

		$data['circle']['id'] 	= $id;

		# if new profile image
		if ($data['media_url'] !== "0"){

			$circle->circlemedia[] = new Model_Circlemedia( array(
				'object' 	=> $this->save_profile_image($data),
				'type' 		=> 'profile',
			));

		}

		$circle->save();

		# - prepare response
		Arr::set($this->_data, 'id', $id); 

		# - send response
		return parent::success('OK.', 200, array('data' => $this->_data));

	}

	/**
	 * POST /circles/<id>/join
	 *
	 **/
	public function post_join($id = false)
	{

		# - auth
    	
    	# - params

    	$name	= Input::post('name');
		$desc 	= Input::post('desc');
		$meta   = Input::post('meta', 'empty');
		$status = Input::post('status','public');

		# - validation

		$circlemember 				= new Model_Circles_Member();
		$circlemember->user_id 		= $this->_uid;
		$circlemember->circle_id 	= $id;
		$circlemember->status 		= 'pending';

		$circlemember->save();

		# - prepare response
		Arr::set($this->_data, 'id', $circlemember->id); 

		# - observer
		// send notification to group members

		# - send response
		return parent::success('Created.', 201, array('data' => $this->_data));

	}


	private function save_profile_image($data){

		# store profile pic locally
		$profile_pic_thumb 	= \Request::forge( $data['media_url'], array('driver' => 'curl', 'set_options' => array(CURLOPT_HEADER => false)))->execute();
		$unique_id 			= Str::random('unique');
		$ext 				= str_replace('image/','',$profile_pic_thumb->response_info('content_type'));

		$path_to_profile 	= DOCROOT.'files'.DS.'circles'.DS.'circle_'.$data['circle']['id'];
		$path_to_base		= DOCROOT.'files'.DS.'circles'.DS;

		if (!file_exists( $path_to_profile )){

			File::create_dir( $path_to_base,'circle_'.$data['circle']['id'], 0777 );

		} 
			
		File::create( $path_to_profile.DS,$unique_id.'.'.$ext, $profile_pic_thumb );

		Image::load( $path_to_profile.DS.$unique_id.'.'.$ext )
			->crop_resize(80,80)
			->rounded(8, null, 1)
			->save_pa('rounded_');

		return array(
    		'rounded'	=> 'rounded_'.$unique_id.'.'.$ext,
    		'normal'	=> $unique_id.'.'.$ext,
    	);

	}

}