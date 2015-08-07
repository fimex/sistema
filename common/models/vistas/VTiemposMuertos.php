<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_TiemposMuertos".
 *
 * @property integer $IdTiempoMuerto
 * @property integer $IdMaquina
 * @property string $Identificador
 * @property string $Descripcion
 * @property string $Fecha
 * @property string $Inicio
 * @property string $Fin
 * @property integer $Minutos
 * @property string $Observaciones
 * @property integer $IdCausa
 * @property string $Causa
 * @property integer $IdCausaTipo
 * @property string $ClaveTipo
 * @property string $Tipo
 * @property integer $IdSubProceso
 * @property integer $IdArea
 */
class VTiemposMuertos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_TiemposMuertos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTiempoMuerto', 'IdMaquina', 'Fecha', 'IdCausa', 'Causa', 'IdCausaTipo', 'ClaveTipo', 'Tipo', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdTiempoMuerto', 'IdMaquina', 'Minutos', 'IdCausa', 'IdCausaTipo', 'IdSubProceso', 'IdArea'], 'integer'],
            [['Identificador', 'Descripcion', 'Observaciones', 'Causa', 'ClaveTipo', 'Tipo'], 'string'],
            [['Fecha', 'Inicio', 'Fin'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTiempoMuerto' => 'Id Tiempo Muerto',
            'IdMaquina' => 'Id Maquina',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'Fecha' => 'Fecha',
            'Inicio' => 'Inicio',
            'Fin' => 'Fin',
            'Minutos' => 'Minutos',
            'Observaciones' => 'Observaciones',
            'IdCausa' => 'Id Causa',
            'Causa' => 'Causa',
            'IdCausaTipo' => 'Id Causa Tipo',
            'ClaveTipo' => 'Clave Tipo',
            'Tipo' => 'Tipo',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
        ];
    }
}
