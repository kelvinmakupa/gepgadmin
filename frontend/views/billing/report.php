<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\FeeStructure;
use app\models\TblBilling;
use yii\widgets\ActiveForm;
//require(Yii::getAlias('@vendor').'\packages\Classes\PHPExcel\IOFactory.php');
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblBillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students Billing Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-billing-index">

    <!--h1><?= Html::encode($this->title) ?></h1-->
    <?php echo $this->render('_report_search', ['model' => $searchModel]); ?>
	<?php 
	$obj=new TblBilling();
	?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
			[
				'attribute'=>'fee_structure_id',
				//'filter'=>ArrayHelper::map($obj->getFilter(),'id','name'),
				'value'=>function($dataProvider){
					$obj1=new TblBilling();
					return $obj1->getData($dataProvider->fee_structure_id);
				},
				
			],
            'reg_no',
            'invoice',
           // 'status',
            'billing_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php
/*
    if(isset($export)){

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getDefaultStyle()->getFont()->setSize('12');
    $heading ="STUDENT'S BILLING REPORT ";
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$heading )->mergeCells('A1:G1');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getDefaultStyle()->getFont()->setSize('10');
    $objPHPExcel->getActiveSheet(0)
    ->setCellValue('A2', '#')
    ->setCellValue('B2', 'REGISTRATION NUMBER')
    ->setCellValue('C2', 'INVOICE')
    ->setCellValue('D2', 'FEE TYPE')
    ->setCellValue('E2', 'AMOUNT(TAZ)')
    ->setCellValue('F2', 'AMOUNT(USD)')
    ->setCellValue('G2', 'BILLING DATE');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setARGB('99CCCCCC');
    $row=3;
    foreach($dataP->getModels() as $data){
        $taz=0;
        $usd=0;
        $query="select t.name as name,f.local_amount as taz,f.foreign_amount as usd from tbl_payment_type t,tbl_fee_structure f where f.payment_type_id=t.id and f.id=".$data->fee_structure_id;
        $comm=Yii::$app->db->createCommand($query)->queryOne();
        if(FeeStructure::checkNationality($data->reg_no)){
            $taz=$comm['taz'];
        }else{
            $usd=$comm['usd'];
        }

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$row-2);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$data->reg_no);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row,$data->invoice,PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$comm['name']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$taz);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$usd);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$data->billing_date);
    $row++ ;

    }
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'TOTAL');
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'=SUM(E3:E'.($row-1).')');
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'=SUM(F3:F'.($row-1).')');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getFont()->setBold(true);

    $filename = "Students Billing Report ".date('Y_m_d')." .xls";
    //header("Content-Disposition: attachment;filename=".$filename."");
    ob_end_clean();
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=".$filename."");
    header("Expires: 0");
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    }
*/
?>

</div>
