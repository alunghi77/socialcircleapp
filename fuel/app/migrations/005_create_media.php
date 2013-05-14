<?php

namespace Fuel\Migrations;

class Create_media
{
	public function up()
	{
		\DBUtil::create_table('media', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'feed_id' => array('constraint' => 11, 'type' => 'int'),
			'object' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('media');
	}
}