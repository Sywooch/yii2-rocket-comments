<?php

use yii\db\Migration;

class m161128_104922_add_admin_id_column_to_rf_comments_table extends Migration
{
    public function up()
    {
        $this->addColumn('rf_comments', 'admin_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('rf_comments', 'admin_id');
    }
}
