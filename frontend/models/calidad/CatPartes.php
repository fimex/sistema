<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "cat_partes".
 *
 * @property integer $id
 * @property string $no_parte
 * @property integer $cliente
 *
 * @property CatDimensiones[] $catDimensiones
 * @property CatClientes $cliente0
 * @property Mediciones[] $mediciones
 */
class CatPartes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_partes';
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
            [['no_parte', 'cliente'], 'required'],
            [['cliente'], 'integer'],
            [['no_parte'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_parte' => 'No Parte',
            'cliente' => 'Cliente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatDimensiones()
    {
        return $this->hasMany(CatDimensiones::className(), ['no_parte' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente0()
    {
        return $this->hasOne(CatClientes::className(), ['id' => 'cliente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediciones()
    {
        return $this->hasMany(Mediciones::className(), ['no_parte' => 'id']);
    }
}
