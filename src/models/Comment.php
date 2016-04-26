<?php

namespace rocketfirm\comments\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "rf_comments".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $user_id
 * @property string $model
 * @property integer $model_id
 * @property integer $rating
 * @property string $text
 * @property string $created_at
 * @property string $admin_text
 * @property integer $admin_rating
 * @property integer $is_active
 */
class Comment extends \yii\db\ActiveRecord
{
    private $_user;

    public static $guestCommentsAllowed = false;
    public static $defaultActiveState = true;

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree'
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rf_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model', 'model_id', 'text', 'is_active'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'user_id', 'model_id', 'rating', 'admin_rating', 'is_active'], 'integer'],
            [['text', 'admin_text'], 'string'],
            [['created_at'], 'safe'],
            [['model'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'user_id' => 'User ID',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'rating' => 'Rating',
            'text' => 'Text',
            'created_at' => 'Created At',
            'admin_text' => 'Admin Text',
            'admin_rating' => 'Admin Rating',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @inheritdoc
     * @return \rocketfirm\comments\models\queries\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \rocketfirm\comments\models\queries\CommentQuery(get_called_class());
    }


    /**
     * Checks if this model has CommentableBehavior
     *
     * @param ActiveRecord $commentableModel
     *
     * @throws ErrorException
     *
     * @return boolean
     */
    public static function checkModel($commentableModel)
    {
        if ( !isset($commentableModel->behaviors['commentable']) ) {
            throw new ErrorException('В вашу модель не подключено поведение commentable (или не обозначен ключ)');
        }

        return true;
    }

    /**
     * @param ActiveRecord $commentableModel
     * @param string $idField
     *
     * @return Comment[]
     */
    public static function getComments($commentableModel, $idField = 'id')
    {
        self::checkModel($commentableModel);

        $model = $commentableModel::className();
        $model_id = $commentableModel->$idField;

        return self::find()
            ->where(['model' => $model, 'model_id' => $model_id])
            ->roots()->all();
    }

    /**
     * @param ActiveRecord $commentableModel
     * @param string $text
     * @param integer|bool $userId
     * @param string $idField
     * @throws ErrorException
     *
     * @return bool
     */
    public static function newComment($commentableModel, $text, $parentComment = false, $userId = false, $idField = 'id')
    {
        self::checkModel($commentableModel);

        if ($userId === false && !\Yii::$app->user->isGuest) {
            $userId = \Yii::$app->user->id;
        }

        if ($userId === false && !self::$guestCommentsAllowed) {
            throw new ErrorException('Попытка запостить коммент без id пользователя!');
        }

        if (is_int($parentComment)) {
            $parentComment = self::findOne(['id' => $parentComment]);
        }

        $model = $commentableModel::className();
        $modelId = $commentableModel->$idField;

        $comment = new self([
            'user_id' => $userId,
            'text' => $text,
            'model' => $model,
            'model_id' => $modelId,
            'is_active' => self::$defaultActiveState,
            'admin_text' => '',
        ]);

        if (!$parentComment) {
            $result = $comment->makeRoot();
        } else {
            $result = $comment->prependTo($parentComment);
        }

        return $result;
    }

    /**
     * Получает пользователя из заданного IdentityInterface или из интерфейса приложения
     *
     * @param IdentityInterface|bool $identity
     * @return ActiveRecord
     */
    public function getUser($identity = false)
    {
        if (!$this->_user) {

            if (!$identity) {
                $userIdentityClass = \Yii::$app->user->getIdentity()->className();
            } else {
                return $identity->className();
            }
            $this->_user = $userIdentityClass::findOne(['id' => $this->user_id]);
        }

        return $this->_user;
    }

    /**
     * Получает имя пользователя для отображения в комментариях
     *
     * @param string $field
     * @return mixed
     */
    public function getUsername($field = 'username')
    {
        if (is_callable($field)) {
            return $field($this->getUser());
        } else {
            return $this->getUser()->$field;
        }
    }

    /**
     * Получает имя пользователя для отображения в комментариях
     *
     * @param string $field
     * @return mixed
     */
    public function getUserImage($field = 'image')
    {
        if (is_callable($field)) {
            return $field($this->getUser());
        } else {
            return Url::to($this->getUser()->$field);
        }
    }

    /**
     * Возвращает комментируемую модель
     *
     * @return ActiveRecord
     */
    public function getModel()
    {
        $modelClass = $this->model;
        return $modelClass::findOne(['id' => $this->model_id]);
    }

    /**
     * Поиск обсуждаемых публикаций/моделей
     *
     * @param bool|string|ActiveRecord $model
     */
    public static function getPopular($model = false)
    {
        $query = self::find()
            ->where(['is_active' => 1]);
        if ($model) {
            if (is_object($model)) {
                $model = $model->className();
            }
            $query->where(['model' => $model]);
        }

        $query->groupBy(['model', 'model_id'])->all();
    }
}