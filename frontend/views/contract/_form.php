<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\file\FileInput;

use app\models\TblDebtor;
use app\models\TblContractType;
?>
<?php
    use yii2mod\alert\Alert;

    if (Yii::$app->session->hasFlash('success')) {
        echo Alert::widget();
    } elseif (Yii::$app->session->hasFlash('error')) {
        echo Alert::widget();
    } elseif (Yii::$app->session->hasFlash('info')) {
        echo Alert::widget();
    }
?>
<div class="tbl-contract-form">

    <div class="row">
        <div class="col-md-12">
           <div class="alert alert-info">All Field with <span style="color:red;font-size:16px;">*</span> are Mandatory</div>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?=$form->errorSummary($model)?>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'contract_no')->label('Contract Number')->textInput(['placeholder' => 'Enter contract number']) ?>
        </div>
    </div> -->
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'debtor_id')->label('Debtor')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblDebtor::find()->all(),'id','company_name'),
                'options' => ['placeholder' => 'Please select debtor'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'contract_type_id')->label('Contact Type')->widget(Select2::className(),[
                'data'=>ArrayHelper::map(TblContractType::find()->all(),'id','name'),
                'options' => ['placeholder' => 'Please select contract type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'duration')->label('Duration (Per Month)')->textInput(['placeholder' => 'Enter duration per month']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                    'name' => 'start_date',
                    'value' => date('Y-m-d'),
                    'options' => ['placeholder' => 'Select start date'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
                    'name' => 'end_date',
                    'value' => date('Y-m-d'),
                    'options' => ['placeholder' => 'Select end date'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="row">
       <div class="col-md-12">
            <?= $form->field($model, 'file_upload')->label('Upload Attchment (in PDF)')->widget(FileInput::classname(), [
                'options' => ['multiple'=>false],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        'showPreview' => true,
                    ]

            ])?>
       </div>
    </div>
    <div class="row">
       <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
            </div>
       </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
