<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_AlmasPorProgramar".
 *
 * @property integer $IdProgramacion
 * @property integer $IdAlma
 * @property integer $IdProducto
 */
class v_AlmasPorProgramar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_AlmasPorProgramar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdAlma', 'IdProducto'], 'required'],
            [['IdProgramacion', 'IdAlma', 'IdProducto'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdAlma' => 'Id Alma',
            'IdProducto' => 'Id Producto',
        ];
    }
}
