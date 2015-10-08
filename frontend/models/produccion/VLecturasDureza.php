<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_LecturasDureza".
 *
 * @property integer $IdDureza
 * @property integer $IdProduccion
 * @property integer $IdProbeta
 * @property integer $IdLance
 * @property integer $IdAleacion
 * @property integer $IdPruebaDestructiva
 * @property integer $Dureza
 * @property integer $HRC
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Colada
 * @property integer $Lance
 * @property string $Identificador
 */
class VLecturasDureza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_LecturasDureza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdDureza', 'IdProduccion', 'IdProbeta', 'IdLance', 'IdAleacion', 'IdPruebaDestructiva', 'Dureza', 'HRC', 'Cantidad', 'Colada', 'Lance'], 'integer'],
            [['IdProbeta'], 'required'],
            [['Tipo', 'Identificador'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDureza' => 'Id Dureza',
            'IdProduccion' => 'Id Produccion',
            'IdProbeta' => 'Id Probeta',
            'IdLance' => 'Id Lance',
            'IdAleacion' => 'Id Aleacion',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'Dureza' => 'Dureza',
            'HRC' => 'Hrc',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'Identificador' => 'Identificador',
        ];
    }
}
