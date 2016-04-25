<?php
/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 25.04.16
 * Time: 11:41
 */

namespace rocketfirm\comments\models;


use yii\base\Model;

class CommentForm extends Model
{
    public $text;
    public $parentCommentId;
    public $returnUrl;

    public $commentableModel;
    public $modelId;

    public function rules()
    {
        return [
            [['text', 'commentableModel', 'modelId'], 'required'],
            [['text', 'returnUrl'], 'string'],
            [['parentCommentId', 'modelId'], 'integer'],
        ];
    }

    /**
     * @param $commentableModel
     * @return mixed
     */
    public function save()
    {
        $className = $this->commentableModel;

        /**
         * @var $object ActiveRecord
         */
        $object = $className::findOne(['id' => $this->modelId]);

        if (!$object->getBehavior('commentable')) {
            throw new \yii\base\ErrorException(
                'Commentable behavior is not attached to class ' . $className .
                ' (behavior key has to be defined as `commentable`)'
            );
        }

        return $object->comment($this->text, $this->parentCommentId);
    }
}