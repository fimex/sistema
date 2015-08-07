<?php

namespace common\models\catalogos;

use Yii;
use common\models\datos\Filtros;

/**
 * This is the model class for table "FiltrosTipo".
 *
 * @property integer $IdFiltroTipo
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $CantidadPorPaquete
 * @property string $DUX_CodigoPesos
 * @property string $DUX_CodigoDolares
 *
 * @property Filtros[] $filtros
 */
class FiltrosTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FiltrosTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'required'],
            [['Identificador', 'Descripcion', 'DUX_CodigoPesos', 'DUX_CodigoDolares'], 'string'],
            [['CantidadPorPaquete'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdFiltroTipo' => 'Id Filtro Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'CantidadPorPaquete' => 'Cantidad Por Paquete',
            'DUX_CodigoPesos' => 'Dux  Codigo Pesos',
            'DUX_CodigoDolares' => 'Dux  Codigo Dolares',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiltros()
    {
        return $this->hasMany(Filtros::className(), ['IdFiltroTipo' => 'IdFiltroTipo'])->with('idProducto');
    }
    
    public function getFiltrosTipo()
    {
        $command = \Yii::$app->db;
        $result =$command->createCommand("SELECT * FROM FiltrosTipo")->queryAll();

        return $result;
    }
}
