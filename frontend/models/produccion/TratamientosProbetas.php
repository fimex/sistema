<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "TratamientoProbetas".
 *
 * @property integer $idTratamientoProbetas
 * @property integer $IdLance
 * @property integer $Cantidad
 * @property integer $idProduccion
 *
 * @property Producciones $idProduccion0
 */
class TratamientosProbetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TratamientoProbetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdLance', 'Cantidad', 'idProduccion'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTratamientoProbetas' => 'Id Tratamiento Probetas',
            'IdLance' => 'Id Lance',
            'Cantidad' => 'Cantidad',
            'idProduccion' => 'Id Produccion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion0()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'idProduccion']);
    }
}
