<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160414_110135_create_comments extends Migration
{
    public function up()
    {
        $this->createTable('rf_comments', [
            'id' => $this->primaryKey(),
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'model' => Schema::TYPE_STRING . ' NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rating' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'admin_text' => Schema::TYPE_TEXT,
            'admin_rating' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'is_active' => Schema::TYPE_BOOLEAN . ' NOT NULL'
        ]);

        $this->createIndex('rf-model-comments', 'rf_comments', ['model', 'model_id']);
        $this->createIndex('rf-user-comments', 'rf_comments', 'user_id');
        $this->createIndex('rf-comments-created_at', 'rf_comments', 'created_at');
        $this->createIndex('rf-comments-rating', 'rf_comments', 'rating');
    }

    public function down()
    {
        $this->dropTable('rf_comments');
        $this->dropIndex('rf-model-comments', 'rf_comments');
        $this->dropIndex('rf-user-comments', 'rf_comments');
        $this->dropIndex('rf-user-comments', 'rf_comments');
        $this->dropIndex('rf-user-comments', 'rf_comments');
    }
}
