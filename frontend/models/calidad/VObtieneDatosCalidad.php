<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "v_ObtieneDatosCalidad".
 *
 * @property integer $Hechas
 * @property integer $IdProgramacion
 * @property integer $IdProducto
 * @property integer $IdEstatus
 */
class VObtieneDatosCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ObtieneDatosCalidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Hechas', 'IdProgramacion', 'IdProducto', 'IdEstatus'], 'integer'],
            [['IdProgramacion', 'IdProducto'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Hechas' => 'Hechas',
            'IdProgramacion' => 'Id Programacion',
            'IdProducto' => 'Id Producto',
            'IdEstatus' => 'Id Estatus',
        ];
    }
}
