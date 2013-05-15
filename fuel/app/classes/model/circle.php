
<?php

class Model_Circle extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'desc',
		'meta',
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
	protected static $_table_name = 'circles';

	protected static $_has_many = array(
	    'members' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Circles_Member',
	        'key_to' 	=> 'circle_id',
	        'cascade_save' => false,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    ),
	    'feeds' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Feed',
	        'key_to' 	=> 'circle_id',
	        'cascade_save' => false,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    ),
	    'circlemedia' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Circlemedia',
	        'key_to' 	=> 'circle_id',
	        'cascade_save' => false,
	        'cascade_delete' => true,
	        'conditions' => array(
	            'join_type' => 'left',
	        ),
	    ),
	);

}
