<?php

namespace common\models\catalogos;

use Yii;

/**
 * This is the model class for table "v_empleados".
 *
 * @property integer $IdEmpleado
 * @property integer $Nomina
 * @property string $NombreCompleto
 * @property integer $IdEstatus
 * @property string $RFC
 * @property string $IMSS
 * @property integer $IdDepartamento
 * @property string $IDENTIFICACION
 * @property string $DESCRIPCION
 * @property integer $IdTurno
 * @property integer $IdPuesto
 */
class VEmpleados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_empleados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'Nomina', 'NombreCompleto', 'IdDepartamento', 'IDENTIFICACION'], 'required'],
            [['IdEmpleado', 'Nomina', 'IdEstatus', 'IdDepartamento', 'IdTurno', 'IdPuesto'], 'integer'],
            [['NombreCompleto', 'RFC', 'IMSS', 'IDENTIFICACION', 'DESCRIPCION'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEmpleado' => 'Id Empleado',
            'Nomina' => 'Nomina',
            'NombreCompleto' => 'Nombre Completo',
            'IdEstatus' => 'Id Estatus',
            'RFC' => 'Rfc',
            'IMSS' => 'Imss',
            'IdDepartamento' => 'Id Departamento',
            'IDENTIFICACION' => 'Identificacion',
            'DESCRIPCION' => 'Descripcion',
            'IdTurno' => 'Id Turno',
            'IdPuesto' => 'Id Puesto',
        ];
    }
}
