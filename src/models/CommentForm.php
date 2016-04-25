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

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text', 'returnUrl'], 'string'],
            [['parentCommentId'], 'integer'],
        ];
    }

    /**
     * @param $commentableModel
     * @return mixed
     */
    public function save($commentableModel)
    {
        return $commentableModel::comment($this->text, $this->parentCommentId);
    }
}