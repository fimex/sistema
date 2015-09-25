<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "menu_tipo".
 *
 * @property integer $menu
 * @property integer $tipo
 *
 * @property Menu $menu0
 * @property Tipo $tipo0
 */
class MenuTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_tipo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mysql_calidad');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu', 'tipo'], 'required'],
            [['menu', 'tipo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu' => 'Menu',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu0()
    {
        return $this->hasOne(Menu::className(), ['parte' => 'menu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Tipo::className(), ['id' => 'tipo']);
    }
}
