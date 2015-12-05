<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_CiclosEdit".
 *
 * @property integer $IdProduccion
 * @property string $Fecha
 * @property integer $IdArea
 * @property integer $IdSubProceso
 * @property integer $IdAreaAct
 * @property integer $IdProduccionDetalle
 * @property integer $IdProduccionCiclos
 * @property string $estatus
 * @property string $tipo
 * @property integer $Linea
 * @property integer $IdProductos
 * @property string $Identificacion
 */
class VCiclosEdit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CiclosEdit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'Fecha', 'IdArea', 'IdSubProceso', 'IdAreaAct', 'IdProduccionDetalle', 'IdProduccionCiclos', 'IdProductos'], 'required'],
            [['IdProduccion', 'IdArea', 'IdSubProceso', 'IdAreaAct', 'IdProduccionDetalle', 'IdProduccionCiclos', 'Linea', 'IdProductos'], 'integer'],
            [['Fecha'], 'safe'],
            [['estatus', 'tipo', 'Identificacion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'Fecha' => 'Fecha',
            'IdArea' => 'Id Area',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdAreaAct' => 'Id Area Act',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'IdProduccionCiclos' => 'Id Produccion Ciclos',
            'estatus' => 'Estatus',
            'tipo' => 'Tipo',
            'Linea' => 'Linea',
            'IdProductos' => 'Id Productos',
            'Identificacion' => 'Identificacion',
        ];
    }
}
