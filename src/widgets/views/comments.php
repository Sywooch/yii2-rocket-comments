<div class="reviews">
    <a id="comments"></a>
    <h3 class="content-title">Отзывы читателей <span>(34)</span></h3>
    <a class="reviews-login" href="">
        Войти
        <svg class="icon icon--down">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-down"></use>
        </svg>
    </a>
    <?php /*
     <select class="selectpicker" title="Сортировать по">
     <option>дате</option>
     <option>рейтингу</option>
     </select>
 */ ?>
    <div class="reviews-comment-section flex-760">
        <?php \yii\widgets\ActiveForm::begin([
            'options' => [
                'style' => 'width: 100%;'
            ]
        ]) ?>
        <div class="reviews-comment-row">
            <div class="reviews-avatar"></div>
            <input class="reviews-comment-input" type="text" placeholder="Ваш комментарий...">
        </div>
        <?php \yii\widgets\ActiveForm::end() ?>
        <div class="reviews-comment-row">
            <div class="reviews-avatar"></div>
            <div class="reviews-comment-block">
                <div class="reviews-comment-info">
                    <div class="reviews-comment-name inline-block">Serik Dossayev</div>
                    <div class="reviews-comment-time inline-block">12 часов назад</div>
                    <div class="reviews-likes inline-block">
                        <a class="reviews-likes-less" href="#">
                            <i></i>
                        </a>
                        <div class="reviews-likes-num reviews-likes-num--plus">+2</div>
                        <a class="reviews-likes-more" href="#">
                            <i></i>
                        </a>
                    </div>
                </div>
                <div class="reviews-comment-text plain-text">В преддверии выборов решением Центр-избиркома и
                    апелляционной палаты была снята с предвыборной гонки партия "Патрия", по спискам которой проходил
                    предприниматель Ренато Усатый. Поводом для этого стали материалы МВД, согласно которым партии якобы
                    были переведены из-за рубежа около 500 тысяч долла...
                </div>
                <div class="reviews-comment-actions">
                    <a class="reviews-comment-link inline-block" href="#">Ответить</a>
                    <a class="reviews-comment-link inline-block" href="#">Поделиться</a>
                </div>
            </div>
        </div>
    </div>
</div>
