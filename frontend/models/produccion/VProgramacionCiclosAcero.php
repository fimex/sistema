<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_ProgramacionCiclosAcero".
 *
 * @property integer $IdProductos
 * @property integer $IdProgramacion
 * @property integer $IdProduccion
 * @property integer $Cant
 * @property integer $CantC
 * @property integer $RechazadasR
 * @property integer $RechazadasM
 * @property integer $RechazadasC
 */
class VProgramacionCiclosAcero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_ProgramacionCiclosAcero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProductos', 'IdProgramacion'], 'required'],
            [['IdProductos', 'IdProgramacion', 'IdProduccion', 'Cant', 'CantC', 'RechazadasR', 'RechazadasM', 'RechazadasC'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProductos' => 'Id Productos',
            'IdProgramacion' => 'Id Programacion',
            'IdProduccion' => 'Id Produccion',
            'Cant' => 'Cant',
            'CantC' => 'Cant C',
            'RechazadasR' => 'Rechazadas R',
            'RechazadasM' => 'Rechazadas M',
            'RechazadasC' => 'Rechazadas C',
        ];
    }
}
