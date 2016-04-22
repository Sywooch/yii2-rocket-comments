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
        return Comment::newComment($this->owner, $text, $parentComment, false, $this->idField);
    }


}