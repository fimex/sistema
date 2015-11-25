<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_ProduccionesDetalleCalidad".
 *
 * @property integer $Hechas
 * @property integer $IdEstatus
 * @property integer $IdProgramacion
 * @property integer $IdProductos
 */
class VProduccionesDetalleCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProduccionesDetalleCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Hechas', 'IdEstatus', 'IdProgramacion', 'IdProductos'], 'integer'],
            [['IdProgramacion', 'IdProductos'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Hechas' => 'Hechas',
            'IdEstatus' => 'Id Estatus',
            'IdProgramacion' => 'Id Programacion',
            'IdProductos' => 'Id Productos',
        ];
    }
}
