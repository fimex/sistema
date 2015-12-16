<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "Inventarios".
 *
 * @property integer $IdInventario
 * @property string $Fecha
 * @property integer $IdEmpleado
 * @property integer $IdEstatusInventario
 * @property integer $IdSubProceso
 *
 * @property InventarioMovimientos[] $inventarioMovimientos
 */
class Inventarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Inventarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Fecha', 'IdEmpleado', 'IdSubProceso'], 'required'],
            [['Fecha'], 'safe'],
            [['IdEmpleado', 'IdEstatusInventario', 'IdSubProceso'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventario' => 'Id Inventario',
            'Fecha' => 'Fecha',
            'IdEmpleado' => 'Id Empleado',
            'IdEstatusInventario' => 'Id Estatus Inventario',
            'IdSubProceso' => 'Id Sub Proceso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarioMovimientos()
    {
        return $this->hasMany(InventarioMovimientos::className(), ['IdInventario' => 'IdInventario']);
    }
}
