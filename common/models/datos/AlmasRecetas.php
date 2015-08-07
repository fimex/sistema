<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "AlmasRecetas".
 *
 * @property integer $IdAlmaReceta
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Almas[] $almas
 */
class AlmasRecetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AlmasRecetas';
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
            'IdAlmaReceta' => 'Id Alma Receta',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmas()
    {
        return $this->hasMany(Almas::className(), ['IdAlmaReceta' => 'IdAlmaReceta']);
    }
}
