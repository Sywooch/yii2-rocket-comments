<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 9/10/2016
 * Time: 5:36 PM
 */

namespace rocketfirm\comments\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class CommentVotes
 * @package rocketfirm\comments\models
 *
 * @property int $id
 * @property int $user_id
 * @property int $comment_id
 * @property bool $upvote
 * @property bool $to_admin
 */
class CommentVotes extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id', 'upvote'], 'integer'],
        ];
    }

    /**
     * @param $userId
     * @param $commentId
     *
     * @return CommentVotes
     */
    public static function checkVote($userId, $commentId)
    {
        $params = ['user_id' => $userId, 'comment_id' => $commentId];
        $vote = self::findOne($params);

        if (empty($vote)) {
            $vote = new static($params);
        }

        return $vote;
    }

    public function updateVote($upVote = true)
    {
        $this->upvote = $upVote;
        $this->save();

        $params = [
            'user_id' => $this->user_id,
            'comment_id' => $this->comment_id,
        ];

        $upVoteCount = static::find()->where($params)
            ->andWhere(['upvote' => 1])->count();

        $downVoteCount = static::find()->where($params)
            ->andWhere(['upvote' => 0])->count();

        return $upVoteCount - $downVoteCount;
    }
}