<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Programme Management';
$this->params['breadcrumbs'][] = ['label' => 'Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"> </i> <?= Html::encode($model->programme_name) ?></div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-programme'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('delete-programme'))?Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]):'' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
           // 'level',
            [
               'attribute'=>'level',
                'value'=>function($model){
                    return ($x=app\models\QualificationType::find()->where(['id'=>$model->level])->one())?$x->name:'';
                }
            ],
            'programme_name',
         //   'department_id',
			 [
                'attribute'=>'department_id',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\Department::find()->all(),'department_id','department_name'),
                'format'=>'raw',
                'value'=>function($dataProvider){
                    $department_name='';
                    if($m=\app\models\Department::find()->where(['department_id'=>$dataProvider->department_id])->one()){
                        $department_name=$m->department_name;
                    }
                    return $department_name;
                }
            ],
//            'admission_direct:ntext',
//            'admission_equiv:ntext',
//            'min_point',
//            'programme_duration',
//            'capacity',
//            'direct_capacity',
//            'equivalent_capacity',
            'local_amount',
            'foreign_amount',
//            'loan_priority',
            // 'status',
//            [
//                'attribute'=>'status',
//                'format'=>'raw',
//                'value'=>function($model){
//                        return ($model->status==1)?'Active':'Inactive';
//                }
//            ]
        ],
    ]) ?>

</div>
</div>
