<?php

namespace common\models\datos;

use Yii;

/**
 * This is the model class for table "Bitacora".
 *
 * @property integer $IdBitacora
 * @property string $FechaInicio
 * @property string $Descripcion
 * @property string $Tabla
 * @property string $IdUsuario
 * @property string $IP
 * @property string $Campo
 * @property string $ValorNuevo
 * @property string $ValorAnterior
 */
class Bitacora extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Bitacora';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FechaInicio'], 'safe'],
            [['Descripcion', 'Tabla', 'IP', 'Campo', 'ValorNuevo'], 'required'],
            [['Descripcion', 'Tabla', 'IdUsuario', 'IP', 'Campo', 'ValorNuevo', 'ValorAnterior'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBitacora' => 'Id Bitacora',
            'FechaInicio' => 'Fecha Inicio',
            'Descripcion' => 'Descripcion',
            'Tabla' => 'Tabla',
            'IdUsuario' => 'Id Usuario',
            'IP' => 'Ip',
            'Campo' => 'Campo',
            'ValorNuevo' => 'Valor Nuevo',
            'ValorAnterior' => 'Valor Anterior',
        ];
    }
}
