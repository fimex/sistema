<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "V_ProductosProgramadosTT".
 *
 * @property integer $IdProgramacion
 * @property string $Identificacion
 * @property string $Descripcion
 * @property string $Fecha
 */
class VProductosProgramadosTT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_ProductosProgramadosTT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'Fecha'], 'required'],
            [['IdProgramacion'], 'integer'],
            [['Identificacion', 'Descripcion'], 'string'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'Identificacion' => 'Identificacion',
            'Descripcion' => 'Descripcion',
            'Fecha' => 'Fecha',
        ];
    }
}
