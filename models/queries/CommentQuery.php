<?php

namespace rocketfirm\comments\models\queries;
use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[\common\models\base\Comment]].
 *
 * @see \rocketfirm\comments\models\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return \rocketfirm\comments\models\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \rocketfirm\comments\models\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}