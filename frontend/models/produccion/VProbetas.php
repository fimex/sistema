<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_Probetas".
 *
 * @property integer $IdProduccion
 * @property integer $IdLance
 * @property integer $IdProbeta
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $IdAleacion
 * @property integer $Colada
 * @property integer $Lance
 * @property integer $HornoConsecutivo
 * @property integer $Kellblocks
 * @property integer $Lingotes
 * @property integer $Probetas
 */
class VProbetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Probetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdLance', 'IdProbeta', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo'], 'required'],
            [['IdProduccion', 'IdLance', 'IdProbeta', 'Cantidad', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo', 'Kellblocks', 'Lingotes', 'Probetas'], 'integer'],
            [['Tipo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdLance' => 'Id Lance',
            'IdProbeta' => 'Id Probeta',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'IdAleacion' => 'Id Aleacion',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'HornoConsecutivo' => 'Horno Consecutivo',
            'Kellblocks' => 'Kellblocks',
            'Lingotes' => 'Lingotes',
            'Probetas' => 'Probetas',
        ];
    }
}
