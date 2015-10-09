<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_LecturasCharpy".
 *
 * @property integer $IdCharpy
 * @property integer $IdPruebaDestructiva
 * @property integer $IdProduccion
 * @property string $SpecimenStandard
 * @property double $Espesor
 * @property double $Ancho
 * @property double $Largo
 * @property integer $Angulo
 * @property double $Profundo
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
            [['IdCharpy', 'IdPruebaDestructiva', 'IdProduccion'], 'required'],
            [['IdCharpy', 'IdPruebaDestructiva', 'IdProduccion', 'Angulo'], 'integer'],
            [['SpecimenStandard'], 'string'],
            [['Espesor', 'Ancho', 'Largo', 'Profundo', 'ResultadoLBFT', 'Temperatura'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCharpy' => 'Id Charpy',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'IdProduccion' => 'Id Produccion',
            'SpecimenStandard' => 'Specimen Standard',
            'Espesor' => 'Espesor',
            'Ancho' => 'Ancho',
            'Largo' => 'Largo',
            'Angulo' => 'Angulo',
            'Profundo' => 'Profundo',
            'ResultadoLBFT' => 'Resultado Lbft',
            'Temperatura' => 'Temperatura',
        ];
    }
}
