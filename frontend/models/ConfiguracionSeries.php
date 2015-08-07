<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ConfiguracionSeries".
 *
 * @property integer $IdConfiguracionSerie
 * @property integer $IdProducto
 * @property integer $SerieInicio
 *
 * @property Productos $idProducto
 */
class ConfiguracionSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ConfiguracionSeries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'SerieInicio'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
            'IdProducto' => 'Id Producto',
            'SerieInicio' => 'Serie Inicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Productos::className(), ['IdProducto' => 'IdProducto']);
    }
}
