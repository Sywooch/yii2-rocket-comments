<?php

use yii\db\Migration;

class m160425_103122_create_rf_comment_votes extends Migration
{
    public function up()
    {
        $this->dropForeignKey('rf_comment_votes_to_comments', 'rf_comment_votes');

        $this->addForeignKey(
            'rf_comment_votes_to_comments', 'rf_comment_votes', ['comment_id'],
            'rf_comments', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        return false;
    }
}
