<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Areas".
 *
 * @property integer $IdArea
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Programaciones[] $programaciones
 * @property Procesos[] $procesos
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdArea', 'Identificador', 'Descripcion'], 'required'],
            [['IdArea'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdArea' => 'Id Area',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descricion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdArea' => 'IdArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesos()
    {
        return $this->hasMany(Procesos::className(), ['IdArea' => 'IdArea']);
    }
}
