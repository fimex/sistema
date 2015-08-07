<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "Turnos".
 *
 * @property integer $IdTurno
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Usuarios[] $usuarios
 * @property ProgramacionesDia[] $programacionesDias
 */
class Turnos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Turnos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTurno' => 'Id Turno',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Dia Noche',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['IdTurno' => 'IdTurno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesDias()
    {
        return $this->hasMany(ProgramacionesDia::className(), ['IdTurno' => 'IdTurno']);
    }
}
