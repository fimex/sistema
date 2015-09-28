<?php

namespace frontend\models\tt;

use Yii;

/**
 * This is the model class for table "TTTipoEnfriamientos".
 *
 * @property integer $IdTipoEnfriamiento
 * @property string $Descripcion
 * @property string $DescripcionEng
 */
class TTTipoEnfriamientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TTTipoEnfriamientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Descripcion', 'DescripcionEng'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoEnfriamiento' => 'Id Tipo Enfriamiento',
            'Descripcion' => 'Descripcion',
            'DescripcionEng' => 'Descripcion Eng',
        ];
    }
}
