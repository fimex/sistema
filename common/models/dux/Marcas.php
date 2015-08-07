<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "Marcas".
 *
 * @property integer $IdMarca
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Productos[] $productos
 */
class Marcas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Marcas';
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
            'IdMarca' => 'Id Marca',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdMarca' => 'IdMarca']);
    }
}
