<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\mssql\PDO;

class Query extends Model
{

    public static function getContractNo($autoID, $contractType, $inst_shortname)
    {

        $query = Yii::$app->db->createCommand("SELECT getContractNo(:auto_id,:contract_type,:inst_shortname) AS contract_no");

        $query->bindParam(':auto_id', $autoID, PDO::PARAM_INT);
        $query->bindParam(':contract_type', $contractType, PDO::PARAM_STR);
        $query->bindParam(':inst_shortname', $inst_shortname, PDO::PARAM_STR);

        return $query->queryOne();

    }
    public static function getMaxContractValue()
    {

        $query = Yii::$app->db->createCommand("SELECT getMaxContractValue() AS max_value")->queryOne();

        return $query;

    }

}
