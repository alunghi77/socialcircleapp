
<?php

class Model_Feed extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'circle_id',
		'user_id',
		'message',
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
	protected static $_table_name = 'feeds';

	protected static $_has_many = array(
	    'comments' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Feed_Comment',
	        'key_to' 	=> 'feed_id',
	        'cascade_save' => false,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    )
	);

	protected static $_has_one = array(
	    'media' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Media',
	        'key_to' => 'feed_id',
	        'cascade_save' => true,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    ),
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
