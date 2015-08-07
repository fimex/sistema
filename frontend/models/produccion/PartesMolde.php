<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "PartesMolde".
 *
 * @property integer $IdParteMolde
 * @property string $Identificador
 *
 * @property ProduccionesDetalle[] $produccionesDetalles
 */
class PartesMolde extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PartesMolde';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador'], 'required'],
            [['Identificador'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdParteMolde' => 'Id Parte Molde',
            'Identificador' => 'Identificador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdParteMolde' => 'IdParteMolde']);
    }
}
