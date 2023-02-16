<?php

use app\models\Trip;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Trips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::beginForm(['trip/index'], 'get'); ?>
        <?= Html::label('corporate_id'); ?>
        <?= Html::input('number', 'corporate_id', 3, ['class' => 'form-control']); ?>
        <br/>
        <?= Html::label('service_id'); ?>
        <?= Html::input('number', 'service_id', 2, ['class' => 'form-control']); ?>
        <br/>
        <?= Html::label('airport'); ?>
        <?php
        $dataList = \app\models\AirportName::find()->andWhere(['airport_id' => 758])->all();
        $data = \yii\helpers\ArrayHelper::map($dataList, 'airport_id', 'value');
        $url = \yii\helpers\Url::to(['trip/airport']);
        echo \kartik\select2\Select2::widget([
            'name' => 'airport',
            'value' => 758,
            'data' => $data,
            'options' => ['multiple' => false, 'placeholder' => 'Search for a airport ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(airport) { return airport.text; }'),
                'templateSelection' => new JsExpression('function (airport) { return airport.text; }'),
            ],
        ]);
        ?>
        <br/>
        <?= Html::submitButton('Search', ['name' => 'search']); ?>
        <?= Html::endForm(); ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'corporate_id',
            'number',
            'user_id',
            'created_at',
            'updated_at',
            'coordination_at',
            //'saved_at',
            //'tag_le_id',
            //'trip_purpose_id',
            //'trip_purpose_parent_id',
            //'trip_purpose_desc:ntext',
            'status',
        ],
    ]); ?>


</div>
