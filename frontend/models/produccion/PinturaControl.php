<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "Pintura_control".
 *
 * @property integer $id_pintura
 * @property string $fecha
 * @property string $turno
 * @property string $Motivo
 * @property string $pintura
 * @property double $den_ini
 * @property double $den_fin
 * @property string $serie
 * @property double $pin_nueva
 * @property double $pin_recicl
 * @property string $comentarios
 * @property string $nomina
 * @property double $alcohol
 * @property string $area
 * @property string $base
 * @property double $base_cant

 */
class PinturaControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Pintura_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'turno', 'Motivo', 'pintura', 'den_ini', 'den_fin', 'nomina', 'area'], 'required'],
            [['fecha', ], 'safe'],
            [['turno', 'Motivo', 'pintura', 'serie', 'comentarios', 'nomina', 'area', 'base'], 'string'],
            [['den_ini', 'den_fin', 'pin_nueva', 'pin_recicl', 'alcohol', 'base_cant'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pintura' => 'Id',
            'fecha' => 'Fecha',
            'turno' => 'Turno',
            'Motivo' => 'Motivo',
            'pintura' => 'Pintura',
            'den_ini' => 'Densidad Inicial',
            'den_fin' => 'Densidad Final',
            'serie' => 'Serie',
            'pin_nueva' => 'Pintura Nueva',
            'pin_recicl' => 'Pintura Reciclada',
            'comentarios' => 'Comentarios',
            'nomina' => 'Nomina',
            'alcohol' => 'Alcohol',
            'area' => 'Area',
            'base' => 'Base',
            'base_cant' => 'Base Cant',
           
        ];
    }
}
