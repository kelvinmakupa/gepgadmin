<?php
use yii\helpers\Html;
use app\models\ThemeManager;
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->user->isGuest) { 

 print("<script>location.href='".Yii::$app->urlManager->createUrl('site/login')."'</script>");

} else {

    frontend\assets\AdminLteAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/theme/adminlte/dist');

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>

    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode('GePG Admin | '.$this->title) ?></title>
		<link rel="shortcut icon" href="<?=Yii::getAlias('@web')?>/logo/logo.png" type="image/x-icon" />
	    <?php $this->head() ?>
    </head>
    <body class="hold-transition <?=ThemeManager::find()->where(['status'=>'1'])->one()->theme_name?> sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>
        <?= $this->render(
            'content.php',
            ['content' => $content]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
