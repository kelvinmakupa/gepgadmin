<?php

use yii\helpers\Html;
use app\models\User;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
if (!Yii::$app->user->isGuest){
$modelx=app\models\User::find()->where(['id'=>Yii::$app->user->identity->id])->one();

?>
<div class="panel panel-info">
	<div class="panel-body">

		<div class="col-lg-6">
			<?= $this->render('_profile', [
				'model' => $model,
			]) ?>

		</div>
	</div>
	<?php
	}

	?>
</div>
