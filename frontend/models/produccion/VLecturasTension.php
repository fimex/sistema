<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_LecturasTension".
 *
 * @property integer $IdTension
 * @property integer $IdProduccion
 * @property integer $IdProbeta
 * @property integer $IdLance
 * @property integer $IdAleacion
 * @property integer $IdPruebaDestructiva
 * @property integer $PsiTensileStrength
 * @property string $MpaTensileStrengh
 * @property integer $PsiYieldStrength
 * @property string $MpaYieldStrengh
 * @property string $Elongacin
 * @property string $ReduccionArea
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Colada
 * @property integer $Lance
 * @property string $Aleacion
 * @property integer $IdDureza
 * @property string $DiametroHuella
 * @property integer $Dureza
 * @property integer $HRC
 */
class VLecturasTension extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_LecturasTension';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTension', 'IdProduccion', 'IdProbeta', 'IdLance', 'IdAleacion', 'IdPruebaDestructiva', 'PsiTensileStrength', 'PsiYieldStrength', 'Cantidad', 'Colada', 'Lance', 'IdDureza', 'Dureza', 'HRC'], 'integer'],
            [['IdProbeta'], 'required'],
            [['MpaTensileStrengh', 'MpaYieldStrengh', 'Elongacin', 'ReduccionArea', 'DiametroHuella'], 'number'],
            [['Tipo', 'Aleacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTension' => 'Id Tension',
            'IdProduccion' => 'Id Produccion',
            'IdProbeta' => 'Id Probeta',
            'IdLance' => 'Id Lance',
            'IdAleacion' => 'Id Aleacion',
            'IdPruebaDestructiva' => 'Id Prueba Destructiva',
            'PsiTensileStrength' => 'Psi Tensile Strength',
            'MpaTensileStrengh' => 'Mpa Tensile Strengh',
            'PsiYieldStrength' => 'Psi Yield Strength',
            'MpaYieldStrengh' => 'Mpa Yield Strengh',
            'Elongacin' => 'Elongacin',
            'ReduccionArea' => 'Reduccion Area',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'Colada' => 'Colada',
            'Lance' => 'Lance',
            'Aleacion' => 'Aleacion',
            'IdDureza' => 'Id Dureza',
            'DiametroHuella' => 'Diametro Huella',
            'Dureza' => 'Dureza',
            'HRC' => 'Hrc',
        ];
    }
}
