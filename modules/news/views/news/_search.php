<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idnews') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'category_idcategory') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
