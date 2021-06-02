<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AuthItem;
use kartik\widgets\DatePicker;
use app\models\User;
use kartik\select2\Select2;
use yii\web\JsExpression;

//$assignment=ArrayHelper::map(AuthItem::find()->all(),'name','name');
//$accounts=ArrayHelper::map(Accounts::find()->all(),'id','username');
/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['userid']);
$user_id = empty($model->user_id) ? '' : User::findOne($model->user_id)->username;

?>

<div class="row">

    <?php $form = ActiveForm::begin(); ?>
	<div class='col-lg-8'>
	<?=$form->field($model, 'item_name')->widget(Select2::classname(), [
    'data' =>ArrayHelper::map(AuthItem::find()->all(),'name','name'),
    'language' => 'en',
        'theme' => Select2::THEME_KRAJEE, // this is the default if theme is not set

        'options' => ['placeholder' => '-- Please select permission --'],
    'pluginOptions' => [
        'allowClear' => true
    ],
	])?>

	<?php

    /*$form->field($model, 'user_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Accounts::find()->all(),'id','username'),
        'theme' => Select2::THEME_KRAJEE, // this is the default if theme is not set

    'language' => 'en',
    'options' => ['placeholder' => '-- Please select username --'],
    'pluginOptions' => [
        'allowClear' => true
    ],
	])
    */
    ?>


    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
        'initValueText' => $user_id, // set the initial display text
        'options' => ['placeholder' => 'Search for a username ...'],
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
        'templateResult' => new JsExpression('function(city) { return city.text; }'),
        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
        ])?>

        <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Assign' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default text-bold' : 'btn btn-primary']) ?>
    </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
