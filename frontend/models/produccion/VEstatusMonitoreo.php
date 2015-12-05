<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_EstatusMonitoreo".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdEstatuMonitoreo
 * @property integer $IdTipoEstatusUbic
 * @property integer $IdProducto
 * @property integer $IdTipoMonitoreo
 * @property integer $IdAreaAct
 * @property integer $Prioridad
 * @property string $Cliente
 * @property string $Aleacion
 * @property string $CodigoCliente
 * @property string $Producto
 * @property string $AreaActual
 * @property integer $Programadas
 * @property string $Descripcion
 * @property integer $CiclosVarel
 * @property integer $CiclosMolde
 * @property integer $IdAleacion
 * @property integer $Semana
 * @property string $Fecha
 * @property string $Comentarios
 * @property string $EstatusUbicacion
 * @property integer $Tipo
 * @property string $Concepto
 * @property integer $IdArea
 */
class VEstatusMonitoreo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_EstatusMonitoreo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdArea'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdEstatuMonitoreo', 'IdTipoEstatusUbic', 'IdProducto', 'IdTipoMonitoreo', 'IdAreaAct', 'Prioridad', 'Programadas', 'CiclosVarel', 'CiclosMolde', 'IdAleacion', 'Semana', 'Tipo', 'IdArea'], 'integer'],
            [['Cliente', 'Aleacion', 'CodigoCliente', 'Producto', 'AreaActual', 'Descripcion', 'Comentarios', 'EstatusUbicacion', 'Concepto'], 'string'],
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
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdEstatuMonitoreo' => 'Id Estatu Monitoreo',
            'IdTipoEstatusUbic' => 'Id Tipo Estatus Ubic',
            'IdProducto' => 'Id Producto',
            'IdTipoMonitoreo' => 'Id Tipo Monitoreo',
            'IdAreaAct' => 'Id Area Act',
            'Prioridad' => 'Prioridad',
            'Cliente' => 'Cliente',
            'Aleacion' => 'Aleacion',
            'CodigoCliente' => 'Codigo Cliente',
            'Producto' => 'Producto',
            'AreaActual' => 'Area Actual',
            'Programadas' => 'Programadas',
            'Descripcion' => 'Descripcion',
            'CiclosVarel' => 'Ciclos Varel',
            'CiclosMolde' => 'Ciclos Molde',
            'IdAleacion' => 'Id Aleacion',
            'Semana' => 'Semana',
            'Fecha' => 'Fecha',
            'Comentarios' => 'Comentarios',
            'EstatusUbicacion' => 'Estatus Ubicacion',
            'Tipo' => 'Tipo',
            'Concepto' => 'Concepto',
            'IdArea' => 'Id Area',
        ];
    }
}
