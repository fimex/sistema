<?php

namespace common\models\catalogos;

use Yii;
use common\models\catalogos\Aleaciones;

/**
 * This is the model class for table "Lances".
 *
 * @property integer $IdLance
 * @property integer $IdProduccion
 * @property integer $IdAleacion
 * @property integer $Colada
 * @property integer $Lance
 * @property integer $HornoConsecutivo
 * @property integer $Kellblocks
 * @property double  $Lingotes
 * @property integer $Probetas
 * @property string $inicioLance
 * @property string $horaVaciado
 *
 * @property Aleaciones $idAleacion
 * @property Producciones $idProduccion
 */
class Lances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Lances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['IdProduccion', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo'], 'required'],
            [['IdProduccion', 'IdAleacion', 'Colada', 'Lance', 'HornoConsecutivo', 'Kellblocks', 'Probetas'], 'integer'],
            [['Lingotes'], 'number'],
            [['inicioLance', 'horaVaciado'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdLance' => 'Id Lance',
            'IdProduccion' => 'Id Produccion',
            'IdAleacion' => 'Id Aleacion',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'HornoConsecutivo' => 'Horno Consecutivo',
            'Kellblocks' => 'Kellblocks',
            'Lingotes' => 'Lingotes',
            'Probetas' => 'Probetas',
			'inicioLance' => 'Inicio Lance',
            'horaVaciado' => 'Hora Vaciado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAleacion()
    {
        return $this->hasOne(Aleaciones::className(), ['IdAleacion' => 'IdAleacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
}
