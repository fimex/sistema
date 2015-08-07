<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "DefectosTipo".
 *
 * @property integer $IdDefectoTipo
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Defectos[] $defectos
 */
class DefectosTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DefectosTipo';
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
            'IdDefectoTipo' => 'Id Defecto Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefectos()
    {
        return $this->hasMany(Defectos::className(), ['IdDefectoTipo' => 'IdDefectoTipo']);
    }
}
