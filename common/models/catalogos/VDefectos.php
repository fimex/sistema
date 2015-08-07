<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "v_defectos".
 *
 * @property integer $IdDefecto
 * @property integer $IdDefectoTipo
 * @property string $Defecto
 * @property string $nombreDefecto
 * @property integer $IdProceso
 * @property string $Tipo
 * @property string $nombreTipo
 */
class VDefectos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_defectos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdDefecto', 'IdDefectoTipo', 'Defecto', 'nombreDefecto', 'IdProceso', 'Tipo', 'nombreTipo'], 'required'],
            [['IdDefecto', 'IdDefectoTipo', 'IdProceso'], 'integer'],
            [['Defecto', 'nombreDefecto', 'Tipo', 'nombreTipo'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDefecto' => 'Id Defecto',
            'IdDefectoTipo' => 'Id Defecto Tipo',
            'Defecto' => 'Defecto',
            'nombreDefecto' => 'Nombre Defecto',
            'IdProceso' => 'Id Proceso',
            'Tipo' => 'Tipo',
            'nombreTipo' => 'Nombre Tipo',
        ];
    }
}
