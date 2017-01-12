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
    
    public $commentClass = '\rocketfirm\comments\models\Comment';

    public function events()
    {
        return [
            \yii\db\ActiveRecord::EVENT_BEFORE_DELETE => 'deleteComments'
        ];
    }

    public function deleteComments()
    {
        $commentClass = $this->commentClass;
        $comments = $commentClass::find()->where([
            'model' => $this->owner->className(),
            'model_id' => $this->owner->id,
        ])->roots()->all();

        foreach ($comments as $comment) {
            $comment->deleteWithChildren();
        }
    }

    public function getCommentsCount()
    {
        $commentClass = $this->commentClass;
        return $commentClass::find()
            ->where([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->id
            ])->count();
    }

    public function comment($text, $parentComment = false)
    {
        $commentClass = $this->commentClass;
        $params = [
            'text' => $text,
            'is_active' => $this->defaultActiveState,
        ];

        return $commentClass::newComment($this->owner, $params, $parentComment);
    }

    public function getCommentUrl()
    {
        return $this->commentUrl;
    }


    public function getComments()
    {
        $commentClass = $this->commentClass;
        return $commentClass::find()
            ->where([
                'model' => $this->owner->className(),
                'model_id' => $this->owner->id,
                'is_active' => 1,
            ])->roots()->all();
    }

}
