<?php
namespace rocketfirm\comments\widgets;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 25.04.16
 * Time: 12:18
 */
class CommentWidget extends Widget
{
    public $model;

    public $form;

    public function init()
    {
        parent::init();

//        $this->form = \CommentForm::
//        Comment::checkModel($this->model);

        // TODO: get comments and display
    }

    public function run()
    {
        return $this->render(
            'comments', [
                'model' => $this->model
            ]
        );
    }
}