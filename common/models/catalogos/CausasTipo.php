<?php

namespace common\models\catalogos;

use Yii;
use common\models\datos\Causas;

/**
 * This is the model class for table "CausasTipo".
 *
 * @property integer $IdCausaTipo
 * @property string $Identificador
 * @property string $Descripcion
 *
 * @property Causas[] $causas
 */
class CausasTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CausasTipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Identificador', 'Descripcion'], 'required'],
            [['Identificador', 'Descripcion'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCausaTipo' => 'Id Causa Tipo',
            'Identificador' => 'Identificador',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCausas()
    {
        return $this->hasMany(Causas::className(), ['IdCausaTipo' => 'IdCausaTipo']);
    }
}
