<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "ConfiguracionSeries".
 *
 * @property integer $IdConfiguracionSerie
 * @property integer $SerieInicio
 *
 * @property Productos[] $productos
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
            [['SerieInicio'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
            'SerieInicio' => 'Serie Inicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['IdConfiguracionSerie' => 'IdConfiguracionSerie']);
    }
}
