<?php

namespace Fuel\Migrations;

class Create_circles
{
	public function up()
	{
		\DBUtil::create_table('circles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'desc' => array('type' => 'text'),
			'meta' => array('type' => 'text'),
			'status' => array('constraint' => '"public","private","deleted"', 'type' => 'enum'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('circles');
	}
}