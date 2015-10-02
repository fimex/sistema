<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_LecturasCharpy".
 *
 * @property integer $IdProbetas
 * @property integer $IdLance
 * @property string $Tipo
 * @property integer $IdProbeta
 * @property string $SpecimenStandard
 * @property integer $IdPruebaDestructiva
 * @property double $Espesor
 * @property double $Ancho
 * @property double $Largo
 * @property double $Profundo
 * @property integer $Angulo
 * @property double $ResultadoLBFT
 * @property double $Temperatura
 */
class VLecturasCharpy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_LecturasCharpy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProbetas', 'IdLance', 'IdProbeta', 'IdPruebaDestructiva'], 'required'],
            [['IdProbetas', 'IdLance', 'IdProbeta', 'IdPruebaDestructiva', 'Angulo'], 'integer'],
            [['Tipo', 'SpecimenStandard'], 'string'],
            [['Espesor', 'Ancho', 'Largo', 'Profundo', 'ResultadoLBFT', 'Temperatura'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProbetas' => 'Id Probetas',
            'IdLance' => 'Id Lance',
            'Tipo' => 'Tipo',
            'IdProbeta' => 'Id Probeta',
            'SpecimenStandard' => 'Specimen Standard',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'Espesor' => 'Espesor',
            'Ancho' => 'Ancho',
            'Largo' => 'Largo',
            'Profundo' => 'Profundo',
            'Angulo' => 'Angulo',
            'ResultadoLBFT' => 'Resultado Lbft',
            'Temperatura' => 'Temperatura',
        ];
    }
}
