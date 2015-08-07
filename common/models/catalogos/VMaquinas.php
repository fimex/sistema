<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "v_maquinas".
 *
 * @property integer $IdCentroTrabajo
 * @property integer $IdArea
 * @property integer $IdSubProceso
 * @property integer $IdMaquina
 * @property string $Identificador
 * @property string $CentroTrabajo
 * @property string $Maquina
 * @property integer $Consecutivo
 */
class VMaquinas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_maquinas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCentroTrabajo', 'IdSubProceso', 'IdMaquina', 'Maquina', 'Consecutivo'], 'required'],
            [['IdCentroTrabajo', 'IdArea', 'IdSubProceso', 'IdMaquina', 'Consecutivo'], 'integer'],
            [['Identificador', 'CentroTrabajo', 'Maquina'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdArea' => 'Id Area',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdMaquina' => 'Id Maquina',
            'Identificador' => 'Identificador',
            'CentroTrabajo' => 'Centro Trabajo',
            'Maquina' => 'Maquina',
            'Consecutivo' => 'Consecutivo',
        ];
    }
}
