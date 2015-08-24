<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m150722_094438_init extends Migration {

	public function safeUp() {
        $time = time();

        $this->insert('{{%auth_item}}', [
            'name' => 'publisher',
            'type' => '1', // 1 = ROLE, 2 = PERMISSION
            'rule_name' => null,
            'data' => null,
            'created_at' => $time,
            'updated_at' => $time
        ]);

        $this->insert('{{%auth_item}}', [
            'name' => 'reviewer',
            'type' => '1', // 1 = ROLE, 2 = PERMISSION
            'rule_name' => null,
            'data' => null,
            'created_at' => $time,
            'updated_at' => $time
        ]);

        $this->insert('{{%auth_item}}', [
            'name' => 'admin',
            'type' => '1', // 1 = ROLE, 2 = PERMISSION
            'rule_name' => null,
            'data' => null,
            'created_at' => $time,
            'updated_at' => $time
        ]);

        $this->insert('{{%auth_item_child}}', [
            'parent' => 'publisher',
            'child' => 'reviewer'
        ]);
	}

	public function safeDown() {
		$this->delete('{{%auth_item_child}}', ['parent' => 'publisher', 'child' => 'reviewer']);

        $this->truncateTable('{{%auth_assignment}}');

        $this->delete('{{%auth_item}}', ['name' => 'reviewer']);
        $this->delete('{{%auth_item}}', ['name' => 'publisher']);
        $this->delete('{{%auth_item}}', ['name' => 'admin']);
	}
}
