<?php

class Controller_Api_Users extends Controller_Api
{

	public function post_auth(){

		# - params

		if (Input::post())
    	{

        	if (Auth::login())
        	{

        		return parent::success('OK.', 200);

        	} else {

        		return parent::error('Bad Request.', 401);
        	}

        }

	}


	/**
	 * GET /users
	 *
	 **/
	public function get_index()
	{
		$limit 		= Input::get('limit', 10);
		$offset 	= Input::get('offset', 0);
		
		if ( !($data= Auth\Model\Auth_User::query()
						->related('metadata')
						->offset($offset)
						->limit($limit)
						->get()))
			return parent::error('Not found', 404);

		foreach( $data as $obj ){

			$profile_fields = array( 'id' => $obj->id, 'username' => $obj->username, 'email' =>  $obj->email );

			$profile_fields['created_at'] 	= $obj->created_at;
			$profile_fields['last_login'] 	= $obj->last_login;

			$results[] = $profile_fields;

		}

		$this->_summary['items'] 	= count($data);
		$this->_summary['rpp'] 		= $limit;

		return parent::success('OK.', 200, 
			array(
				'summary'	=> $this->_summary,
				'data'		=> $results )
		);

	}

	/**
	 * GET /users/<id>
	 *
	 **/
	public function get_id( $id = false )
	{

		if (!($user = Auth\Model\Auth_User::find($id)))
			return parent::error('Not Found', 404);

		$result = array();

		$profile_fields = array(
			'id' 		=> $user['id'], 
			'email' 	=> $user['email'], 
			'group' 	=> $user['group'],
			'time_ago' 	=> Date::time_ago($user['last_login']),
		);

		$profile_fields['created_at'] 	= $user['created_at'];
		$profile_fields['last_login'] 	= $user['last_login'];

		return parent::success('OK.', 200, array('data'=> $profile_fields));

	}

	/**
	 * POST /users
	 *
	 * Create User
	 **/
	public function post_index()
	{

		# --> validation

		$to_update = array(

			'fullname' 	=> Input::post('fullname', false),
			'mobile'	=> Input::post('mobile', false), 
			'resources'	=> Input::post('resources', false), 
			'skills' 	=> Input::post('skills', false),

		);

		$username 	  	= Input::post('username'); 
		$password		= Input::post('password'); 
		$email 			= Input::post('email'); 

		$auth = Auth::instance();

		try {


			// create a new user
			$user_id = Auth::create_user(
			    $username,
			    $password,
			    $email,
			    1,
			    $to_update
			);
			
			# If user account created
    		if ( $user_id ) {

    			$data['media_url'] 	= Input::post('media_url',"0");
    			$data['user']['id'] = $user_id;

				# if new profile image

				if ($data['media_url'] !== "0"){

					$profile_pic = $this->save_profile_image($data);

			    	if (!($usermedia = Model_Usermedia::find($user_id))){

			    		$usermedia = new Model_Usermedia( array( 'user_id' => $user_id,'object' => $this->save_profile_image($data) ) );
			    	
			    	} else {

			    		$usermedia->object = $this->save_profile_image($data);

			    	}

			    	$usermedia->save();

			    	return parent::success('OK.', 200, array( 'data' => array( 'id' => $user_id ) ) );

				}

				$this->_data = array( 

					'id' => $user_id,

				);

				return parent::success('Created.', 201, array('data' => $this->_data));

	    	} else {

	    		return parent::error('Could not be created.', 500);
	    		
	    	}

		} catch (\SimpleUserUpdateException $e ) {

	    	return parent::error('Bad Request.', 400, $e->getMessage());
	    }

	}

	/**
	 * POST /users/<id>
	 *
	 * Update User
	 **/
	public function post_id( $id = false )
	{
		
		# Auth

		// if ( !Auth::has_access('users.update') or ((int) $id !== $this->uid) and !Auth::has_access('users.create'))
		// 	return parent::error('Not authorized', 401);

		if (!($user = Auth\Model\Auth_User::find($id)))
			return parent::error('Not Found', 404);


		# params

		$to_update = array(

			'fullname' 	=> Input::post('fullname', false),
			'email' 	=> Input::post('email'),
			'mobile'	=> Input::post('mobile', false), 
			'resources'	=> Input::post('resources', false), 
			'skills' 	=> Input::post('skills', false),

		);

		# Validation

		// $val = Validation::forge('user_update');

		// $val->add_field('name', 'Name', 'required|trim|strip_tags');
		// $val->add_field('profession', 'Specialism','required|trim|strip_tags');
		// $val->add_field('email', 'Specialism','required|trim|strip_tags|valid_email');
		// $val->add_field('bio', 'Bio','required|trim|strip_tags|max_length[300]');

		Auth::update_user($to_update, $user['username']);

		$data['media_url'] 	= Input::post('media_url', "0");

		# if new profile image

		if ($data['media_url'] !== "0"){

			$data['user'] = $user;

			$profile_pic = $this->save_profile_image($data);

	    	if (!($usermedia = Model_Usermedia::find($id))){

	    		$usermedia = new Model_Usermedia( array( 'user_id' => $id,'object' => $this->save_profile_image($data) ) );
	    	
	    	} else {

	    		$usermedia->object = $this->save_profile_image($data);

	    	}

	    	$usermedia->save();

		}

		return parent::success('OK.', 200, array( 'data' => array( 'id' => $id ) ) );

	}

	private function save_profile_image($data){

		# store profile pic locally
		$profile_pic_thumb 	= \Request::forge( $data['media_url'], array('driver' => 'curl', 'set_options' => array(CURLOPT_HEADER => false)))->execute();
		$unique_id 			= Str::random('unique');
		$ext 				= str_replace('image/','',$profile_pic_thumb->response_info('content_type'));

		$path_to_profile 	= DOCROOT.'files'.DS.'profiles'.DS.'user_'.$data['user']['id'];
		$path_to_base		= DOCROOT.'files'.DS.'profiles'.DS;

		if (!file_exists( $path_to_profile )){

			File::create_dir( $path_to_base,'user_'.$data['user']['id'], 0777 );

		} 
			
		File::create( $path_to_profile.DS,$unique_id.'.'.$ext, $profile_pic_thumb );

		Image::load( $path_to_profile.DS.$unique_id.'.'.$ext )
			->crop_resize(50,50)
			->rounded(8, null, 1)
			->save_pa('rounded_');

		return array(
    		'rounded'	=> 'rounded_'.$unique_id.'.'.$ext,
    		'normal'	=> $unique_id.'.'.$ext,
    	);

	}

}
