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

		$val = Validation::forge('create_user');

		$val->add_field('name', 'Name', 'required|trim|strip_tags');
		$val->add_field('profession', 'Specialism','required|trim|strip_tags');
		$val->add_field('email', 'Specialism','required|trim|strip_tags|valid_email');
		$val->add_field('bio', 'Bio','required|trim|strip_tags|max_length[300]');
		$val->add_field('group', 'Group','required');

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
			    array(
			        'testmeta' => $username.' + '.$email,
			    )
			);
			
			# If user account created
    		if ( $user_id ) {

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
		if ( !Auth::has_access('users.update') or ((int) $id !== $this->uid) and !Auth::has_access('users.create'))
			return parent::error('Not authorized', 401);

		if ( !($user = Model_User::find($id)) )
			return parent::error('Not Found', 404);

		$val = Validation::forge('user_update');

		$val->add_field('name', 'Name', 'required|trim|strip_tags');
		$val->add_field('profession', 'Specialism','required|trim|strip_tags');
		$val->add_field('email', 'Specialism','required|trim|strip_tags|valid_email');
		$val->add_field('bio', 'Bio','required|trim|strip_tags|max_length[300]');

		if ($val->run()){

			$name 				= Input::post('name');
			$profession 		= Input::post('profession');
			$email 				= Input::post('email'); 
			$bio 				= Input::post('bio'); 
			$post_to_facebook 	= Input::post('post_to_facebook'); 
			$group 				= Input::post('group');
			$media_url 			= Input::post('media_url');

			# If admin user then allow to update group and use first and last name fields
			if (Auth::has_access('users.create') and (int) $id !== $this->uid)
				$user->group= isset($group) ? $group : $user->group;

			# update user profile pic
			
			if ($media_url !== "false"){

				# store profile pic locally
				$profile_pic_thumb 	= \Request::forge($media_url, array('driver' => 'curl', 'set_options' => array(CURLOPT_HEADER => false)))->execute();
				$unique_id 			= Str::random('unique');
				$ext 				= str_replace('image/','',$profile_pic_thumb->response_info('content_type'));

				$path_to_profile 	= DOCROOT.'files'.DS.'profile_'.$user['profile_fields']['fb_id'].DS;

				if (!file_exists( $path_to_profile ))
					File::create_dir( $path_to_profile , 0777 );
				
				File::create( $path_to_profile.DS,$unique_id.'.'.$ext, $profile_pic_thumb );

				Image::load( $path_to_profile.DS.$unique_id.'.'.$ext )
					->crop_resize(50,50)
					->rounded(8, null, 1)
					->save_pa('rounded_');

				$profile_pic = array(
		    		'rounded'	=> 'rounded_'.$unique_id.'.'.$ext,
		    		'normal'	=> $unique_id.'.'.$ext,
		    	);

		    	$user->profile_fields = array_merge( 
		    		$user->profile_fields, 
					array(
						'profile_pic' => $profile_pic,
					)
				);

			}

			$user->profile_fields = array_merge( $user->profile_fields, 
				array(
					'name' => $name,
					'bio' => $bio,
					'post_to_facebook' => $post_to_facebook,
					'profession' => $profession,
				)
			);

			$user->email = $email;
			$user->save();

			$this->_data = array( 

				'id' => $user->id,

			);

			return parent::success('OK.', 200, array( 'data' => $this->_data ) );

		} 

	}

}
