<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TblBillingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel">
<div class="panel-body">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'payer_name') ?>

    <?php // $form->field($model, 'bill_amount') ?>

    <?php // $form->field($model, 'bill_exp_date') ?>

    <?php // $form->field($model, 'bill_description') ?>


        <?php
        echo '<label class="control-label">Bill Generation Date</label>';
        echo '<div class="drp-container form-group">';

        echo DateRangePicker::widget([
            'model'=>$model,
            'attribute'=>'bill_gen_date',
            'readonly'=>true,
            'convertFormat'=>true,
            'pluginOptions'=>[
                'showDropdowns'=>true,
                'timePicker'=>false,
                'opens'=>'left',
                'locale'=>[
                    'format'=>'Y-m-d'
                ]
            ]
        ]);
        echo '</div>';
        ?>


    <?php // echo $form->field($model, 'bill_gen_by') ?>

    <?php // echo $form->field($model, 'bill_appr_by') ?>

    <?php // echo $form->field($model, 'payer_cell_num') ?>

    <?php // echo $form->field($model, 'payer_email') ?>

    <?php // echo $form->field($model, 'bill_currency') ?>

    <?php // echo $form->field($model, 'payment_type_id') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'bill_gen_date') ?>

    <?php // echo $form->field($model, 'bill_id') ?>

    <?php // echo $form->field($model, 'control_number') ?>

    <?php // echo $form->field($model, 'bill_pay_opt') ?>

    <?php // echo $form->field($model, 'use_on_pay') ?>

    <?php // echo $form->field($model, 'bill_eqv_amount') ?>

    <?php // echo $form->field($model, 'bill_item_ref') ?>

    <?php // echo $form->field($model, 'is_posted') ?>

    <?php // echo $form->field($model, 'is_cancelled') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset',['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Export Bill to Excel', ['name'=>'export','value'=>urlencode('11'),'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
