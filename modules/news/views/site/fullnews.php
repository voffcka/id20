<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;
use yii\helpers\Url;
$this->title = Html::encode($model->title);
?>
<div class="site-fullnews">

<div class="row">

            <div class="col-lg-12">

    <div class="news-item">
        <h2><?= Html::encode($model->title) ?></h2>
        <p><b>Дата публикации:</b><?= Yii::$app->formatter->asDate( $model->data, 'long' ) ?></p> 
        <p><b>Тема:</b><?= $model->categoryIdcategory->titlecat ?></p>  
        <?= HtmlPurifier::process($model->text) ?>
        <p><a href='<?= Url::toRoute(['index']) ?>'>Все новости</a></p>     
    </div>


</div>

      
<?=round(Yii::getLogger()->getElapsedTime(), 5)?> sec
/ <?=round(memory_get_usage()/(1024*1024),2)."MB"?>
    </div>
</div>