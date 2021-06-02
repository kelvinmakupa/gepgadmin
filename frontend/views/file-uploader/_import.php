<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\TblFileUploaded */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="panel-body">
        <p>
        <div class="alert alert-info">

            <span
                    style="color:black"> Import bulk bills in excel file format</span>
            <?php echo Html::a('Required Excel File Format', '@web/uploads/documents/bulk_bill_template.xls'); ?>. <span
                    style="color:black"> Select
                    the Excel file, click the button to import bulk bills.</span>
        </div>

        <?= $form->field($model, 'payer')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map([
                ['id' => '3', 'name' => 'Student'],
                ['id' => '1', 'name' => 'Other']], 'id', 'name'),
            'language' => 'en',
            'options' => ['id' => 'payer', 'placeholder' => 'Please select payer type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>


        <?= $form->field($model, 'academic_year')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\TblAcademicYear::find()->all(), 'year_id', 'year'),
            'language' => 'en',
            'options' => ['id' => 'academic_year', 'placeholder' => 'Please select academic year'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($model, 'payment_type')->widget(Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(app\models\PaymentType::find()->where('status=:sts', [':sts' => 1])->orderBy('acc_description asc')->all(), 'id', 'acc_description'),
            'language' => 'en',
            'options' => ['id' => 'payment_type', 'placeholder' => 'Please select payment type'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($model, 'bill_currency')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map([
                ['id' => 'TZS', 'name' => 'TZS'],
                ['id' => 'USD', 'name' => 'USD']], 'id', 'name'),
            'language' => 'en',
            'options' => ['id' => 'bill_currency', 'placeholder' => 'Please select currency'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($model, 'payment_option')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map([['id' => '1', 'name' => 'Pay in Full Only'],
                ['id' => '2', 'name' => 'Partial payment is allowed'],
                ['id' => '3', 'name' => 'Exact bill (Same as full but does not allow over or under payment)']], 'id', 'name'),
            'language' => 'en',
            'options' => ['id' => 'payment_option', 'placeholder' => 'Please select payment option'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($model, 'bill_expire_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter choose expire date', 'id' => 'expire_date'],
            'pluginOptions' => [
                'startDate' => date("Y-m-d", strtotime("+1 month", time())),
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]) ?>

        <?= $form->field($model, 'file_import')->widget(FileInput::classname(), [
            'options' => [
                'multiple' => false
            ],
            'pluginOptions' => [
                'showPreview' => false,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => false

            ]
        ]) ?>
        <div class="form-group">
            <p class="pull-right">
                <?= Html::submitButton('<i class="fa fa-upload"></i>&nbsp;&nbsp; Upload', ['class' => 'btn btn-success']) ?>
            </p>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
