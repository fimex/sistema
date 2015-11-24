<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "Estatus".
 *
 * @property integer $IdEstatus
 * @property string $Descripcion
 *
 * @property ProduccionesDetalle[] $produccionesDetalles
 */
class Estatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Estatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Descripcion'], 'required'],
            [['Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEstatus' => 'Id Estatus',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduccionesDetalles()
    {
        return $this->hasMany(ProduccionesDetalle::className(), ['IdEstatus' => 'IdEstatus']);
    }
}
