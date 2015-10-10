<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_series".
 *
 * @property integer $IdSerie
 * @property integer $IdProducto
 * @property integer $IdSubProceso
 * @property integer $IdProduccionDetalle
 * @property string $Serie
 * @property string $Estatus
 * @property string $FechaHora
 * @property string $Comentarios
 */
class VSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_series';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdSerie', 'IdProducto', 'IdSubProceso', 'IdProduccionDetalle'], 'required'],
            [['IdSerie', 'IdProducto', 'IdSubProceso', 'IdProduccionDetalle'], 'integer'],
            [['Serie', 'Estatus', 'Comentarios'], 'string'],
            [['FechaHora'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdSerie' => 'Id Serie',
            'IdProducto' => 'Id Producto',
            'IdSubProceso' => 'Id Sub Proceso',
            'IdProduccionDetalle' => 'Id Produccion Detalle',
            'Serie' => 'Serie',
            'Estatus' => 'Estatus',
            'FechaHora' => 'Fecha Hora',
            'Comentarios' => 'Comentarios',
        ];
    }
}
