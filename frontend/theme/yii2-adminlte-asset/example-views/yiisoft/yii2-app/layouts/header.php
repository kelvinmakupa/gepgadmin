<?php
use yii\helpers\Html;
use app\models\SystemSetting;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?php
    $name='';
    if($obj=SystemSetting::find()->one()){
        $name=$obj->acronym;
    }
    ?>
    <b class="hidden-xs">
        <?= Html::a('<span class="logo-mini">GePG</span><span class="logo-lg text-bold">' . $name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
    </b>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class=" navbar-header">
                <span class="hidden-xs">
                <a href="<?=Yii::$app->homeUrl?>" class="navbar-brand"><b><?=$obj->full_name?></b> <?=$obj->sys_name?></a>
               </span>
            <center>
               <span class="visible-xs">

                    <p class="h3 pull-center" style="color:white" ><strong><?=SystemSetting::find()->one()->full_name?></strong></p>

               </span>
            </center>
        </div>



        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Yii::getAlias('@web').'/uploads/'.Yii::$app->user->identity->avatar ?>" class="user-image" alt="User Image" style="background-color: #ffffff"/>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Yii::getAlias('@web').'/uploads/'.Yii::$app->user->identity->avatar ?>" class="img-circle" alt="User Image" style="background-color: #ffffff"/>

                            <p>
                                <?=\app\models\AccountRole::getRoleName(Yii::$app->user->identity->role_id)?>
                                <small>Member since <?=date('M. Y',Yii::$app->user->identity->created_at)?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-body">

                            <div class="pull-left">
                                <a href="<?=Yii::$app->urlManager->createUrl('user/profile')?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-warning text-bold']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
