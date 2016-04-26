<?php

namespace rocketfirm\comments\controllers;
use rocketfirm\comments\models\CommentForm;
use yii\helpers\Url;
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

    public function actionGet()
    {

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

    public function actionRate()
    {

    }
}