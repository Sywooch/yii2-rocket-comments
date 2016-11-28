<?php

use yii\db\Migration;

class m161013_182522_update_votes_foreign_key extends Migration
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
