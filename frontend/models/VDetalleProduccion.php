<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_DetalleProduccion".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacionDia
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $Pedido
 * @property integer $pedido_hecho
 * @property integer $programadas_semana
 * @property integer $hechas_semana
 * @property integer $prioridad_semana
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $IdAreaProceso
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
 * @property integer $CiclosMolde
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $IdTurno
 * @property string $Turno
 * @property integer $IdPresentacion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdArea
 * @property integer $IdProceso
 * @property integer $IdSubProceso
 * @property integer $IdProductoCasting
 * @property string $ProductoCasting
 * @property string $Aleacion
 * @property integer $Llenadas
 * @property integer $Cerradas
 * @property integer $Vaciadas
 */
class VDetalleProduccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_DetalleProduccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'Anio', 'Semana', 'Dia', 'Pedido', 'programadas_semana', 'hechas_semana', 'prioridad_semana', 'Prioridad', 'Programadas', 'Hechas', 'IdAreaProceso', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Fecha', 'Estatus', 'Cantidad', 'SaldoCantidad', 'NivelRiesgo', 'TotalProgramado', 'PiezasMolde', 'CiclosMolde', 'PesoCasting', 'PesoArania', 'IdTurno', 'IdPresentacion', 'IdCentroTrabajo', 'IdMaquina', 'IdArea', 'IdProceso', 'IdSubProceso'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'Anio', 'Semana', 'Pedido', 'pedido_hecho', 'programadas_semana', 'hechas_semana', 'prioridad_semana', 'Prioridad', 'Programadas', 'Hechas', 'IdAreaProceso', 'IdPedido', 'IdAlmacen', 'IdProducto', 'Codigo', 'Numero', 'Estatus', 'NivelRiesgo', 'PiezasMolde', 'CiclosMolde', 'IdTurno', 'IdPresentacion', 'IdCentroTrabajo', 'IdMaquina', 'IdArea', 'IdProceso', 'IdSubProceso', 'IdProductoCasting', 'Llenadas', 'Cerradas', 'Vaciadas'], 'integer'],
            [['Dia', 'Fecha', 'FechaEmbarque'], 'safe'],
            [['Producto', 'Almacen', 'Cliente', 'OrdenCompra', 'Observaciones', 'Turno', 'ProductoCasting', 'Aleacion'], 'string'],
            [['Cantidad', 'SaldoCantidad', 'TotalProgramado', 'PesoCasting', 'PesoArania'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'Pedido' => 'Pedido',
            'pedido_hecho' => 'Pedido Hecho',
            'programadas_semana' => 'Programadas Semana',
            'hechas_semana' => 'Hechas Semana',
            'prioridad_semana' => 'Prioridad Semana',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'IdAreaProceso' => 'Id Area Proceso',
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
            'IdTurno' => 'Id Turno',
            'Turno' => 'Turno',
            'IdPresentacion' => 'Id Presentacion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdArea' => 'Id Area',
            'IdProceso' => 'Id Proceso',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProductoCasting' => 'Id Producto Casting',
            'ProductoCasting' => 'Producto Casting',
            'Aleacion' => 'Aleacion',
            'Llenadas' => 'Llenadas',
            'Cerradas' => 'Cerradas',
            'Vaciadas' => 'Vaciadas',
        ];
    }
}
