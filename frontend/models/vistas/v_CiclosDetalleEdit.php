<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_CiclosDetalleEdit".
 *
 * @property string $numeroRegistroConsultado
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
 * @property integer $IdProduccionCiclosDetalle
 * @property integer $IdParteMolde
 * @property string $Identificador
 * @property integer $IdConfiguracionSerie
 * @property string $parteSerie
 * @property string $Serie
 * @property string $FechaHora
 * @property string $LlevaSerie
 */
class v_CiclosDetalleEdit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CiclosDetalleEdit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroRegistroConsultado', 'IdProduccion', 'IdArea', 'IdSubProceso', 'IdAreaAct', 'IdProduccionDetalle', 'IdProduccionCiclos', 'Linea', 'IdProductos', 'IdProduccionCiclosDetalle', 'IdParteMolde', 'IdConfiguracionSerie'], 'integer'],
            [['IdProduccion', 'Fecha', 'IdArea', 'IdSubProceso', 'IdAreaAct', 'IdProduccionDetalle', 'IdProduccionCiclos', 'IdProductos', 'IdProduccionCiclosDetalle'], 'required'],
            [['Fecha', 'FechaHora'], 'safe'],
            [['estatus', 'tipo', 'Identificacion', 'Identificador', 'parteSerie', 'Serie', 'LlevaSerie'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numeroRegistroConsultado' => 'Numero Registro Consultado',
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
            'IdProduccionCiclosDetalle' => 'Id Produccion Ciclos Detalle',
            'IdParteMolde' => 'Id Parte Molde',
            'Identificador' => 'Identificador',
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
            'parteSerie' => 'Parte Serie',
            'Serie' => 'Serie',
            'FechaHora' => 'Fecha Hora',
            'LlevaSerie' => 'Lleva Serie',
        ];
    }
}
