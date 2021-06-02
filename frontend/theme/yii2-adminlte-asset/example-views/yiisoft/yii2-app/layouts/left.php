<?php
use app\models\PersonalDetails;
use app\models\Application;
use app\models\AcademicYear;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?=Yii::getAlias('@web') . '/logo/user.png' ?>"  
                     alt="oas udom" class="img-circle" alt="User Image"/>
                <!--img src="<?= Yii::getAlias('@web') . '/uploads/user.gif' ?>" alt="oas udom" class="img-circle" alt="User Image"/-->
            </div>
            <div class="pull-left info">
                <p><?= ucfirst(Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->surname) ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <!--input type="hidden" name="q" class="form-control" placeholder="Search..." readonly/>
              <span class="input-group-btn">
                <button type='button' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span-->
            </div>
        </form>


        <?php

        if (!Yii::$app->user->isGuest) {

            if ((Yii::$app->user->identity->role_id >= 9) && (Yii::$app->user->identity->role_id <= 14)) { ?>
                <ul class="sidebar-menu">
                    <?php
                    if (Yii::$app->user->can('dashboard-site')) {
                        ?>
                        <li>
                            <a href="<?= Yii::$app->urlManager->createUrl('site/index') ?>">
                                <i class="fa fa-info"></i> <span>Information</span>

                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php
                    } ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span>Personal Information</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= (Yii::$app->user->can('create-personal')&&!PersonalDetails::check()) ? "<li><a href=" . Yii::$app->urlManager->createUrl('personal/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('index-personal')&&PersonalDetails::check()) ? "<li><a href=" . Yii::$app->urlManager->createUrl('personal/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?= Yii::$app->urlManager->createUrl('payment/how_to_pay') ?>">
                            <i class="fa fa-diamond"></i> <span>Payment</span>

                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span>Academic Results</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#"><i class="fa fa-angle-double-right"></i> Form Four
                                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?= (Yii::$app->user->can('create-ordinary')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('ordinary/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                                    <?= (Yii::$app->user->can('index-ordinary')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('ordinary/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>

                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-angle-double-right"></i> Form Six
                                    <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?= (Yii::$app->user->can('create-advanced')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('advanced/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                                    <?= (Yii::$app->user->can('index-advanced')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('advanced/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-graduation-cap"></i>
                            <span>Educational Qualification</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= (Yii::$app->user->can('create-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/create') . "><i class='fa fa-plus'></i>Add Certificate Qualification</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('diploma-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/diploma') . "><i class='fa fa-plus'></i> Add Diploma/Certificates</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('index-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/index') . "><i class='fa fa-eye'></i> View Qualification</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('pgd-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/pgd') . "><i class='fa fa-plus'></i>Add Post Graduate Diploma</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('bachelor-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/bachelor') . "><i class='fa fa-plus'></i>Add Bachelor</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('masters-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/masters') . "><i class='fa fa-plus'></i>Add Masters</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('data-qualification')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('qualification/data') . "><i class='fa fa-eye'></i> View Qualification</a></li>" : '' ?>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-certificate"></i>
                            <span>Attachment Panel</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= (Yii::$app->user->can('create-certificate')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('certificate/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('index-certificate')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('certificate/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <?php
                    if ((Yii::$app->user->identity->role_id >= '12') && (Yii::$app->user->identity->role_id <= '14')) {
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span>Employment Record</span>
                                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?= (Yii::$app->user->can('create-experience')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('experience/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                                <?= (Yii::$app->user->can('index-experience')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('experience/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>
                            </ul>
                        </li>

                        <li class="divider"></li>
                        <?php
                    }
                    if ((Yii::$app->user->identity->role_id >= '12') && (Yii::$app->user->identity->role_id <= '14')) {
                    ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-briefcase"></i>
                            <span>Financial Arrangement</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= (Yii::$app->user->can('create-funding')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('funding/create') . "><i class='fa fa-plus'></i>Add Details</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('index-funding')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('funding/index') . "><i class='fa fa-eye'></i> View Details</a></li>" : '' ?>
                        </ul>
                    </li>
                    <?php
                    } if (Yii::$app->user->can('create-referee')) { ?>
                        <li class="divider"></li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Referee Details</span>
                                <span class="pull-right-container"> 
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?= (Yii::$app->user->can('create-referee')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('referee/create') . "><i class='fa fa-plus'></i>Add Referee</a></li>" : '' ?>
                                <?= (Yii::$app->user->can('index-referee')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('referee/index') . "><i class='fa fa-eye'></i> View Referees</a></li>" : '' ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="divider"></li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>Application</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <?= (Yii::$app->user->can('graduate-application')&&!(app\models\Application::find()->where(['user_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year'=>\app\models\AcademicYear::find()->where(['status'=>'1'])->one()->academic_year])->one())) ? "<li><a href=" . Yii::$app->urlManager->createUrl('application/graduate') . "><i class='fa fa-plus'></i>Apply Programme</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('apply-application')&&!(\app\models\TcuSelection::find()->where(['user_id'=>Yii::$app->user->identity->user_id])->one())) ? "<li><a href=" . Yii::$app->urlManager->createUrl('application/apply') . "><i class='fa fa-plus'></i>Apply Programme</a></li>" : '' ?>
                            <?= (Yii::$app->user->can('index-application')) ? "<li><a href=" . Yii::$app->urlManager->createUrl('application/index') . "><i class='fa fa-eye'></i> My Application</a></li>" : '' ?>
                        </ul>
                    </li>
					
                    <li class="divider"></li>
                </ul>


            <?php } else {

                echo frontend\components\NavWidget::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'labelTemplate' => '<a href="#">{icon}<span> {label}</span>{right-icon}{badge}</a>',
                    'linkTemplate' => '<a href="{url}">{icon}<span> {label}</span>{right-icon}{badge}</a>',
                    'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                    'activateParents' => true,
                    'items' => app\models\MenuPanel::getMenu()
                ]);

            }


        }

        ?>


    </section>

</aside>


