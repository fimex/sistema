<?php

namespace common\models\vistas;

use Yii;

/**
 * This is the model class for table "v_Aleaciones".
 *
 * @property integer $IdAleacion
 * @property string $Identificador
 * @property string $Descripcion
 * @property integer $IdAleacionTipo
 * @property integer $IdPresentacion
 */
class VAleaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Aleaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAleacion', 'IdAleacionTipo', 'IdPresentacion'], 'required'],
            [['IdAleacion', 'IdAleacionTipo', 'IdPresentacion'], 'integer'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAleacion' => 'Id Aleacion',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
            'IdAleacionTipo' => 'Id Aleacion Tipo',
            'IdPresentacion' => 'Id Presentacion',
        ];
    }
}
