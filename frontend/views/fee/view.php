<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Programmes;
use app\models\PaymentType;
use app\models\TblAcademicYear;

/* @var $this yii\web\View */
/* @var $model app\models\FeeStructure */

$this->title ='Fee Structure';
$this->params['breadcrumbs'][] = ['label' => 'Fee Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$programme=($p=Programmes::find()->where(['program_id'=>$model->programme_id])->one())?$p->programme_name:$model->programme_id;

?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-eye"></i><?= Html::encode(' Fee Structure Details > '.$programme) ?></div>
    <div class="panel-body">
    <p>
        <?=(Yii::$app->user->can('update-fee'))? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?=(Yii::$app->user->can('delete-fee'))? Html::a('Delete', ['delete', 'id' => $model->id], [
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
            [
				'attribute'=>'payment_type_id',
				'value'=>PaymentType::find()->where(['id'=>$model->payment_type_id])->one()->acc_description,
			],	
            [
			 'attribute'=>'academic_year_id',
			 'value'=>TblAcademicYear::find()->where(['year_id'=>$model->academic_year_id])->one()->year,
			], 
            [
			 'attribute'=>'programme_id',
			 'value'=>$programme
			], 
            'year_of_study',
            'local_amount',
            'foreign_amount',
        ],
    ]) ?>

</div>
</div>
