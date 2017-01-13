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
class CommentWidget extends Widget
{
    public $model;

    public $formModel;

    public $comments;
    public $loginUrl = ['site/login'];
    public $commentUrl = ['comments/actions/post'];

    public $usernameField = 'username';
    public $avatarField = 'image';
    
    /**
     * @var string A view file path to be rendered
     */
    public $viewFile = 'comments';

    public function init()
    {
        parent::init();

        $this->formModel = new CommentForm();
        if (Comment::checkModel($this->model)) {
            $this->comments = $this->model->getComments();
        }

    }

    public function params()
    {
        return [
            'model' => $this->model,
            'comments' => $this->comments,
            'commentUrl' => $this->commentUrl,
            'loginUrl' => $this->loginUrl,
            'formModel' => $this->formModel,
            'usernameField' => $this->usernameField,
            'avatarField' => $this->avatarField
        ];
    }

    public function run()
    {
        return $this->render($this-viewFile, $this->params());
    }
}
