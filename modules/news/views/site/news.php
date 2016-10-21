<?php

/* @var $this yii\web\View */
use yii\widgets\Menu;
use app\modules\news\models\News;
use app\modules\news\models\Category;
use yii\widgets\ListView;
$this->title = 'For ID20';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">

            <div class="col-lg-3">
    <?= Menu::widget((new News)->getItemMenu()) ?>

    <?= Menu::widget((new Category)->getMenuItems()) ?>
 </div>
             <div class="col-lg-9">

 <?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
])
?>
</div>

        </div>
<?=round(Yii::getLogger()->getElapsedTime(), 5)?> sec
/ <?=round(memory_get_usage()/(1024*1024),2)."MB"?>
    </div>
</div>