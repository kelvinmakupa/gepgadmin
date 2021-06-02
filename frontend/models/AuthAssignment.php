<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }





    public function assign($id,$items)
    {
        $success = 0;
        foreach ($items as $name) {
            try {
                $query=Yii::$app->db->createCommand("INSERT INTO auth_assignment(user_id,item_name)VALUES(:user_id,:item)");
                $query->bindValues([':user_id'=>$id,':item'=>$name]);
                $query->execute();
                $success++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        return $success;
    }

    /**
     * Revokes a roles from a user.
     * @param array $items
     * @return integer number of successful revoke
     */
    public function revoke($id,$items)
    {
        $success = 0;
        foreach ($items as $name) {
            try {
                $query=Yii::$app->db->createCommand("DELETE  FROM auth_assignment WHERE user_id=:user_id AND item_name=:item");
                $query->bindValues([':user_id'=>$id,':item'=>$name]);
                $query->execute();
                $success++;
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        return $success;
    }

    /**
     * Get all available and assigned roles/permission
     * @return array
     */
    public function getItems($id)
    {
        $available = [];
        foreach (AuthItem::getRoles() as $key=>$name) {
            $available[$name['name']] = 'role';
        }

        foreach (AuthItem::getPermissions() as $name) {

                $available[$name['name']] = 'permission';

        }

        $assigned = [];
        foreach (self::getAssignments($id) as $key=>$item) {
            $assigned[$item['item_name']] = $available[$item['item_name']];
            unset($available[$item['item_name']]);

        }

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }



    public static function getAssignments($user_id){


        return AuthAssignment::find()->select('item_name')->where('user_id=:id',[':id'=>$user_id])->asArray()->all();


    }







    /**
     * @inheritdoc
     */
    public function __get($name)
    {
//        if ($this->user) {
//            return $this->user->$name;
//        }


        return $name;
    }

}
