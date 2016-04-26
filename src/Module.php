<?php
/**
 * Created by PhpStorm.
 * User: rocketman
 * Date: 25.04.16
 * Time: 13:54
 */

namespace rocketfirm\comments;


class Module extends \yii\base\Module
{
    /**
     * Controllers' namespace
     *
     * @var string $controllerNamespace
     */
    public $controllerNamespace = 'rocketfirm\comments\controllers';

    /**
     * Username field to be displayed in comment view.
     * If anonymous function passed to this field, comment's author identity will be
     * passed as first parameter
     *
     * Example:
     * function($user) { return $user->first_name . ' ' . $user->last_name }
     *
     * @var string|void $usernameField
     */
    public $usernameField = 'username';

    /**
     * Avatar url to be displayed in comment view
     * Any passed string will be wrapped in Url::to() function, otherwise if
     * function is passed it's return value will remain as it is.
     *
     * @var string|void $avatarField
     */
    public $avatarField = 'image';

    /**
     * Default value for is_active field for new comments
     * @var int $defaultActiveState
     */
    public $defaultActiveState = 1;
}