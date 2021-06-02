<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\TblAcademicYear;
use yii\helpers\Url;
use app\models\Common;
/* @var $this yii\web\View */
/* @var $model app\models\TblBilling */

$this->title = 'Billing Management';
$this->params['breadcrumbs'][] = ['label' => 'Available Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-list"></i><?= Html::encode(' Billing Details') ?></div>

    <div class="panel-body">
    <p class='row'>
        <div class='btn-group'>
        <?= (Yii::$app->user->can('updat-billing')&&($model->payer==3))?Html::a(' <i class="fa fa-edit"></i> Update Registration No', ['updat', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        </div>

        <div class='btn-group'>
        <?= (Yii::$app->user->can('update-billing')&&($model->company_id==0)&&($model->is_posted==1))?Html::a(' <i class="fa fa-edit"></i> Update Bill', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        </div> 
        
        <div class='btn-group'>
        <?= (Yii::$app->user->can('update-billing')&&($model->company_id==1)&&($model->is_posted==1))?Html::a(' <i class="fa fa-edit"></i> Update Bill', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>
        </div> <div class='btn-group'>
        <?= (($model->is_posted==1))?Html::a(' <i class="fa fa-arrow-right"></i> Post Bill', ['postbill', 'id' => $model->id], ['class' => 'btn btn-default','data'=>['method'=>'post']]):'' ?>
        </div> <div class='btn-group'>
        <?= Html::a(' <i class="fa fa-refresh"></i> Refresh',['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        </div> <div class='btn-group'>
        <?= Html::a(' <i class="fa fa-list"></i> Available Bills',['index'], ['class' => 'btn btn-default']) ?>
        </div> <div class='btn-group'>
        <?= (($model->is_posted==2)&&$model->control_number=='')?Html::a(' <i class="fa fa-arrow-right"></i> Repost Bill', ['postbill', 'id' => $model->id], ['class' => 'btn btn-default','data'=>['method'=>'post']]):'' ?>
        </div> <div class='btn-group'>
        <?= (($model->is_posted==2)&&$model->control_number!='')?Html::a(' <i class="fa fa-print"></i> Print Bill', ['printout', 'id' => $model->id], ['class' => 'btn btn-default']):'' ?>

        <?= (($model->is_posted==2)&&Common::checkSpSystem($model->control_number)&&$model->control_number!='')?Html::a(' <i class="fa fa-cloud-upload"></i> Send to SP System', ['sp-system', 'id' => $model->id], ['class' => 'btn btn-primary']):'' ?>

    </div>
      
       <div class='btn-group'>
        <?= (Yii::$app->user->can('delete-billing')&&($model->is_posted==1))?Html::a(' <i class="fa fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this bill item?',
                'method' => 'post',
            ],
        ]):'' ?>
        </div>
    </p>
    <div class='col-lg-8'>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             //'id',
             [
                'attribute'=>'sp_system_id',
                'format'=>'text',
                'value'=>($sp=$model->sp)?$sp->system_name:null,
            ],
            'sys_bill_id',
            'payer_name',
            'payer_cell_num',
            'payer_email:email',
            'bill_amount',
            'bill_exp_date',
            'bill_description',
            'bill_gen_by',
            'bill_appr_by',
            'bill_currency',
//            'payment_type_id',
            [
                'attribute'=>'payment_type_id',
                'format'=>'text',
                'value'=>Common::getPaymentNameById($model->payment_type_id),
                
            ],
//            'company_id',
            'bill_gen_date',
            'bill_id',
            'control_number',
//            'bill_pay_opt',
            [
                'attribute'=>'bill_pay_opt',
                'format'=>'text',
                'value'=>Common::getPaymentOption($model->bill_pay_opt),
                
            ],
//            'use_on_pay',
            'bill_eqv_amount',
            'bill_item_ref',
            [
                'attribute'=>'year_id',
                'format'=>'text',
                'value'=>TblAcademicYear::findOne($model->year_id)->year,
            ],    
            [
                'attribute'=>'is_posted',
                'format'=>'text',
                'value'=> Common::isPosted($model->is_posted),

            ],
//            'is_cancelled',
            [
                'attribute'=>'is_cancelled',
                'format'=>'text',
                'value'=> Common::isCancelled($model->is_cancelled),
            ],
        ],
    ]) ?>
</div>
<?php
if(($model->is_posted==2)&&$model->control_number!=''&&$model->bill_id!=''){    

    // print_r(Common::numberTowords($model->bill_amount));   


    $currency=($model->bill_currency=='TZS')?' Tanzanian Shilling.':' USD';
?>   
<div class="col-lg-4">
    <div class="panel panel-info">
    <div class='panel-heading'>Form for Electronic Funds Transfer</div>
    <div class='panel-body'>
    <?php $form = ActiveForm::begin([
        'action'=>Url::to(['billing/transfer']),
        'options'=>[
            'method'=>'post'
        ]
        ]); ?>

            <div class="box-body">
              <?=yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken)?>
   
              <div class="form-group">
               <?php 
                    $query=Yii::$app->db->createCommand("select id,concat(bank_name,' (',concat(account_name,' ',' )')) as name from gepg_bank where acc_currency=:curr and is_visible=:visible");
                    $query->bindValue(':curr',$model->bill_currency);
                    $query->bindValue(':visible',10);
                    $accounts=$query->queryAll();

                    echo '<label class="control-label">Account Name</label>';
                    ?>
                <select name='id' class='form-control' required>
                echo "<option value=''>Please choose account name...</option>";

                <?php
                foreach($accounts as $data){
                
                echo "<option value='".$data['id']."'>".$data['name']."</option>";
               
                }
                ?>    
                </select>
    
            </div>
           

                <div class="form-group">
                    <input type="hidden" class="form-control" name='bill_id' value='<?=$model->id?>' readonly required>
                 
                </div>
                <div class="form-group">
                  <label>Amount in Words</label>
                    <input type='text' class="form-control" name="amount" value='<?=ucfirst(strtolower(Common::numberTowords($model->bill_amount))).$currency?>' readonly  required/>
                </div>

               <div class='row'>
            <div class="col-lg-12 box-footer">
                <a href="<?=Url::to(['billing/view','id'=>$model->id])?>" class="btn btn-default pull-left">Reset</a> 
                <button type="submit" class="btn btn-default pull-right">Download</button> 
              </div>
              </div>
   
              <?php ActiveForm::end(); ?>
</div>
</div>
<?php
}
?>
</div>
</div>