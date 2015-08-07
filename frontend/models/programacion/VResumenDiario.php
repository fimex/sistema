<?php

namespace frontend\models\programacion;

use Yii;

/**
 * This is the model class for table "v_ResumenDiario".
 *
 * @property integer $IdArea
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $PrgMol
 * @property integer $PrgPzas
 * @property string $PrgTonP
 * @property string $PrgTon
 * @property double $PrgHrs
 * @property integer $HecMol
 * @property integer $HecPzas
 * @property string $HecTonP
 * @property string $HecTon
 * @property double $HecHrs
 */
class VResumenDiario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ResumenDiario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Anio', 'Semana', 'Dia'], 'required'],
            [['IdArea', 'Anio', 'Semana', 'PrgMol', 'PrgPzas', 'HecMol', 'HecPzas'], 'integer'],
            [['Dia'], 'safe'],
            [['PrgTonP', 'PrgTon', 'PrgHrs', 'HecTonP', 'HecTon', 'HecHrs'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'PrgMol' => 'Prg Mol',
            'PrgPzas' => 'Prg Pzas',
            'PrgTonP' => 'Prg Ton P',
            'PrgTon' => 'Prg Ton',
            'PrgHrs' => 'Prg Hrs',
            'HecMol' => 'Hec Mol',
            'HecPzas' => 'Hec Pzas',
            'HecTonP' => 'Hec Ton P',
            'HecTon' => 'Hec Ton',
            'HecHrs' => 'Hec Hrs',
        ];
    }
}
