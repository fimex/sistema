<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "v_existencias".
 *
 * @property string $Identificador
 * @property string $Identificacion
 * @property string $Existencia
 * @property string $CostoPromedio
 */
class VExistencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_existencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Identificacion'], 'string'],
            [['Existencia', 'CostoPromedio'], 'required'],
            [['Existencia', 'CostoPromedio'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Identificador' => 'Identificador',
            'Identificacion' => 'Identificacion',
            'Existencia' => 'Existencia',
            'CostoPromedio' => 'Costo Promedio',
        ];
    }
}
