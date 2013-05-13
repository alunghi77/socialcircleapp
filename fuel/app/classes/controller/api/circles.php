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

		# - validation

		$circle 		 = new Model_Circle();
		$circle->name 	 = $name;
		$circle->desc 	 = $desc;
		$circle->meta    = $meta;
		$circle->status  = $status;
		
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
	public function post_id()
	{




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

}