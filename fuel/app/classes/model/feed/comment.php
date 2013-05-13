
<?php

class Model_Feed_Comment extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'feed_id',
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
	protected static $_table_name = 'feed_comments';

}
