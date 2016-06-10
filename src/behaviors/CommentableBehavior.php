<?php
/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 14.04.16
 * Time: 16:32
 */

namespace rocketfirm\comments\behaviors;

use rocketfirm\comments\models\Comment;
use yii\base\Behavior;

class CommentableBehavior extends Behavior
{
    public $authorIdentity;
    public $idField = 'id';
    public $commentUrl;
    public $defaultActiveState = true;

    public function events()
    {
        return [
            \yii\db\ActiveRecord::EVENT_BEFORE_DELETE => 'deleteComments'
        ];
    }

    public function deleteComments()
    {
        return Comment::deleteAll([
            'model' => $this->owner->className(),
            'model_id' => $this->owner->id
        ]);
    }

    public function getCommentsCount()
    {
        return Comment::find()
            ->where([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->id
            ])->count();
    }

    public function comment($text, $parentComment = false)
    {
        $params = [
            'text' => $text,
            'is_active' => $this->defaultActiveState,
        ];

        return Comment::newComment($this->owner, $params, $parentComment);
    }

    public function getCommentUrl()
    {
        return $this->commentUrl;
    }


    public function getComments()
    {
        return Comment::find()
            ->where([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->id,
                'is_active' => 1,
            ])->roots()->all();
    }

}