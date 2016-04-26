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
        <?= Yii::t('frontend', 'Отзывы читателей') ?>
        <span>
            (<?= $model->getCommentsCount() ?>)
        </span>
    </h3>
    <?php if (\Yii::$app->user->isGuest) : ?>
        <a class="reviews-login" href="<?= \yii\helpers\Url::to($loginUrl) ?>">
            <?= Yii::t('frontend', 'Войти') ?>
            <svg class="icon icon--down">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-down"></use>
            </svg>
        </a>
    <?php endif; ?>

     <select class="selectpicker" title="Сортировать по">
         <option><?= Yii::t('frontend', 'дате') ?></option>
         <option><?= Yii::t('frontend', 'рейтингу') ?></option>
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
                    'placeholder' => \Yii::t('rf-comments', 'Ваш комментарий'),
                    'style' => 'width: 100%;',
                ]) ?>
            </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        <?php endif; ?>

        <div id="rocket-comments">

        </div>

    </div>
</div>
