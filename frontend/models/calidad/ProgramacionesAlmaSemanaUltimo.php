<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "ProgramacionesAlmaSemana".
 *
 * @property integer $IdProgramacionAlmaSemana
 * @property integer $IdProgramacionAlma
 * @property integer $Anio
 * @property integer $Semana
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $Hechas
 *
 * @property ProgramacionesAlmaDia[] $programacionesAlmaDias
 * @property ProgramacionesAlma $idProgramacionAlma
 */
class ProgramacionesAlmaSemanaUltimo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProgramacionesAlmaSemana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacionAlma', 'Anio', 'Semana', 'Programadas'], 'required'],
            [['IdProgramacionAlma', 'Anio', 'Semana', 'Prioridad', 'Programadas', 'Hechas'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionAlmaSemana' => 'Id Programacion Alma Semana',
            'IdProgramacionAlma' => 'Id Programacion Alma',
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
    public function getProgramacionesAlmaDias()
    {
        return $this->hasMany(ProgramacionesAlmaDia::className(), ['IdProgramacionAlmaSemana' => 'IdProgramacionAlmaSemana']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProgramacionAlma()
    {
        return $this->hasOne(ProgramacionesAlma::className(), ['IdProgramacionAlma' => 'IdProgramacionAlma']);
    }
}
