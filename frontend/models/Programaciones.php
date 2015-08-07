<?php

namespace app\models;

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
 * @property integer $Hechas
 * @property integer $Cantidad
 * @property integer $Llenadas
 * @property integer $Cerradas
 * @property integer $Vaciadas
 * @property string $FechaCerrado
 * @property string $HoraCerrado
 * @property string $CerradoPor
 * @property string $CerradoPC
 *
 * @property Areas $idArea
 * @property Empleados $idEmpleado
 * @property Pedidos $idPedido
 * @property Productos $idProducto
 * @property ProgramacionesEstatus $idProgramacionEstatus
 * @property ProduccionesDetalle[] $produccionesDetalles
 * @property ProgramacionesAlma[] $programacionesAlmas
 * @property ProgramacionesSemana[] $programacionesSemanas
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
            [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Hechas', 'Cantidad', 'Llenadas', 'Cerradas', 'Vaciadas'], 'integer'],
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
            'Hechas' => 'Hechas',
            'Cantidad' => 'Cantidad',
            'Llenadas' => 'Llenadas',
            'Cerradas' => 'Cerradas',
            'Vaciadas' => 'Vaciadas',
            'FechaCerrado' => 'Fecha Cerrado',
            'HoraCerrado' => 'Hora Cerrado',
            'CerradoPor' => 'Cerrado Por',
            'CerradoPC' => 'Cerrado Pc',
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
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesSemanas()
    {
        return $this->hasMany(ProgramacionesSemana::className(), ['IdProgramacion' => 'IdProgramacion']);
    }
}
