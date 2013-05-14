
<?php

class Model_Circles_Member extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'circle_id',
		'user_id',
		'status',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'circles_members';

	protected static $_belongs_to = array(
	    'circle' => array(
	        'key_from' => 'circle_id',
	        'model_to' => 'Model_Circle',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);

	protected static $_has_one = array(
	    'user' => array(
	        'key_from' => 'user_id',
	        'model_to' => 'Auth\Model\Auth_User',
	        'key_to' 	=> 'id',
	        'cascade_save' => false,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    ),
	);
}
