<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionesCiclos".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacionDia
 * @property integer $IdArea
 * @property integer $IdAreaAct
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $PiezasMolde
 * @property integer $CiclosMolde
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property double $MoldesMoldeo
 * @property double $MoldesOK
 * @property double $MoldesREP
 * @property double $MoldesREC
 */
class VProgramacionesCiclos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionesCiclos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdArea', 'Anio', 'Semana', 'Dia', 'PiezasMolde', 'CiclosMolde', 'PesoCasting', 'PesoArania', 'Prioridad', 'Programadas'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdArea', 'IdAreaAct', 'Anio', 'Semana', 'PiezasMolde', 'CiclosMolde', 'Prioridad', 'Programadas'], 'integer'],
            [['Dia'], 'safe'],
            [['PesoCasting', 'PesoArania', 'MoldesMoldeo', 'MoldesOK', 'MoldesREP', 'MoldesREC'], 'number']
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
            'IdArea' => 'Id Area',
            'IdAreaAct' => 'Id Area Act',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'MoldesMoldeo' => 'Moldes Moldeo',
            'MoldesOK' => 'Moldes Ok',
            'MoldesREP' => 'Moldes Rep',
            'MoldesREC' => 'Moldes Rec',
        ];
    }
}
