<?php

namespace Fuel\Migrations;

class Create_feeds
{
	public function up()
	{
		\DBUtil::create_table('feeds', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'circle_id' => array('constraint' => 11, 'type' => 'int'),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'message' => array('type' => 'text'),
			'status' => array('constraint' => '"public","private","deleted"', 'type' => 'enum'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('feeds');
	}
}