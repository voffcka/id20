<?php

namespace app\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $idcategory
 * @property string $titlecat
 * @property integer $countnews
 *
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     *
     *
     * @inheritdoc
     */
    public static function tableName() {
        return 'category';
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function rules() {
        return [
        [['countnews'], 'integer'],
        [['titlecat'], 'string', 'max' => 45],
        ];
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        'idcategory' => 'Idcategory',
        'titlecat' => 'Titlecat',
        'countnews' => 'Countnews',
        ];
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews() {
        return $this->hasMany( News::className(), ['category_idcategory' => 'idcategory'] );
    }
    /**
     *
     *
     * @return array from dropDownList
     */
    public static function getCatList() {

        $cat = Category::getDb()->cache( function ( $db ) {
                return Category::find()->all();
            } );

        return ArrayHelper::map( $cat, 'idcategory', 'titlecat' );

    }
    /**
     *
     *
     * @return array from Menu
     */

    public function getMenuItems() {

        $items=[];
        $item=[];

if(Yii::$app->controller->action->id !='index'){
    $action=Yii::$app->controller->action->id;
}else{
    $action='';

}

        foreach ( $this->getCatList() as $iteml =>$key ) {

            $items[]=['label' => $key, 'url' => ['site/'.$action, 'category' => $iteml]];
        }

        $item=['items'=>$items];

        return $item;
    }


}
