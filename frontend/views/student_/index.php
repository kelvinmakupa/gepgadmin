<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'admission_number',
            'reg_number',
            'first_name',
            'middle_name',
            //'last_name',
            //'sex',
            //'dob',
            //'citizenship',
            //'email:email',
            //'phone',
            //'f4indexno',
            //'other_f4indexno',
            //'f6indexno',
            //'other_f6indexno',
            //'programme_code',
            //'study_level',
            //'yos',
            //'application_round',
            //'academic_year',
            //'is_delete',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
