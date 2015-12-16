<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "Existencias".
 *
 * @property integer $IdExistencias
 * @property integer $IdSubProceso
 * @property integer $IdCentroTrabajo
 * @property string $FechaMoldeo
 * @property integer $IdProducto
 * @property integer $Cantidad
 */
class Existencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSubProceso', 'IdCentroTrabajo', 'IdProducto'], 'required'],
            [['IdSubProceso', 'IdCentroTrabajo', 'IdProducto', 'Cantidad'], 'integer'],
            [['FechaMoldeo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdExistencias' => 'Id Existencias',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdProducto' => 'Id Producto',
            'Cantidad' => 'Cantidad',
        ];
    }
}
