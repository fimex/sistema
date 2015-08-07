<?php

namespace common\models\dux;

use Yii;

/**
 * This is the model class for table "Presentaciones".
 *
 * @property integer $IDPresentacion
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Productos[] $productos
 */
class Presentaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Presentaciones';
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
            'IDPresentacion' => 'Idpresentacion',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Acero 
Bronce',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdPresentacion' => 'IDPresentacion']);
    }
}
