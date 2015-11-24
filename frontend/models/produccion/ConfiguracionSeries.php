<?php

namespace frontend\models\produccion;

use Yii;
use common\models\dux\Productos;

/**
 * This is the model class for table "ConfiguracionSeries".
 *
 * @property integer $IdConfiguracionSerie
 * @property integer $SerieInicio
 *
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


    public function getSerie($get){

        $command = \Yii::$app->db;
        $result = $command->createCommand("SELECT
                                dbo.ConfiguracionSeries.IdConfiguracionSerie,
                                dbo.ConfiguracionSeries.IdProducto,
                                dbo.ConfiguracionSeries.SerieInicio,
                                dbo.Productos.IdParteMolde,
                                dbo.Productos.LlevaSerie

                                FROM
                                dbo.ConfiguracionSeries
                                INNER JOIN dbo.Productos ON dbo.ConfiguracionSeries.IdProducto = dbo.Productos.IdProducto
                                WHERE
                                dbo.ConfiguracionSeries.IdProducto = ".$get['IdProducto']." AND
                                dbo.Productos.IdParteMolde = ".$get['IdParteMolde']." ")->queryAll();

        return $result;

    }
}
