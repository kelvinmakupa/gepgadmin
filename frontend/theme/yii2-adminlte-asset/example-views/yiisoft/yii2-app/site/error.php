<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = '';

$exception = Yii::$app->errorHandler->exception;
$header=$exception->getName();
$code=$exception->statusCode;
$a=getDetails($code);
?>
<section class="content">


</section>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline <?=$a['text-color']?>"><?=$code?></h2>

        <div class="error-content">
            <h3><i class="fa <?=$a['icon']?> text-red"></i> <?=$header?>.</h3>

            <p>
                <?= nl2br(Html::encode($message)) ?><br/>
                Meanwhile, you may <a href='<?= Yii::$app->homeUrl ?>'>return to dashboard</a>
            </p>
            <h1><?= Html::encode($this->title) ?></h1>

            <form class="search-form">
                <!--div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div-->
                <!-- /.input-group -->
            </form>
        </div>
    </div>
    <!-- /.error-page -->

</section>


<?php

function getDetails($code){
$data;
if($code==403){
    $data=['text-color'=>'text-red','icon'=>'fa-lock'];
}else{
    $data=['text-color'=>'text-red','icon'=>'fa-warning'];
}

return $data;
}
?>