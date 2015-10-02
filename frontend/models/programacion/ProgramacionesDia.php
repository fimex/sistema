<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "ProgramacionesDia".
 *
 * @property integer $IdProgramacionDia
 * @property integer $IdProgramacionSemana
 * @property string $Dia
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 * @property integer $IdAreaProceso
 * @property integer $IdTurno
 * @property integer $IdCentroTrabajo
 * @property integer $IdMaquina
 * @property integer $Llenadas
 * @property integer $Cerradas
 * @property integer $Vaciadas
 *
 * @property AreaProcesos $idAreaProceso
 * @property CentrosTrabajo $idCentroTrabajo
 * @property Maquinas $idMaquina
 * @property ProgramacionesSemana $idProgramacionSemana
 * @property Turnos $idTurno
 */
class ProgramacionesDia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProgramacionesDia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacionSemana', 'Dia', 'Programadas', 'IdTurno', 'IdCentroTrabajo', 'IdMaquina'], 'required'],
            [['IdProgramacionSemana', 'Prioridad', 'Programadas', 'Hechas', 'IdAreaProceso', 'IdTurno', 'IdCentroTrabajo', 'IdMaquina', 'Llenadas', 'Cerradas', 'Vaciadas'], 'integer'],
            [['Dia'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionDia' => 'Id Programacion Dia',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'Dia' => 'Dia',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
            'IdAreaProceso' => 'Id Area Proceso',
            'IdTurno' => 'Id Turno',
            'IdCentroTrabajo' => 'Id Centro Trabajo',
            'IdMaquina' => 'Id Maquina',
            'Llenadas' => 'Llenadas',
            'Cerradas' => 'Cerradas',
            'Vaciadas' => 'Vaciadas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaProceso()
    {
        return $this->hasOne(AreaProcesos::className(), ['IdAreaProceso' => 'IdAreaProceso']);
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
    public function getIdMaquina()
    {
        return $this->hasOne(Maquinas::className(), ['IdMaquina' => 'IdMaquina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionSemana()
    {
        return $this->hasOne(ProgramacionesSemana::className(), ['IdProgramacionSemana' => 'IdProgramacionSemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTurno()
    {
        return $this->hasOne(Turnos::className(), ['IdTurno' => 'IdTurno']);
    }
    public function incrementa($IdProgramacionDia){
        $command = \Yii::$app->db;
        echo "UPDATE ProgramacionesDia SET Cerradas = Cerradas + 1 WHERE IdProgramacionDia = '$IdProgramacionDia' ";
        $result = $command->createCommand("UPDATE ProgramacionesDia SET Cerradas = Cerradas + 1 WHERE IdProgramacionDia = '$IdProgramacionDia' ")->execute();
    }
}
