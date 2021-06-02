<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Programmes;
use yii\web\JsExpression;
use app\models\PaymentType;
use app\models\MenuPanel;
use app\models\TblAcademicYear;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FeeStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Structures';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['programme/programmelist']);

?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Available Fee Structure') ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <p>
        <?=(Yii::$app->user->can('create-fee'))? Html::a('New Fee Structure', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

             // 'id',
            //  'payment_type_id',
            [
                'attribute'=>'payment_type_id',
                'format'=>'text',
                'filter'=>ArrayHelper::map(PaymentType::find()->where(['status'=>1])->all(), 'id', 'acc_description'),
                'value'=>function($model){
                    return PaymentType::find()->where(['id'=>$model->payment_type_id])->one()->acc_description;
                }
            ],
			[
                'attribute'=>'academic_year_id',
                'format'=>'text',
                'filter'=>ArrayHelper::map(TblAcademicYear::find()->all(), 'year_id', 'year'),
                'value'=>function($model){
                    return TblAcademicYear::find()->where(['year_id'=>$model->academic_year_id])->one()->year;
                }
            ],
           
            // 'programme_id',
            [
                'attribute'=>'programme_id',
                'format'=>'text',
                'label'=>'Programme Name',
                /*'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'programme_id',
                    'data' => ArrayHelper::map(Programmes::find()->all(), 'program_id', 'programme_name'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'hideSearch'=>true,
                    'options' => ['placeholder' => 'Search for a programme...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 5,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $url,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { 
                            return {q:params.term}; 
                            }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) {
                         return markup; }'),
                        'templateResult' => new JsExpression('function(city) {
                         return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { 
                        return city.text; }'
                        ),
                    ],


                ]),*/
                'filter'=>ArrayHelper::map(Programmes::find()->all(), 'program_id', 'programme_name'),
                'value'=>function($model){
                    return ($m=Programmes::find()->where(['program_id'=>$model->programme_id])->one())?$m->programme_name:$model->programme_id;
                }
            ],
            'year_of_study',
            'local_amount',
            'foreign_amount',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>MenuPanel::getActions(Yii::$app->controller->id)
            ],
        ],
    ]); ?>
</div>
</div>
