<?php

namespace frontend\models\inventario;

use Yii;

/**
 * This is the model class for table "InventarioMovimientos".
 *
 * @property integer $IdInventarioMovimiento
 * @property integer $IdInventario
 * @property integer $IdCentroTrabajo
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Exixtencia
 *
 * @property Inventarios $idInventario
 * @property CentrosTrabajo $idCentroTrabajo
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
            [['IdInventario', 'IdCentroTrabajo', 'Tipo'], 'required'],
            [['IdInventario', 'IdCentroTrabajo', 'Cantidad', 'Exixtencia'], 'integer'],
            [['Tipo'], 'string']
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
            'Tipo' => 'Tipo',
            'Cantidad' => 'Cantidad',
            'Exixtencia' => 'Exixtencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInventario()
    {
        return $this->hasOne(Inventarios::className(), ['IdInventarios' => 'IdInventario']);
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
    public function getSeriesMovimientos()
    {
        return $this->hasMany(SeriesMovimientos::className(), ['IdPartran' => 'IdInventarioMovimiento']);
    }
}
