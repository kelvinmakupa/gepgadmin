<?php
use yii\helpers\Html;
use app\models\SystemSetting;
/* @var $this \yii\web\View */
/* @var $content string */
$obj=SystemSetting::find()->one();
?>

<header class="main-header">
<b class="hidden-xs">
    <?= Html::a('<span class="logo-mini">'.$obj->acronym.'</span><span class="logo-lg text-bold">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
</b>
    <nav class="navbar navbar-static-top" role="navigation">


            <div class=" navbar-header">
                <span class="hidden-xs">
                <a href="<?=Yii::$app->homeUrl?>" class="navbar-brand"><b><?=$obj->full_name?></b> <?=$obj->sys_name?></a>
               </span>
                <center>
               <span class="visible-xs">

                    <p class="h3 pull-center" style="color:white" ><strong><?=$obj->full_name?></strong></p>

                    <span class="h4 pull-center" style="color:white"> <?=$obj->sys_name?></span>

               </span>
                </center>
            </div>

    </nav>
</header>
