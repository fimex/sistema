<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "MaterialesTipo".
 *
 * @property integer $IdMaterialTipo
 * @property string $Descripcion
 *
 * @property Materiales[] $materiales
 */
class MaterialesTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MaterialesTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterialTipo' => 'Id Materia Tipo',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMateriales()
    {
        return $this->hasMany(Materiales::className(), ['IdMaterialTipo' => 'IdMaterialTipo']);
    }
}
