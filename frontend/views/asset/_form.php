<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use app\models\TblOrgan;
use app\models\TblAssetType;
?>

<div class="tbl-asset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->errorSummary($model)?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'asset_type_id')->label('Asset Type')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblAssetType::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Please asset type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'location_id')->label('Location')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblOrgan::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Please location'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'asset_no')->label('Asset Number')->textInput(['placeholder' => 'Enter asset number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'block_no')->label('Block Number')->textInput(['placeholder' => 'Enter block number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
