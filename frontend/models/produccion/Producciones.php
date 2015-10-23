<?php

namespace frontend\models\produccion;

use Yii;
use common\models\catalogos\Lances;
use common\models\catalogos\Empleados;
use common\models\catalogos\Maquinas;
use common\models\catalogos\CentrosTrabajo;
use common\models\catalogos\Turnos;
use frontend\models\tt\TratamientosTermicos;

/**
 * This is the model class for table "Producciones".
 *
 * @property integer $IdProduccion
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $IdEmpleado
 * @property integer $IdProduccionEstatus
 * @property string $Fecha
 * @property integer $IdSubProceso
 * @property integer $IdArea
 * @property string $Observaciones
 * @property integer $IdTurno
 *
 * @property AlmasProduccionDetalle[] $almasProduccionDetalles
 * @property Areas $idArea 
 * @property TratamientosTermicos $idTratamientoTermico
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Empleados $idEmpleado
 * @property Maquinas $idMaquina
 * @property Turnos $idTurno
 * @property TratamientosTermicos $tratamientosTermicos    
 * @property ProduccionesEstatus $idProduccionEstatus
 * @property SubProcesos $idSubProceso
 * @property ProduccionesDetalle[] $produccionesDetalles
 * @property Lances[] $lances
 * @property MaterialesVaciado[] $materialesVaciados
 * @property Temperaturas[] $temperaturas
 * @property PruebasDestructivas[] $pruebasDestructivas
 */
class Producciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Producciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdArea'], 'required'],
            [['IdCentroTrabajo', 'IdMaquina', 'IdEmpleado', 'IdProduccionEstatus', 'IdSubProceso', 'IdArea', 'IdTurno'], 'integer'],
            [['Fecha'], 'safe'],
            [['Observaciones'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProduccion' => 'Id Produccion',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'IdEmpleado' => 'Id Empleado',
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Fecha' => 'Fecha',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdArea' => 'Id Area',
            'Observaciones' => 'Observaciones',
            'IdTurno' => 'Dia Noche'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmasProduccionDetalles()
    {
        return $this->hasMany(AlmasProduccionDetalle::className(), ['IdProduccion' => 'IdProduccion'])
            ->with('idProducto')
            ->with('idAlmaTipo');
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
        public function getIdTratamientosTermicos()
    {
        return $this->hasOne(TratamientosTermicos::className(), ['IdProduccion' => 'IdProduccion'])
            ->with('idAprobo')
            ->with('idOperador')
            ->with('idSuperviso')
            ->with('idTipoEnfriamiento');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTratamientosTermicos()
    {
        return $this->hasMany(TratamientosTermicos::className(), ['IdProduccion' => 'IdProduccion']);
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
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTurno()
    {
        return $this->hasOne(Turnos::className(), ['IdTurno' => 'IdTurno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccionEstatus()
    {
        return $this->hasOne(ProduccionesEstatus::className(), ['IdProduccionEstatus' => 'IdProduccionEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubProceso()
    {
        return $this->hasOne(SubProcesos::className(), ['IdSubProceso' => 'IdSubProceso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdProduccion' => 'IdProduccion'])
            ->with('idProductos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLances()
    {
        return $this->hasOne(Lances::className(), ['IdProduccion' => 'IdProduccion'])->with('idAleacion');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialesVaciados()
    {
        return $this->hasMany(MaterialesVaciado::className(), ['IdProduccion' => 'IdProduccion'])
            ->with('idMaterial');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemperaturas()
    {
        return $this->hasMany(Temperaturas::className(), ['IdProduccion' => 'IdProduccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPruebasDestructivas()
    {
        return $this->hasMany(PruebasDestructivas::className(), ['IdProduccion' => 'IdProduccion']);
    }
    
    public function actualizaProduccion($data)
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("EXECUTE p_ActualizaTotalesSemana ".$data['IdProgramacionSemana'])->execute();
        $result =$command->createCommand("EXECUTE p_ActualizaTotalesPedido ".$data['IdProgramacion'])->execute();
    }
}
