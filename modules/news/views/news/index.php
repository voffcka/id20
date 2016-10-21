<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?php echo Html::encode( $this->title ) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a( 'Create News', ['create'], ['class' => 'btn btn-success'] ) ?>
    </p>
<?php Pjax::begin(); ?>
<?php echo GridView::widget( [
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
    ['class' => 'yii\grid\SerialColumn'],

    'idnews',
    'title',
    'data',
    'text:ntext',
    // 'category_idcategory',

    ['class' => 'yii\grid\ActionColumn'],
    ],
    ] ); ?>
<?php Pjax::end(); ?></div>
