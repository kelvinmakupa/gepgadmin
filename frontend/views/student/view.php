<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentDetails */

$this->title = 'Student Management';
$this->params['breadcrumbs'][] = ['label' => 'Student Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">


    <div class="panel-heading">
        <h4><?= Html::encode('Student Details') ?></h4>
    </div>
    <div class="panel-body">
    <p>
        <?= (Yii::$app->user->can('update-student'))?Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        <?= (Yii::$app->user->can('delete-student'))?Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'admission_number',
            'reg_number',
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'dob',
            'citizenship',
            'email:email',
            'phone',
            'f4indexno',
            'other_f4indexno',
            'f6indexno',
            'other_f6indexno',
            'programme_code',
            'study_level',
            'yos',
            'application_round',
            'academic_year',
            'is_delete',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
</div>
