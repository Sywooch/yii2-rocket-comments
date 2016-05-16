<?php

use yii\db\Migration;

class m160516_144449_add_tree_to_comments extends Migration
{
    public function up()
    {
        $this->addColumn('rf_comments', 'tree', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        return false;
    }
}
