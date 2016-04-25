<?php

use yii\db\Migration;

class m160425_103122_create_rf_comment_votes extends Migration
{
    public function up()
    {
        $this->createTable('rf_comment_votes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'comment_id' => $this->integer()->notNull(),
            'upvote' => $this->boolean()->notNull()->defaultValue(1),
            'to_admin' => $this->boolean()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'rf_comment_votes_to_comments', 'rf_comment_votes', ['comment_id'],
            'rf_comments', 'id'
        );

        $this->createIndex('rf_comments_admin_votes', 'rf_comment_votes', 'to_admin');
        $this->createIndex('rf_user_comment_votes', 'rf_comment_votes', ['user_id', 'comment_id']);
    }

    public function down()
    {
        $this->dropForeignKey('rf_comment_votes_to_comments', 'rf_comment_votes');
        $this->dropTable('rf_comment_votes');
    }
}
