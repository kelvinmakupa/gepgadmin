<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }




    public static function getRoles(){

        return AuthItem::find()->select('name')->where('type=:t',[':t'=>1])->asArray()->all();

    }


     public static function getPermissions(){

        return AuthItem::find()->select('name')->where('type=:t',[':t'=>2])->asArray()->all();

    }




    public function getItems($parent)
    {
        $available = [];
        foreach (AuthItem::getRoles() as $key=>$name) {
            if($name['name']!=$parent) {
                $available[$name['name']] = 'role';
            }
        }

        foreach (AuthItem::getPermissions() as $name) {
            if($name['name']!=$parent) {
                $available[$name['name']] = 'permission';
            }
        }

        $assigned = [];
        foreach (self::getChildrens($parent) as $key=>$item) {
            $assigned[$item['item_name']] = $available[$item['item_name']];
            unset($available[$item['item_name']]);

        }

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }





    public function addChildren($items,$id){

        $success=0;

        foreach($items as $key=>$value){

        Yii::$app->db->createCommand()->insert('auth_item_child',
            [
                'parent'=>$id,
                'child'=>$value
            ])->execute();
            $success++;
        }
    return $success;

    }
  public function removeChildren($items,$id){


        $success=0;

        foreach($items as $key=>$value){

        $query=Yii::$app->db->createCommand('delete from auth_item_child where  parent=:parent and child=:child');
        $query->bindValues([':parent'=>$id,':child'=>$value]);
        $query->execute();
            $success++;
        }
    return $success;

    }




    public static function getChildrens($parent){

        $query=Yii::$app->db->createCommand("select child as item_name from auth_item_child where parent=:parent");
        $query->bindValue(':parent',$parent);
        $results=$query->queryAll();

        return $results;
    }







    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }
}
