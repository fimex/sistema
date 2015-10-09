<?php

namespace frontend\models\tt;

use Yii;
use common\models\catalogos\Empleados;
use frontend\models\tt\TTTipoEnfriamientos;

/**
 * This is the model class for table "TratamientosTermicos".
 *
 * @property integer $IdTratamientoTermico
 * @property integer $IdProduccion
 * @property integer $NoTT
 * @property string $HoraInicio
 * @property string $HoraFin
 * @property integer $NoGraficaTT
 * @property integer $KWIni
 * @property integer $KWFin
 * @property integer $Temp1
 * @property integer $Temp2
 * @property integer $TempEntradaDeposito
 * @property integer $TempSalidaDeposito
 * @property integer $TempPzDepositoIn
 * @property integer $TempPzDeposioOut
 * @property integer $IdTipoEnfriamiento
 * @property integer $TimepoEnfriamiento
 * @property integer $TotalKG
 * @property integer $Ecofuel
 * @property string $ArchivoGrafica
 * @property integer $idOperador
 * @property integer $idAprobo
 * @property integer $idSuperviso
 *
 * @property Producciones $idProduccion
 * @property Empleados $idAprobo
 * @property Empleados $idOperador
 * @property Empleados $idSuperviso
 * @property TTTipoEnfriamientos $idTipoEnfriamiento
 */
class TratamientosTermicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TratamientosTermicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion'], 'required'],
            [['IdProduccion', 'NoTT', 'NoGraficaTT', 'KWIni', 'KWFin', 'Temp1', 'Temp2', 'TempEntradaDeposito', 'TempSalidaDeposito', 'TempPzDepositoIn', 'TempPzDeposioOut', 'IdTipoEnfriamiento', 'TimepoEnfriamiento', 'TotalKG', 'Ecofuel', 'idOperador', 'idAprobo', 'idSuperviso'], 'integer'],
            [['HoraInicio', 'HoraFin'], 'safe'],
            [['ArchivoGrafica'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTratamientoTermico' => 'Id Tratamiento Termico',
            'IdProduccion' => 'Id Produccion',
            'NoTT' => 'No Tt',
            'HoraInicio' => 'Hora Inicio',
            'HoraFin' => 'Hora Fin',
            'NoGraficaTT' => 'No Grafica Tt',
            'KWIni' => 'Kwini',
            'KWFin' => 'Kwfin',
            'Temp1' => 'Temp1',
            'Temp2' => 'Temp2',
            'TempEntradaDeposito' => 'Temp Entrada Deposito',
            'TempSalidaDeposito' => 'Temp Salida Deposito',
            'TempPzDepositoIn' => 'Temp Pz Deposito In',
            'TempPzDeposioOut' => 'Temp Pz Deposio Out',
            'IdTipoEnfriamiento' => 'Id Tipo Enfriamiento',
            'TimepoEnfriamiento' => 'Timepo Enfriamiento',
            'TotalKG' => 'Total Kg',
            'Ecofuel' => 'Ecofuel',
            'ArchivoGrafica' => 'Archivo Grafica',
            'idOperador' => 'Id Operador',
            'idAprobo' => 'Id Aprobo',
            'idSuperviso' => 'Id Superviso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAprobo()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'idAprobo']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOperador()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'idOperador']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSuperviso()
    {
        return $this->hasOne(Empleados::className(), ['IdEmpleado' => 'idSuperviso']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEnfriamiento()
    {
        return $this->hasOne(TTTipoEnfriamientos::className(), ['IdTipoEnfriamiento' => 'IdTipoEnfriamiento']);
    }
	
	
}
