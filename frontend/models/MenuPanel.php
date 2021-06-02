<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu_panel".
 *
 * @property string $id
 * @property string $type
 * @property string $parent_id
 * @property string $name
 * @property string $redirect
 * @property integer $user
 * @property integer $status
 * @property integer $order_index
 * @property string $icon
 */
class MenuPanel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_panel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'status','redirect'], 'required'],
            [['parent_id', 'status', 'order_index','user'], 'integer'],
            [['type', 'name', 'redirect', 'icon'], 'string', 'max' => 45],
            //[['user'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'redirect' => 'Redirect',
            'user' => 'User',
            'status' => 'Status',
            'order_index' => 'Order Index',
            'icon' => 'Icon',
            //'role_id' => 'Role ID',
        ];
    }


    public static function getStatus(){

        return array(['id'=>0,'name'=>'In-Active'],['id'=>'10','name'=>'Active']);
    }






    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }
    public static function getMenu()
    {
        $role_id = 0;
        $result = static::getMenuRecrusive($role_id);
        return $result;
    }

    private static function getMenuRecrusive($parent)
    {
        int: $i=0;
        $items = MenuPanel::find()
            ->where('parent_id=:pid',['pid' => $parent])
            ->andWhere('status=:sts',['sts' => 10])
            ->orderBy('order_index')
            ->asArray()
            ->all();
        $result = [];
	//	print("<br/>");
		//print("<br/>");
	//	print_r($items);
        foreach ($items as $item) {


            if($item['redirect']=="#"){
                //echo "<br/>".$item['name']."->".self::countNumberOfAccessibleChild($item['id']);
                if(self::countNumberOfAccessibleChild($item["id"]) > 0) {
                    $result[] = [
                        'label' => "<span>" . $item['name'] . "</span>",
                        'url' => $item['redirect'] === '#' ? '#' : [$item['redirect']],
                        'icon' => "<i class='fa " . $item['icon'] . "'></i>",
                        'options' => $item['redirect'] === '#' ? ['class' => 'treeview'] : [],
                        'items' => $item['redirect'] === '#' ? self::getMenuRecrusive($item['id']) : [],
                        '<li class="divider"></li>',
                    ];
                }
            }else {
                $link=preg_split("#/#",$item['redirect']);

//                $route=count($link) > 2 ? $link[0].'-'.$link[2].'-'.\frontend\components\Inflect::singularize($link[1]):$link[1].'-'.\frontend\components\Inflect::singularize($link[0]);
                $route=count($link) > 2 ? $link[0].'-'.$link[2].'-'.$link[1]:$link[1].'-'.$link[0];
				
				if (\Yii::$app->user->can($route)) {
                // echo "<br/>".$route;
                    $result[] = [
                        'label' =>"<span>".$item['name']."</span>",
                        'url' =>$item['redirect']==='#'?'#':[$item['redirect']],
                        'icon'=>"<i class='fa ".$item['icon']."'></i>",
                        'options'=>$item['redirect']==='#'?['class'=>'treeview']:[],
                        'items' => $item['redirect']==='#'?self::getMenuRecrusive($item['id']):[],
                        '<li class="divider"></li>',
                    ];
                }
            }
            //echo "<br/>".preg_replace("#/#",'-',$item['redirect']);

        }
        return $result;
    }
    private static function countNumberOfAccessibleChild($parent_id){
        $count_pid=0;
        $items = MenuPanel::find()
            ->where('status=:sts',['sts' => 10])
            ->andWhere('redirect<>:link',['link'=>"#"])
            ->orderBy('order_index')
            ->asArray()
            ->all();
        foreach($items as $item){
            $link=preg_split("#/#",$item['redirect']);
            $route=count($link) > 2 ? $link[0].'-'.$link[2].'-'.$link[1]:$link[1].'-'.$link[0];
            if($item["parent_id"]==$parent_id && \Yii::$app->user->can($route)) {
                $count_pid++;
            }
        }
        return $count_pid;
    }


    public static function getActions($controller){
        $actions='';

        if(Yii::$app->user->can('view-'.$controller)){
            $actions.='{view} ';
        }
        if(Yii::$app->user->can('reverse-'.$controller)){
            $actions.='{reverse} ';
        }
        if(Yii::$app->user->can('normal-'.$controller)){
            $actions.='{normal} ';
        }
        if(Yii::$app->user->can('update-'.$controller)){
            $actions.='{update} ';
        }
        if(Yii::$app->user->can('delete-'.$controller)){
            $actions.='{delete} ';
        }
        if(Yii::$app->user->can('criteria-'.$controller)){
            $actions.='{criteria} ';
        }

        if(Yii::$app->user->can('password-'.$controller)){
            $actions.='{password} ';
        }

        if(Yii::$app->user->can('gview-'.$controller)){
            $actions.='{gview} ';
        }

        return $actions;
    }



    public function behaviors()
    {
        return [
            'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }
}
