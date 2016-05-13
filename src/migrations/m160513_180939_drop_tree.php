<?php

use yii\db\Migration;

class m160513_180939_drop_tree extends Migration
{
    public function up()
    {
        $this->dropColumn('rf_comments', 'tree');
    }

    public function down()
    {
    }
}
