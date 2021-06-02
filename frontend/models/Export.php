<?php
namespace app\models;
/**
 * Created by PhpStorm.
 * User: edward
 * Date: 30/04/2018
 * Time: 15:21
 */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use app\models\Common;

class Export
{
    
    public $spreadsheet;
    public $heading;   

    public function __construct(){
        $this->spreadsheet=new Spreadsheet();
        $this->heading = strtoupper(SystemSetting::find()->one()->full_name);

    }   

    public function dataPopulation($data,$date){

        $tab=0;
        //$data=$dataProviderR->getModels();

        $students_chunk=array_chunk($data,30000);
        foreach($students_chunk as $student){

            $data=$this->spreadsheet->createSheet($tab);
            $data->setTitle('Reconciliation');
            $this->spreadsheet->getActiveSheet();

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('16');
            $heading = "THE UNIVERSITY OF DODOMA";
            $data->setCellValue('A1', $heading)->mergeCells('A1:P1');
            $data->getStyle('A1')->getFont()->setBold(true);
            $data->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('14');
            $heading = "RECONCILIATION DETAILS OF ".$date;
            $data->setCellValue('A2', $heading)->mergeCells('A2:P2');
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF999999');

            for ($col = 'A'; $col !== 'Q'; $col++) {
                $this->spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('12');
            $this->spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $data->setCellValue('A3', '#')
                ->setCellValue('B3', 'Transaction Id')
                ->setCellValue('C3', 'Control Number')
                ->setCellValue('D3', 'Transaction Id(Payment Service Provider)')
                ->setCellValue('E3', 'Paid Amount')
                ->setCellValue('F3', 'Currency')
                ->setCellValue('G3', 'Gepg Receipt')
                ->setCellValue('H3', 'Transaction Date')
                ->setCellValue('I3', 'Credited Account Number')
                ->setCellValue('J3', 'Payment Channel')
                ->setCellValue('K3', 'Payment Service Provider Name')
                ->setCellValue('L3', 'Payment Service Provider Code')
                ->setCellValue('M3', 'Depositor Phone Number')
                ->setCellValue('N3', 'Depositor name')
                ->setCellValue('O3', 'Depositor Email Address')
                ->setCellValue('P3', 'Remarks');

            $i=4;
            $tab++;
            $sn=1;
            foreach ($student as $key=>$value) {
                $data->setCellValue('A'.$i, $sn)
                    ->setCellValue('B'.$i, $value->SpBillId)
                    ->setCellValue('C'.$i, $value->BillCtrNum)
                    ->setCellValue('D'.$i, $value->pspTrxId)
                    ->setCellValue('E'.$i, $value->PaidAmt)
                    ->setCellValue('F'.$i, $value->CCy)
                    ->setCellValue('G'.$i, $value->PayRefId)
                    ->setCellValue('H'.$i, $value->TrxDtTm)
                    ->setCellValue('I'.$i, $value->CtrAccNum)
                    ->setCellValue('J'.$i, $value->UsdPayChnl)
                    ->setCellValue('K'.$i, $value->PspName)
                    ->setCellValue('L'.$i, $value->PspCode)
                    ->setCellValue('M'.$i, $value->DptCellNum)
                    ->setCellValue('N'.$i, $value->DptName)
                    ->setCellValue('O'.$i, $value->DptEmailAddr)
                    ->setCellValue('P'.$i, $value->Remarks);
                $i++;
                $sn++;
            }
        }



    }
    public function generateData($data){

        $tab=0;
        //$data=$dataProviderR->getModels();

        $students_chunk=array_chunk($data,30000);
        foreach($students_chunk as $student){

            $data=$this->spreadsheet->createSheet($tab);
            $data->setTitle('Bills Report');
            $this->spreadsheet->getActiveSheet();

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('16');
            $heading = "THE UNIVERSITY OF DODOMA";
            $data->setCellValue('A1', $heading)->mergeCells('A1:S1');
            $data->getStyle('A1')->getFont()->setBold(true);
            $data->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('14');
            $heading = "GENERATED BIllS REPORT ";
            $data->setCellValue('A2', $heading)->mergeCells('A2:S2');
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $this->spreadsheet->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:S3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF999999');

            for ($col = 'A'; $col !== 'T'; $col++) {
                $this->spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('12');
            $this->spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $data->setCellValue('A3', '#')
                ->setCellValue('B3', 'Payer Name')
                ->setCellValue('C3', 'Bill Amount')
                ->setCellValue('D3', 'Bill Expire Date')
                ->setCellValue('E3', 'Bill Description')
                ->setCellValue('F3', 'Bill Genenerated By')
                ->setCellValue('G3', 'Bill Approved By')
                ->setCellValue('H3', 'Payer Phone Number')
                ->setCellValue('I3', 'Payer Email')
                ->setCellValue('J3', 'Bill Currency')
                ->setCellValue('K3', 'Payment Type')
                ->setCellValue('L3', 'Bill Generated Date')
                ->setCellValue('M3', 'Bill ID')
                ->setCellValue('N3', 'Control Number')
                ->setCellValue('O3', 'Bill Payment Option')
                ->setCellValue('P3', 'Bill Equivalent Amount')
                ->setCellValue('Q3', 'Bill Item Ref')
                ->setCellValue('R3', 'Is Posted')
                ->setCellValue('S3', 'Is Cancelled');

            $i=4;
            $tab++;
            $sn=1;

            foreach ($student as $key=>$value) {
                $data->setCellValue('A'.$i, $sn)
                    ->setCellValue('B'.$i, $value->payer_name)
                    ->setCellValue('C'.$i, $value->bill_amount)
                    ->setCellValue('D'.$i, $value->bill_exp_date)
                    ->setCellValue('E'.$i, $value->bill_description)
                    ->setCellValue('F'.$i, $value->bill_gen_by)
                    ->setCellValue('G'.$i, $value->bill_appr_by)
                    ->setCellValue('H'.$i, $value->payer_cell_num)
                    ->setCellValue('I'.$i, $value->payer_email)
                    ->setCellValue('J'.$i, $value->bill_currency)
                    ->setCellValue('K'.$i, Common::getPaymentNameById($value->payment_type_id))
                    ->setCellValue('L'.$i, $value->bill_gen_date)
                    ->setCellValue('M'.$i, $value->bill_id)
                    ->setCellValue('N'.$i, $value->control_number)
                    ->setCellValue('O'.$i, Common::getPaymentOption($value->bill_pay_opt))
                    ->setCellValue('P'.$i, $value->bill_eqv_amount)
                    ->setCellValue('Q'.$i, $value->bill_item_ref)
                    ->setCellValue('R'.$i, Common::isPosted($value->is_posted))
                    ->setCellValue('S'.$i, Common::isCancelled($value->is_cancelled));
                $i++;
                $sn++;
            }
        }



    }

    public function download($file_name){

        $this->spreadsheet->getActiveSheet();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 12 Feb 2018 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($this->spreadsheet);
        $writer->save(Yii::$app->request->BaseUrl.'recon_files/'.$file_name);
//        ob_end_clean();
//        $writer->save('php://output');

    }


    public function transactionReport($data,$start,$end){

        $tab=0;

        $students_chunk=array_chunk($data,30000);
        foreach($students_chunk as $student){

            $data=$this->spreadsheet->createSheet($tab);
            $data->setTitle('Transaction Report');
            $this->spreadsheet->getActiveSheet();

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('16');
            $data->setCellValue('A1', $this->heading)->mergeCells('A1:P1');
            $data->getStyle('A1')->getFont()->setBold(true);
            $data->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('14');
            $heading = "TRANSACTION REPORT FROM {$start} TO {$end} ";
            $data->setCellValue('A2', $heading)->mergeCells('A2:P2');
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:P3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF999999');

            for ($col = 'A'; $col !== 'Q'; $col++) {
                $this->spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

            }

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('12');
            $this->spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $data->setCellValue('A3', '#')
                ->setCellValue('B3', 'Transaction ID')
                ->setCellValue('C3', 'Payment Reference ID')
                ->setCellValue('D3', 'Payment Service Provider Name')
                ->setCellValue('E3', 'Paymenr Service Provider Receipt Number')
                ->setCellValue('F3', 'Credited Account Number')
                ->setCellValue('G3', 'Currency')
                ->setCellValue('H3', 'Paid Amount')
                ->setCellValue('I3', 'Payer Name')
                ->setCellValue('J3', 'Bill Description')
                ->setCellValue('K3', 'Payer Cell Number')
                ->setCellValue('L3', 'Control Number')
                ->setCellValue('M3', 'Bill Item Reference')
                ->setCellValue('N3', 'Transaction Date Time')
                ->setCellValue('O3', 'Account Code')
                ->setCellValue('P3', 'Account Code Description');

            $i=4;
            $tab++;
            $sn=1;

            foreach ($student as $key=>$value) {
                $data->setCellValue('A'.$i, $sn)
                    ->setCellValue('B'.$i, $value['trx_id'])
                    ->setCellValue('C'.$i, $value['pay_ref_id'])
                    ->setCellValue('D'.$i, $value['psp_name'])
                    ->setCellValue('E'.$i, $value['psp_receipt_num'])
                    ->setCellValue('F'.$i, $value['ctr_acc_num'])
                    ->setCellValue('G'.$i, $value['ccy'])
                    ->setCellValue('H'.$i, $value['paid_amount'])
                    ->setCellValue('I'.$i, $value['payer_name'])
                    ->setCellValue('J'.$i, $value['bill_description'])
                    ->setCellValue('K'.$i, $value['payer_cell_num'])
                    ->setCellValue('L'.$i, $value['control_number'])
                    ->setCellValue('M'.$i, $value['bill_item_ref'])
                    ->setCellValue('N'.$i, $value['trx_dt_tm'])
                    ->setCellValue('O'.$i, $value['acc_code'])
                    ->setCellValue('P'.$i, $value['acc_description'])
                    ;
                $i++;
                $sn++; 
            }
        }



    }


  public function uploadedBills($uploaded_bills){

            $data=$this->spreadsheet->createSheet(0);
            $data->setTitle('Uploaded Bills Report');
            $this->spreadsheet->getActiveSheet();

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('16');
            $heading = "THE UNIVERSITY OF DODOMA";
            $data->setCellValue('A1', $heading)->mergeCells('A1:M1');
            $data->getStyle('A1')->getFont()->setBold(true);
            $data->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('14');
            $heading = "UPLOADED BIllS REPORT ";
            $data->setCellValue('A2', $heading)->mergeCells('A2:M2');
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $this->spreadsheet->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:M3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF999999');

            for ($col = 'A'; $col !== 'N'; $col++) {
                $this->spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('12');
            $this->spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $data->setCellValue('A3', '#')
                ->setCellValue('B3', 'Payer Name')
                ->setCellValue('C3', 'Bill Amount')
                ->setCellValue('D3', 'Bill Description')
                ->setCellValue('E3', 'Bill Genenerated By')
                ->setCellValue('F3', 'Bill Approved By')
                ->setCellValue('G3', 'Bill Currency')
                ->setCellValue('H3', 'Payment Type')
                ->setCellValue('I3', 'Bill Payment Option')
                ->setCellValue('J3', 'Control Number')
                ->setCellValue('K3', 'Bill Item Ref')
                ->setCellValue('L3', 'Bill Generated Date')
                ->setCellValue('M3', 'Bill Expire Date');

            $i=4;
            $sn=1;

            foreach ($uploaded_bills as $key=>$value) {
                $data->setCellValue('A'.$i, $sn)
                    ->setCellValue('B'.$i, $value['payer_name'])
                    ->setCellValue('C'.$i, $value['bill_amount'])
                    ->setCellValue('D'.$i, $value['bill_description'])
                    ->setCellValue('E'.$i, $value['bill_gen_by'])
                    ->setCellValue('F'.$i, $value['bill_appr_by'])
                    ->setCellValue('G'.$i, $value['bill_currency'])
                    ->setCellValue('H'.$i, $value['payment_type'])
                    ->setCellValue('I'.$i, Common::getPaymentOption($value['bill_pay_opt']))
                    ->setCellValue('J'.$i, $value['control_number'])
                    ->setCellValue('K'.$i, $value['bill_item_ref'])
                    ->setCellValue('L'.$i, $value['bill_gen_date'])
                    ->setCellValue('M'.$i, $value['bill_exp_date']);
                $i++;
                $sn++;
            }

    }

    public function auditTrailReport($data,$start,$end){

        $tab=0;

        $students_chunk=array_chunk($data,30000);
        foreach($students_chunk as $student){

            $data=$this->spreadsheet->createSheet($tab);
            $data->setTitle('Transaction Report');
            $this->spreadsheet->getActiveSheet();

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('16');
            $data->setCellValue('A1', $this->heading)->mergeCells('A1:N1');
            $data->getStyle('A1')->getFont()->setBold(true);
            $data->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('14');
            $heading = "AUDIT TRAIL REPORT FROM {$start} TO {$end} ";
            $data->setCellValue('A2', $heading)->mergeCells('A2:N2');
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $this->spreadsheet->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $this->spreadsheet->getActiveSheet()->getStyle('A3:N3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF999999');

            for ($col = 'A'; $col !== 'O'; $col++) {
                $this->spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

            }

            $this->spreadsheet->getDefaultStyle()->getFont()->setSize('12');
            $this->spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $data->setCellValue('A3', '#')
                ->setCellValue('B3', 'First Name')
                ->setCellValue('C3', 'Middle Name')
                ->setCellValue('D3', 'Surname')
                ->setCellValue('E3', 'IP')
                ->setCellValue('F3', 'Request Method')
                ->setCellValue('G3', 'Route')
                ->setCellValue('H3', 'Action')
                ->setCellValue('I3', 'Model')
                ->setCellValue('J3', 'Model Id')
                ->setCellValue('K3', 'Field')
                ->setCellValue('L3', 'Old Value')
                ->setCellValue('M3', 'New Value')
                ->setCellValue('N3', 'Created At');

            $i=4;
            $tab++;
            $sn=1;
            foreach ($student as $key=>$value) {
                $data->setCellValue('A'.$i, $sn)
                    ->setCellValue('B'.$i, $value['first_name'])
                    ->setCellValue('C'.$i, $value['last_name'])
                    ->setCellValue('D'.$i, $value['surname'])
                    ->setCellValue('E'.$i, $value['ip'])
                    ->setCellValue('F'.$i, $value['request_method'])
                    ->setCellValue('G'.$i, $value['route'])
                    ->setCellValue('H'.$i, $value['action'])
                    ->setCellValue('I'.$i, $value['model'])
                    ->setCellValue('J'.$i, $value['model_id'])
                    ->setCellValue('K'.$i, $value['field'])
                    ->setCellValue('L'.$i, $value['old_value'])
                    ->setCellValue('M'.$i, $value['new_value'])
                    ->setCellValue('N'.$i, $value['created']);
                $i++;
                $sn++;
            }
        }
    }







 public function downloadBills($file_name){

        $this->spreadsheet->getActiveSheet();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 12 Feb 2018 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($this->spreadsheet);
//        $writer->save(Yii::$app->request->BaseUrl.'recon_files/'.$file_name);
        ob_end_clean();
        $writer->save('php://output');

    }

}


