<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "ProduccionesEstatus".
 *
 * @property integer $IdProduccionEstatus
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Producciones[] $producciones
 */
class ProduccionesEstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ProduccionesEstatus';
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
            'IdProduccionEstatus' => 'Id Produccion Estatus',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdProduccionEstatus' => 'IdProduccionEstatus']);
    }
}
