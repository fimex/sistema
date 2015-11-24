<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_ExistenciasCalidad".
 *
 * @property integer $IdCentroTrabajo
 * @property integer $Cantidad
 * @property integer $Id
 * @property integer $IdProducto
 * @property integer $IdSubProceso
 * @property integer $IdProgramacionEstatus
 * @property integer $IdProgramacion
 * @property integer $IdArea
 * @property integer $IdCentroTrabajoDestino
 * @property string $LlevaSerie
 * @property string $Descripcion
 * @property string $Identificacion
 * @property integer $FechaMoldeo
 */
class VExistenciasCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ExistenciasCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCentroTrabajo', 'Cantidad', 'Id', 'IdProducto', 'IdSubProceso', 'IdProgramacionEstatus', 'IdProgramacion', 'IdArea'], 'required'],
            [['IdCentroTrabajo', 'Cantidad', 'Id', 'IdProducto', 'IdSubProceso', 'IdProgramacionEstatus', 'IdProgramacion', 'IdArea', 'IdCentroTrabajoDestino', 'FechaMoldeo'], 'integer'],
            [['LlevaSerie', 'Descripcion', 'Identificacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'Cantidad' => 'Cantidad',
            'Id' => 'ID',
            'IdProducto' => 'Id Producto',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProgramacionEstatus' => 'Id Programacion Estatus',
            'IdProgramacion' => 'Id Programacion',
            'IdArea' => 'Id Area',
            'IdCentroTrabajoDestino' => 'Id Centro Trabajo Destino',
            'LlevaSerie' => 'Lleva Serie',
            'Descripcion' => 'Descripcion',
            'Identificacion' => 'Identificacion',
            'FechaMoldeo' => 'Fecha Moldeo',
        ];
    }
}
