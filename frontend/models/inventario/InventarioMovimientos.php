<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "InventarioMovimientos".
 *
 * @property integer $IdInventarioMovimiento
 * @property integer $IdInventario
 * @property integer $IdCentroTrabajo
 * @property integer $IdProducto
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Existencia
 * @property string $Observaciones
 *
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Inventarios $idInventario
 * @property SeriesMovimientos[] $seriesMovimientos
 */
class InventarioMovimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'InventarioMovimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdInventario', 'IdCentroTrabajo', 'IdProducto', 'Tipo'], 'required'],
            [['IdInventario', 'IdCentroTrabajo', 'IdProducto', 'Cantidad', 'Existencia'], 'integer'],
            [['Tipo', 'Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInventarioMovimiento' => 'Id Inventario Movimiento',
            'IdInventario' => 'Id Inventario',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdProducto' => 'Id Producto',
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'Existencia' => 'Existencia',
            'Observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCentroTrabajo()
    {
        return $this->hasOne(CentrosTrabajo::className(), ['IdCentroTrabajo' => 'IdCentroTrabajo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInventario()
    {
        return $this->hasOne(Inventarios::className(), ['IdInventario' => 'IdInventario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeriesMovimientos()
    {
        return $this->hasMany(SeriesMovimientos::className(), ['IdPartran' => 'IdInventarioMovimiento']);
    }
}
