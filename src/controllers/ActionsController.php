<?php

namespace rocketfirm\comments\controllers;
use yii\web\Controller;

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

    public function actionPost()
    {
        if (!$this->class) {
            throw new \yii\base\ErrorException('Commentable class not specified');
        }

        $request = \Yii::$app->request;

        if ($request->isPost) {
            $comment = new CommentForm();

            if ($comment->load($request->post()) && $comment->save())
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