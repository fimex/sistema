<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "parmuestreo".
 *
 * @property integer $idMuestreo
 * @property integer $min
 * @property integer $cantidad
 *
 * @property CatMuestreo $idMuestreo0
 */
class Parmuestreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parmuestreo';
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
            [['idMuestreo', 'min', 'cantidad'], 'required'],
            [['idMuestreo', 'min', 'cantidad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMuestreo' => 'Id Muestreo',
            'min' => 'Min',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMuestreo0()
    {
        return $this->hasOne(CatMuestreo::className(), ['id' => 'idMuestreo']);
    }
}
