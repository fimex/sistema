<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "AreaActual".
 *
 * @property integer $IdAreaAct
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Productos[] $productos
 */
class AreaActual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'AreaActual';
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
            'IdAreaAct' => 'Id Area Act',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdAreaAct' => 'IdAreaAct']);
    }
}
