<?php

namespace rocketfirm\comments\controllers;
use rocketfirm\comments\models\Comment;
use rocketfirm\comments\models\CommentForm;
use rocketfirm\comments\widgets\AjaxCommentWidget;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 25.04.16
 * Time: 13:57
 */
class ActionsController extends Controller
{
    public function init()
    {
        parent::init();
    }

    public function actionGet()
    {
        $request = \Yii::$app->request;

        if ($request->isPost) {
            if (!isset($request->post()['model'])) {
                throw new \yii\base\ErrorException('Model attribute missing');
            }

        } else {
            throw new \yii\base\ErrorException('Only POST requests are allowed');
        }
    }

    public function actionPost()
    {
        $request = \Yii::$app->request;

        $redirectUrl = \Yii::$app->controller->redirect(Url::previous());

        if ($request->isPost) {
            $comment = new CommentForm();

            if ($comment->load($request->post()) && $comment->save())
            {
                if ($comment->returnUrl) {
                    $redirectUrl = \Yii::$app->controller->redirect($comment->returnUrl);
                }
            }
        } else {
            throw new \yii\base\ErrorException('Only POST requests are allowed');
        }
        return $redirectUrl;
    }

    /**
     * Метод для оценки комментариев
     *
     * @param $id
     * @param bool $upVote
     *
     * @return array
     */
    public function actionRate($id, $upVote = true)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        /**
         * @var $comment Comment
         */
        $comment = Comment::findOne(['id' => $id]);

        if (\Yii::$app->user->isGuest) {
            $comment->vote(\Yii::$app->user->id, $upVote);
        }

        return ['id' => $comment->id, 'rating' => $comment->rating];
    }
}