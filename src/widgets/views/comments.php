<?php
/**
 * @var \rocketfirm\comments\models\Comment[] $comments
 * @var string $loginUrl
 * @var \yii\db\ActiveRecord $model
 * @var \rocketfirm\comments\models\CommentForm $formModel
 */

?>
<div class="reviews">
    <a id="comments"></a>
    <h3 class="content-title">
        Отзывы читателей
        <span>
            (<?= $model->getCommentsCount() ?>)
        </span>
    </h3>
    <?php if (\Yii::$app->user->isGuest) : ?>
        <a class="reviews-login" href="<?= \yii\helpers\Url::to($loginUrl) ?>">
            Войти
            <svg class="icon icon--down">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-down"></use>
            </svg>
        </a>
    <?php endif; ?>

     <select class="selectpicker" title="Сортировать по">
         <option>дате</option>
         <option>рейтингу</option>
     </select>

    <div class="reviews-comment-section flex-760">
        <?php if (!\Yii::$app->user->isGuest) : ?>
            <?php $form = \yii\widgets\ActiveForm::begin([
                'action' => ['comments/actions/post'],
                'options' => [
                    'style' => 'width: 100%;',
                ],
                'fieldConfig' => [
                    'template' => '{input}',
                    'options' => [
                        'style' => 'width: 100%',
                    ]
                ]
            ]) ?>
            <?= $form->field($formModel, 'commentableModel')->hiddenInput([
                'value' => $model::className()
            ]) ?>
            <?= $form->field($formModel, 'returnUrl')->hiddenInput([
                'value' => \yii\helpers\Url::current()
            ]) ?>
            <?= $form->field($formModel, 'modelId')->hiddenInput([
                'value' => $model->id,
            ]) ?>
            <div class="reviews-comment-row">
                <div class="reviews-avatar"></div>
                <?= $form->field($formModel, 'text')->input('text', [
                    'class' => 'reviews-comment-input',
                    'placeholder' => 'Ваш комментарий',
                    'style' => 'width: 100%;',
                ]) ?>
            </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>

            <div class="reviews-comment-row">
                <div class="reviews-avatar">
                    <img src="<?= $comment->getUserImage($avatarField) ?>" alt="" width="100%">
                </div>
                <div class="reviews-comment-block">
                    <div class="reviews-comment-info">
                        <div class="reviews-comment-name inline-block">
                            <?= $comment->getUsername($usernameField) ?>
                        </div>
                        <div class="reviews-comment-time inline-block">
                            <?= \naffiq\helpers\DateHelper::getTimeSince($comment->created_at) ?>
                        </div>
                        <div class="reviews-likes inline-block">
                            <a class="reviews-likes-less" href="#">
                                <i></i>
                            </a>
                            <div class="reviews-likes-num reviews-likes-num--plus"><?= $comment->rating ?></div>
                            <a class="reviews-likes-more" href="#">
                                <i></i>
                            </a>
                        </div>
                    </div>
                    <div class="reviews-comment-text plain-text">
                        <?= $comment->text ?>
                    </div>
                    <div class="reviews-comment-actions">
                        <a class="reviews-comment-link inline-block" data-comment-id="" href="#">
                            <?= Yii::t('frontend', 'Ответить') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <?php if (empty($comments)) : ?>
            <div class="alert alert-info">
                Комментариев пока нет. Станьте первым, оставив свой!
            </div>
        <?php endif; ?>
    </div>
</div>
