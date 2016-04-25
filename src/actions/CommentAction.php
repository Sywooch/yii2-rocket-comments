<?php

namespace rocketfirm\comments\actions;
use common\models\base\Comment;
use yii\base\Action;
use yii\base\ErrorException;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 14.04.16
 * Time: 18:52
 */
class CommentAction extends Action
{
    public $class;
    public $idField = 'id';

    /**
     * @param int $modelId
     * @param string $text
     * @param bool|int $parentCommentId
     * @param bool|string $returnUrl
     * @param bool|int $authorId
     */
    public function run()
    {

    }
}