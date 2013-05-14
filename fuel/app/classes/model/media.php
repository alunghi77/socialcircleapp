
<?php

class Model_Media extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'feed_id',
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
	protected static $_table_name = 'media';

	protected static $_belongs_to = array(
	    'feed' => array(
	        'key_from' => 'feed_id',
	        'model_to' => 'Model_Feed',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);


}
