<?php
use yii\helpers\Html;
use app\models\ThemeManager;

  
    frontend\assets\AdminLteAsset::register($this);

    //dmstr\web\AdminLtePluginAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/theme/adminlte/dist');
	//print_r($directoryAsset);
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>

    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode('.:UDOM API | '.$this->title) ?>:.</title>
		<link rel="shortcut icon" href="<?=Yii::getAlias('@web')?>/logo/logo.png" type="image/x-icon" />
	    <?php $this->head() ?>
    </head>
    <body class="hold-transition <?=ThemeManager::find()->where(['status'=>'1'])->one()->theme_name?> layout-top-nav">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'non_auth_header.php',
           ['directoryAsset' => $directoryAsset]
        )
		?>
        
        <?= $this->render(
            'non_auth_content.php',
            ['content' => $content]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
