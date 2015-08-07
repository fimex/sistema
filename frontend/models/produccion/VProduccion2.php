<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_Produccion2".
 *
 * @property integer $IdPedido
 * @property string $Producto
 * @property integer $Codigo
 * @property integer $Numero
 * @property string $Fecha
 * @property string $Cliente
 * @property string $OrdenCompra
 * @property integer $Estatus
 * @property string $Cantidad
 * @property string $SaldoCantidad
 * @property string $FechaEmbarque
 * @property integer $NivelRiesgo
 * @property string $Observaciones
 * @property string $TotalProgramado
 * @property string $Identificador
 * @property string $Descripcion
 * @property string $Identificacion
 * @property string $ProductoCasting
 * @property string $Marca
 * @property string $Presentacion
 * @property integer $IdPresentacion
 * @property integer $IdProgramacion
 * @property integer $Hechas
 * @property integer $Rechazadas
 */
class VProduccion2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Produccion2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'Codigo', 'Numero', 'Fecha', 'Estatus', 'Cantidad', 'SaldoCantidad', 'NivelRiesgo', 'TotalProgramado', 'Marca', 'IdPresentacion', 'IdProgramacion'], 'required'],
            [['IdPedido', 'Codigo', 'Numero', 'Estatus', 'NivelRiesgo', 'IdPresentacion', 'IdProgramacion', 'Hechas', 'Rechazadas'], 'integer'],
            [['Producto', 'Cliente', 'OrdenCompra', 'Observaciones', 'Identificador', 'Descripcion', 'Identificacion', 'ProductoCasting', 'Marca', 'Presentacion'], 'string'],
            [['Fecha', 'FechaEmbarque'], 'safe'],
            [['Cantidad', 'SaldoCantidad', 'TotalProgramado'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPedido' => 'Id Pedido',
            'Producto' => 'Producto',
            'Codigo' => 'Codigo',
            'Numero' => 'Numero',
            'Fecha' => 'Fecha',
            'Cliente' => 'Cliente',
            'OrdenCompra' => 'Orden Compra',
            'Estatus' => 'Estatus',
            'Cantidad' => 'Cantidad',
            'SaldoCantidad' => 'Saldo Cantidad',
            'FechaEmbarque' => 'Fecha Embarque',
            'NivelRiesgo' => 'Nivel Riesgo',
            'Observaciones' => 'Observaciones',
            'TotalProgramado' => 'Total Programado',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'Identificacion' => 'Identificacion',
            'ProductoCasting' => 'Producto Casting',
            'Marca' => 'Marca',
            'Presentacion' => 'Presentacion',
            'IdPresentacion' => 'Id Presentacion',
            'IdProgramacion' => 'Id Programacion',
            'Hechas' => 'Hechas',
            'Rechazadas' => 'Rechazadas',
        ];
    }
}
