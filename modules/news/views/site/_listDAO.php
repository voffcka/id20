    <?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
    use yii\helpers\StringHelper;
    use yii\helpers\Url;
   /* echo '<pre>';
    var_dump($model);
    echo '</pre>';
    exit;*/
    ?>
     
    <div class="news-item">
        <h2><?= Html::encode($model['title']) ?></h2>
        <p><b>Дата публикации:</b><?= Yii::$app->formatter->asDate( $model['data'], 'long' ) ?></p> 
        <p><b>Тема:</b><?= $model['titlecat'] ?></p>  
        <?= HtmlPurifier::process(StringHelper::truncate($model['text'],256,'...')) ?>
        <p><a href='<?= Url::toRoute(['fullnews', 'idnews' => $model['idnews']]) ?>'>читать далее</a></p>     
    </div>