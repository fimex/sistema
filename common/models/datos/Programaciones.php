<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Programaciones".
 *
 * @property integer $IdProgramacion
 * @property integer $IdPedido
 * @property integer $IdArea
 * @property integer $IdEmpleado
 * @property integer $IdProgramacionEstatus
 * @property integer $IdProducto
 * @property integer $Programadas
 * @property integer $Cantidad
 * @property integer $Hechas
 * @property integer $Llenadas
 * @property integer $Cerradas
 * @property integer $Vaciadas
 * @property string $FechaCerrado
 * @property string $HoraCerrado
 * @property string $CerradoPor
 * @property string $CerradoPC
 * @property string $Agrupado
 *
 * @property Areas $idArea
 * @property Empleados $idEmpleado
 * @property Pedidos $idPedido
 * @property Productos $idProducto
 * @property ProgramacionesEstatus $idProgramacionEstatus
 * @property ProduccionesDetalle[] $produccionesDetalles
 * @property PedProg[] $pedProgs
 * @property ProgramacionesSemana[] $programacionesSemanas
 * @property ProgramacionesAlma[] $programacionesAlmas
 */
class Programaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Programaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas'], 'required'],
            [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Cantidad', 'Hechas', 'Llenadas', 'Cerradas', 'Vaciadas', 'Agrupado'], 'integer'],
            [['FechaCerrado', 'HoraCerrado'], 'safe'],
            [['CerradoPor', 'CerradoPC'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdPedido' => 'Id Pedido',
            'IdArea' => 'Id Area',
            'IdEmpleado' => 'Id Empleado',
            'IdProgramacionEstatus' => 'Id Programacion Estatus',
            'IdProducto' => 'Id Producto',
            'Programadas' => 'Programadas',
            'Cantidad' => 'Cantidad',
            'Hechas' => 'Hechas',
            'Llenadas' => 'Llenadas',
            'Cerradas' => 'Cerradas',
            'Vaciadas' => 'Vaciadas',
            'FechaCerrado' => 'Fecha Cerrado',
            'HoraCerrado' => 'Hora Cerrado',
            'CerradoPor' => 'Cerrado Por',
            'CerradoPC' => 'Cerrado Pc',
            'Agrupado' => 'Agrupado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Areas::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedido()
    {
        return $this->hasOne(Pedidos::className(), ['IdPedido' => 'IdPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionEstatus()
    {
        return $this->hasOne(ProgramacionesEstatus::className(), ['IdProgramacionEstatus' => 'IdProgramacionEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedProgs()
    {
        return $this->hasMany(PedProg::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesSemanas()
    {
        return $this->hasMany(ProgramacionesSemana::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdProgramacion' => 'IdProgramacion']);
    }
}
