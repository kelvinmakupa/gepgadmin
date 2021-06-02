<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Programmes */

$this->title = 'Criteria Configuration';

$script = <<< JS
    $(function() {
        //save the latest tab (http://stackoverflow.com/a/18845441)
        $('a[data-toggle="tab"]').on('click', function (e) {
            localStorage.setItem('lastTab', $(e.target).attr('href'));
        });

        //go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');

        if (lastTab) {
            $('a[href="'+lastTab+'"]').click();
        }
    });
JS;
$this->registerJs($script, yii\web\View::POS_END);

?>
<div class="panel panel-info">

    <div class="panel-heading">
        <i class="fa fa-gear"> </i><?= Html::encode( ' '.$program->programme_name) ?></div>

<div class="panel-body">

<?php

    $items = [
    [
    'label'=>'General Setting',
    'content' => $this->render('gen',['model'=>$general,'id'=>$program->id]),
    //  'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/personal/create'])],
    // 'active'=>true
    ],
    [
    'label'=>'Required Subject',
        'content' => $this->render('required_subjects',['model'=>$subject,'id'=>$program->id]),

    ],
    [
    'label'=>'Group Settings',
        'content' => $this->render('group_setting',['model'=>$group_setting,'id'=>$program->id]),

    ],
   /* [
        'label'=>'Subject Group',
        'content' => $this->render('subject_group',['model'=>$subject_group,'id'=>$program->id]),

    ],
    [
    'label'=>'Groups',
        'content' => $this->render('groups',['model'=>$groups]),

    ],
    /*[
    'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Dropdown',
    'items'=>[
    [
    'label'=>'Option 1',
    'encode'=>false,
    'content'=>$content3,
    ],
    [
    'label'=>'Option 2',
    'encode'=>false,
    'content'=>$content4,
    ],
    ],
    ],
    [
    'label'=>'<i class="glyphicon glyphicon-king"></i> Disabled',
    'headerOptions' => ['class'=>'disabled']
    ],
    */
    ];


echo yii\bootstrap\Tabs::widget([
    'items' => $items,
    'options' => ['tag' => 'div'],
    'itemOptions' => ['tag' => 'div'],
    'headerOptions' => ['class' => 'my-class'],
    'clientOptions' => ['collapsible' => false],
]);


    ?>



</div>
</div>
