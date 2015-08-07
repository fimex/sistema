<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "ProgramacionesSemana".
 *
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacion
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 *
 * @property Programaciones $idProgramacion
 * @property ProgramacionesDia[] $programacionesDias
 */
class ProgramacionesSemana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProgramacionesSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'Anio', 'Semana'], 'required'],
            [['IdProgramacion', 'Anio', 'Semana', 'Prioridad', 'Programadas', 'Hechas'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdProgramacion' => 'Id Programacion',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'Hechas' => 'Hechas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacion()
    {
        return $this->hasOne(Programaciones::className(), ['IdProgramacion' => 'IdProgramacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdProgramacionSemana' => 'IdProgramacionSemana']);
    }
}
