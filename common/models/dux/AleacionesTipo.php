<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "AleacionesTipo".
 *
 * @property integer $IdAleacionTipo
 * @property string $Identificador
 * @property string $Descripcion
 * @property string $Factor
 * @property string $DUX_Codigo
 * @property string $DUX_CuentaContable
 *
 * @property AleacionesTipoFactor[] $aleacionesTipoFactors
 * @property Aleaciones[] $aleaciones
 */
class AleacionesTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AleacionesTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion', 'Factor', 'DUX_Codigo', 'DUX_CuentaContable'], 'required'],
            [['Identificador', 'Descripcion', 'DUX_Codigo', 'DUX_CuentaContable'], 'string'],
            [['Factor'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAleacionTipo' => 'Id Aleacion Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'Factor' => 'Factor',
            'DUX_Codigo' => 'Dux  Codigo',
            'DUX_CuentaContable' => 'Dux  Cuenta Contable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAleacionesTipoFactors()
    {
        return $this->hasMany(AleacionesTipoFactor::className(), ['IdAleacionTipo' => 'IdAleacionTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAleaciones()
    {
        return $this->hasMany(Aleaciones::className(), ['IdAleacionTipo' => 'IdAleacionTipo']);
    }
}
