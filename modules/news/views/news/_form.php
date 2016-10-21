<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\modules\news\models\Category;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'data')->widget(DatePicker::className(),[
    'clientOptions' => ['defaultDate' => date("Y-m-d")],
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd'
    ]) ?>


    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_idcategory')->dropDownList(Category::getCatList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
