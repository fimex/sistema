<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionSemanaAcero".
 *
 * @property integer $IdProgramacion
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Pedido
 * @property integer $pedido_hecho
 * @property integer $programadas_semana
 * @property integer $hechas_semana
 * @property integer $prioridad_semana
 * @property integer $IdPedido
 * @property integer $IdAlmacen
 * @property integer $IdProducto
 * @property integer $Codigo
 * @property integer $Numero
 * @property string $Producto
 * @property string $Almacen
 * @property string $Fecha
 * @property string $Cliente
 * @property string $OrdenCompra
 * @property integer $Estatus
 * @property string $Cantidad
 * @property string $SaldoCantidad
 * @property string $FechaEmbarque
 * @property integer $NivelRiesgo
 * @property string $TotalProgramado
 * @property string $Observaciones
 * @property integer $PiezasMolde
 * @property string $CiclosMolde
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $IdPresentacion
 * @property integer $IdProductoCasting
 * @property string $ProductoCasting
 * @property integer $IdParteMolde
 * @property string $LlevaSerie
 * @property integer $FechaMoldeo
 * @property integer $IdAreaAct
 * @property string $Aleacion
 * @property integer $IdArea
 */
class VProgramacionSemanaAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionSemanaAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'Anio', 'Semana', 'Pedido', 'hechas_semana', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Fecha', 'Estatus', 'Cantidad', 'SaldoCantidad', 'NivelRiesgo', 'TotalProgramado', 'IdArea'], 'required'],
            [['IdProgramacion', 'Anio', 'Semana', 'Pedido', 'pedido_hecho', 'programadas_semana', 'hechas_semana', 'prioridad_semana', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Estatus', 'NivelRiesgo', 'PiezasMolde', 'IdPresentacion', 'IdProductoCasting', 'IdParteMolde', 'FechaMoldeo', 'IdAreaAct', 'IdArea'], 'integer'],
            [['Producto', 'Almacen', 'Cliente', 'OrdenCompra', 'Observaciones', 'ProductoCasting', 'LlevaSerie', 'Aleacion'], 'string'],
            [['Fecha', 'FechaEmbarque'], 'safe'],
            [['Cantidad', 'SaldoCantidad', 'TotalProgramado', 'CiclosMolde', 'PesoCasting', 'PesoArania'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Pedido' => 'Pedido',
            'pedido_hecho' => 'Pedido Hecho',
            'programadas_semana' => 'Programadas Semana',
            'hechas_semana' => 'Hechas Semana',
            'prioridad_semana' => 'Prioridad Semana',
            'IdPedido' => 'Id Pedido',
            'IdAlmacen' => 'Id Almacen',
            'IdProducto' => 'Id Producto',
            'Codigo' => 'Codigo',
            'Numero' => 'Numero',
            'Producto' => 'Producto',
            'Almacen' => 'Almacen',
            'Fecha' => 'Fecha',
            'Cliente' => 'Cliente',
            'OrdenCompra' => 'Orden Compra',
            'Estatus' => 'Estatus',
            'Cantidad' => 'Cantidad',
            'SaldoCantidad' => 'Saldo Cantidad',
            'FechaEmbarque' => 'Fecha Embarque',
            'NivelRiesgo' => 'Nivel Riesgo',
            'TotalProgramado' => 'Total Programado',
            'Observaciones' => 'Observaciones',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'IdPresentacion' => 'Id Presentacion',
            'IdProductoCasting' => 'Id Producto Casting',
            'ProductoCasting' => 'Producto Casting',
            'IdParteMolde' => 'Id Parte Molde',
            'LlevaSerie' => 'Lleva Serie',
            'FechaMoldeo' => 'Fecha Moldeo',
            'IdAreaAct' => 'Id Area Act',
            'Aleacion' => 'Aleacion',
            'IdArea' => 'Id Area',
        ];
    }
}
