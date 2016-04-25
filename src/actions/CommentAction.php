<?php

namespace rocketfirm\comments\actions;
use rocketfirm\comments\models\CommentForm;
use yii\base\Action;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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
     */
    public function run($modelId)
    {
        if (!$this->class) {
            throw new \yii\base\ErrorException('Commentable class not specified');
        }

        $request = \Yii::$app->request;

        if ($request->isPost) {
            $className = $this->class;

            /**
             * @var $object ActiveRecord
             */
            $object = $className::findOne([$this->idField => $modelId]);

            if (!$object->getBehavior('commentable')) {
                throw new \yii\base\ErrorException(
                    'Commentable behavior is not attached to class ' . $className .
                    ' (behavior key has to be defined as `commentable`)'
                );
            }

            $comment = new CommentForm();

            if ($comment->load($request->post()) && $comment->save($object))
            {
                if ($comment->returnUrl) {
                    return \Yii::$app->controller->redirect($comment->returnUrl);
                } else {
                    return \Yii::$app->controller->redirect(Url::previous());
                }
            }
        } else {
            throw new \yii\base\ErrorException('Only POST requests are allowed');
        }
    }
}