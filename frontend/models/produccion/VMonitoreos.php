<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_Monitoreos".
 *
 * @property integer $IdTipoMonitoreo
 * @property integer $IdProducto
 * @property string $Concepto
 * @property integer $Tipo
 * @property integer $IdTipoEstatusUbic
 * @property string $Descripcion
 * @property integer $IdProgramacionSemana
 * @property string $Fecha
 * @property string $Comentarios
 * @property integer $IdEstatuMonitoreo
 */
class VMonitoreos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Monitoreos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTipoMonitoreo', 'IdTipoEstatusUbic', 'Fecha', 'IdEstatuMonitoreo'], 'required'],
            [['IdTipoMonitoreo', 'IdProducto', 'Tipo', 'IdTipoEstatusUbic', 'IdProgramacionSemana', 'IdEstatuMonitoreo'], 'integer'],
            [['Concepto', 'Descripcion', 'Comentarios'], 'string'],
            [['Fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoMonitoreo' => 'Id Tipo Monitoreo',
            'IdProducto' => 'Id Producto',
            'Concepto' => 'Concepto',
            'Tipo' => 'Tipo',
            'IdTipoEstatusUbic' => 'Id Tipo Estatus Ubic',
            'Descripcion' => 'Descripcion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'Fecha' => 'Fecha',
            'Comentarios' => 'Comentarios',
            'IdEstatuMonitoreo' => 'Id Estatu Monitoreo',
        ];
    }
}
