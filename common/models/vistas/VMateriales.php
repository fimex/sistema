<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_materiales".
 *
 * @property integer $IdMaterialVaciado
 * @property integer $IdProduccion
 * @property integer $IdMaterial
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdProceso
 * @property double $Cantidad
 */
class VMateriales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_materiales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMaterialVaciado', 'IdProduccion', 'IdMaterial', 'IdProceso'], 'integer'],
            [['IdMaterial', 'Identificador', 'Descripcion', 'IdProceso'], 'required'],
            [['Identificador', 'Descripcion'], 'string'],
            [['Cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterialVaciado' => 'Id Material Vaciado',
            'IdProduccion' => 'Id Produccion',
            'IdMaterial' => 'Id Material',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdProceso' => 'Id Proceso',
            'Cantidad' => 'Cantidad',
        ];
    }
}
