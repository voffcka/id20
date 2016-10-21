<?php

namespace app\modules\news\models;

use Yii;
use yii\helpers\Html;
use yii\caching\Cache;

/**
 * This is the model class for table "news".
 *
 * @property integer $idnews
 * @property string $title
 * @property string $data
 * @property string $text
 * @property string $category
 * @property integer $category_idcategory
 *
 * @property Category $categoryIdcategory
 */
class News extends \yii\db\ActiveRecord
{
    /**
     *
     *
     * @inheritdoc
     */
    public static function tableName() {
        return 'news';
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function rules() {
        return [
        [['data'], 'safe'],
        [['text'], 'string'],
        [['category_idcategory'], 'required'],
        [['category_idcategory'], 'integer'],
        [['title'], 'string', 'max' => 255],
        [['category_idcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_idcategory' => 'idcategory']],
        ];
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        'idnews' => 'Idnews',
        'title' => 'Title',
        'data' => 'Data',
        'text' => 'Text',
        'category_idcategory' => 'Category Idcategory',
        ];
    }

    /**
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryIdcategory() {
        return $this->hasOne( Category::className(), ['idcategory' => 'category_idcategory'] );
    }


    /**
     * version1 with count native php
     *
     * @return array
     * Time: 0.01580
     * Memory: 2.28MB
     */
    public function getDataMenuv1() {



        $sorted_data = \Yii::$app->cache->get( 'newsdatav1' );

        if ( $sorted_data === false ) {

            /*$articles = News::getDb()->cache( function ( $db ) {
                    return News::find()->All();
                } );*/

            $articles = Yii::$app->db->cache( function ( $db ) {

                    return Yii::$app->db->createCommand( 'SELECT data FROM news' )->queryAll();

                } );



            $sorted_data=[];

            foreach ( $articles as $article ) {

                $year=Yii::$app->formatter->asDate( $article['data'], 'php:Y' );

                $month=Yii::$app->formatter->asDate( $article['data'], 'php:m' );


                if ( !array_key_exists( $year , $sorted_data )  ) {

                    $sorted_data[$year][$month]['count']=0;

                }


                if ( array_key_exists( $year , $sorted_data ) && array_key_exists( $month , $sorted_data[$year] )  ) {

                    (int)$sorted_data[$year][$month]['count']++;

                }else {
                    $sorted_data[$year][$month]['count']=1;

                }

            }

            \Yii::$app->cache->set( 'newsdatav1', $sorted_data );

        }
        return $sorted_data;
    }

    /**
     * version2 with count from DB
     *
     * @return array
     * Time: 0.02681
     * Memory: 2.32MB
     */
    public function getDataMenuv2() {

        $sorted_data = \Yii::$app->cache->get( 'newsdata1' );

        if ( $sorted_data === false ) {


            /* $articles = News::getDb()->cache( function ( $db ) {
                    return News::find()->orderBy( 'data DESC' )->groupBy( 'data' )->All();
                } );*/

            $articles = Yii::$app->db->cache( function ( $db ) {

                    return Yii::$app->db->createCommand( 'SELECT data FROM news GROUP BY data DESC ORDER BY data DESC' )->queryAll();

                } );



            foreach ( $articles as $article ) {

                $year=Yii::$app->formatter->asDate( $article['data'], 'php:Y' );

                $month=Yii::$app->formatter->asDate( $article['data'], 'php:m' );

                $count = Yii::$app->db->cache( function ( $db )  use ( $article ) {

                        return Yii::$app->db->createCommand( 'SELECT COUNT(*) FROM news WHERE data=:dat' )
                        ->bindValue( ':dat', $article['data'] )
                        ->queryScalar();

                    } );
                /*  $count = News::getDb()->cache( function ( $db ) use ( $article ) {
                        return News::find()->select( 'data' )->where( ['data'=>$article->data] )->count();
                    } );*/

                $sorted_data[$year][$month]['count']=$count;
            }

            \Yii::$app->cache->set( 'newsdata1', $sorted_data );

        }
        return $sorted_data;
    }
    /**
     *
     *
     * @return array for item menu
     */

    public function getItemMenu() {

        if ( Yii::$app->controller->action->id !='index' ) {

            $action=Yii::$app->controller->action->id;

        }else {

            $action='';

        }
        
        $item = \Yii::$app->cache->get( 'datamenuitem1'.$action );

        if ( $item === false ) {

            $item=[];

            $itemsubs=[];

            $items=[];

            foreach ( $this->getDataMenuv1() as $iteml =>$key ) {

                $itemsubs=[];

                foreach ( $key as $itemsub =>$keys ) {

                    $itemsubm=mktime( 0, 0, 0, ( (int)$itemsub+1 ), 0, 0 );

                    $month=Yii::$app->formatter->asDate( $itemsubm, 'php:F' );

                    $months=$month.'('.$keys['count'].')';

                    $itemsubs[]=['label' => $months, 'url' => ['site/'.$action, 'month' => $itemsub, 'year' => $iteml]];


                }

                $items[]=['label' => $iteml, 'url' => ['site/'.$action, 'year' => $iteml], 'items' => $itemsubs];

            }
            $item=['items'=>$items];

            \Yii::$app->cache->set( 'datamenuitem1'.$action, $item );
        }

        return $item;

    }




}
