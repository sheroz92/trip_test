<?php

namespace app\controllers;

use app\models\AirportName;
use app\models\Trip;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TripController implements the CRUD actions for Trip model.
 */
class TripController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Trip models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Trip::find()->alias('t');
        $query->leftJoin('trip_service s', 's.trip_id = t.id');
        $query->leftJoin('flight_segment f', 'f.flight_id = s.id');
        if (Yii::$app->request->get('corporate_id')){
            $query->andWhere(['t.corporate_id' => Yii::$app->request->get('corporate_id')]);
        }
        if (Yii::$app->request->get('service_id')){
            $query->andWhere(['s.service_id' => Yii::$app->request->get('service_id')]);
        }
        if (Yii::$app->request->get('airport')){
            $query->andWhere(['f.depAirportId' => Yii::$app->request->get('airport')]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trip model.
     * @param null $q
     * @param int $id ID
     * @return array
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionAirport($q = null, $id = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('airport_id as id, value AS text')
                ->from('airport_name')
                ->where(['like', 'value', $q])
                ->limit(20);
            $command = $query->createCommand(Yii::$app->get('dbTwo'));
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => AirportName::findOne($id)->value];
        }
        return $out;
    }

    /**
     * Finds the Trip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Trip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trip::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
