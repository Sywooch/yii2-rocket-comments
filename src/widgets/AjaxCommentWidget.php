<?php
namespace rocketfirm\comments\widgets;
use yii\base\Widget;

use rocketfirm\comments\models\Comment;
use rocketfirm\comments\models\CommentForm;

/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 25.04.16
 * Time: 12:18
 */
class AjaxCommentWidget extends CommentWidget
{
    public $model;

    public $formModel;

    public $comments;
    public $loginUrl = ['site/login'];
    public $commentUrl = ['comments/actions/post'];

    public $usernameField = 'username';
    public $avatarField = 'image';

    public function init()
    {
        $this->formModel = new CommentForm();
        Comment::checkModel($this->model);
    }

    public function run()
    {
        return $this->render('ajax-comments', $this->params());
    }
}