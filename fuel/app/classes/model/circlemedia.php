
<?php

class Model_Circlemedia extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'circle_id',
		'type',
		'object',
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
		'Observer_MediaObjectEncode'
	);
	protected static $_table_name = 'circlemedia';

	protected static $_belongs_to = array(
	    'circle' => array(
	        'key_from' => 'circle_id',
	        'model_to' => 'Model_Circle',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);

}
