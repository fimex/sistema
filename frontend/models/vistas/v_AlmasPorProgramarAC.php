<?php

namespace frontend\models\vistas;

use Yii;

/**
 * This is the model class for table "v_AlmasPorProgramarAC".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProducto
 * @property integer $IdAlma
 */
class v_AlmasPorProgramarAC extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_AlmasPorProgramarAC';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdProducto', 'IdAlma'], 'required'],
            [['IdProgramacion', 'IdProducto', 'IdAlma'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProducto' => 'Id Producto',
            'IdAlma' => 'Id Alma',
        ];
    }
}
