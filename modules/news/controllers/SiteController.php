<?php

namespace app\modules\news\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     *
     *
     * @inheritdoc
     */
    public function behaviors() {
        return [
        'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
        [
        'actions' => ['logout'],
        'allow' => true,
        'roles' => ['@'],
        ],
        ],
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'logout' => ['post'],
        ],
        ],
        ];
    }

    /**
     *
     *
     * @inheritdoc
     */
    public function actions() {
        return [
        'error' => [
        'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
        ];
    }

    /**
     * Displays NEWS  use DAO.
     *
     * @return string
     */
    public function actionIndex() {

        $get["year"]='';
        $get["month"]='';
        $get["category"]='';

        $get = Yii::$app->request->get();

        $where='';
        $param=[];

        if ( isset( $get["year"] ) ) {

            $where='WHERE YEAR(`data`)=:year';
            $param[':year'] = (int)$get["year"];

            if ( isset( $get["month"] ) ) {

                $where='WHERE YEAR(`data`)=:year AND MONTH(`data`)=:month';
                $param[':month'] = (int)$get["month"];

            }
        }

        if ( isset( $get["category"] ) ) {

            $where='WHERE category_idcategory=:category';
            $param[':category'] = (int)$get["category"];
        }


        $count = Yii::$app->db->cache( function ( $db ) use ( $where, $get  ) {

                $countq=Yii::$app->db->createCommand( 'SELECT COUNT(*) FROM news '.$where );

                if ( isset( $get["category"] ) ) {
                    $countq->bindValue( ':category', $get["category"] );
                }
                if ( isset( $get["year"] ) ) {
                    $countq->bindValue( ':year', $get["year"] );
                }
                if ( isset( $get["month"] ) ) {
                    $countq->bindValue( ':month', $get["month"] );
                }
                $count = $countq->queryScalar();
                return $count;
            } );


        $dataProvider = new SqlDataProvider( [
            'sql' => 'SELECT * FROM news n LEFT OUTER JOIN category c ON c.idcategory=n.category_idcategory '.$where.' ORDER BY `data` DESC',
            'params' => $param,
            'totalCount' => $count,
            'sort' => [
            'attributes' => [
            'title',
            'data',
            'text',
            'category_idcategory',
            ],
            ],
            'pagination' => [
            'pageSize' => 5,
            ],
            ] );

        Yii::$app->db->cache( function () use ( $dataProvider ) {
                $dataProvider->prepare();
            } );

        return $this->render( 'index', ['dataProvider'=>$dataProvider] );
    }





    /**
     * Displays list news WHERE categry, data.
     *
     * @return string
     */
    public function actionNews() {

        $get = Yii::$app->request->get();

        $where=[];

        if ( isset( $get["year"] ) ) {

            $whereyear=['YEAR(`data`)'=>$get["year"]];

            if ( isset( $get["month"] ) ) {

                $where=['and', $whereyear, ['MONTH(`data`)'=>$get["month"]]];

            }else {
                $where=$whereyear;
            }
        }

        if ( isset( $get["category"] ) ) {

            $where=['category_idcategory'=>$get["category"]];

        }

        $dataProvider = new ActiveDataProvider( [
            'query' => News::find()->
            where( $where )->
            orderBy( 'data DESC' )->
            joinWith( ['categoryIdcategory'] ),
            'pagination' => [
            'pageSize' => 5,
            ],
            ] );

        News::getDb()->cache( function () use ( $dataProvider ) {
                $dataProvider->prepare();  // trigger DB query
            } );


        return $this->render( 'news', ['dataProvider'=>$dataProvider] );
    }

    /**
     * Displays full news.
     *
     * @return string
     */
    public function actionFullnews() {



        $get = Yii::$app->request->get( 'idnews' );

        $model = News::getDb()->cache( function ( $db ) use ( $get ) {
                return News::find()->where( ['idnews'=>$get] )-> joinWith( ['categoryIdcategory'] )->one();
            } );

        return $this->render( 'fullnews', ['model'=>$model] );
    }


    /**
     * Clear cache action.
     *
     * @return string
     */
    public function actionClearcache() {
        Yii::$app->cache->flush();
        return $this->goHome();

    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if ( !Yii::$app->user->isGuest ) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->login() ) {
            return $this->goBack();
        }
        return $this->render( 'login', [
            'model' => $model,
            ] );
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ( $model->load( Yii::$app->request->post() ) && $model->contact( Yii::$app->params['adminEmail'] ) ) {
            Yii::$app->session->setFlash( 'contactFormSubmitted' );

            return $this->refresh();
        }
        return $this->render( 'contact', [
            'model' => $model,
            ] );
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render( 'about' );
    }
}
