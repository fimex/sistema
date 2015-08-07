<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "ProgramacionesEstatus".
 *
 * @property integer $IdProgramacionEstatus
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Programaciones[] $programaciones
 * @property ProgramacionesAlma[] $programacionesAlmas
 */
class ProgramacionesEstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProgramacionesEstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'required'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacionEstatus' => 'Id Programacion Estatus',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdProgramacionEstatus' => 'IdProgramacionEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdProgramacionEstatus' => 'IdProgramacionEstatus']);
    }
}
