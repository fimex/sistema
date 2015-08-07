<?php

namespace common\models\catalogos;

use Yii;
use common\models\User;

/**
 * This is the model class for table "Empleados".
 *
 * @property integer $IdEmpleado
 * @property integer $Nomina
 * @property string $ApellidoPaterno
 * @property string $ApellidoMaterno
 * @property string $Nombre
 * @property integer $IdEstatus
 * @property string $RFC
 * @property string $IMSS
 * @property integer $IdDepartamento
 * @property integer $IdTurno
 * @property integer $IdPuesto
 *
 * @property Programaciones[] $programaciones
 * @property Producciones[] $producciones
 * @property ProgramacionesAlma[] $programacionesAlmas
 * @property User[] $users
 */
class Empleados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Empleados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Nomina'], 'required'],
            [['Nomina', 'IdEstatus', 'IdDepartamento', 'IdTurno', 'IdPuesto'], 'integer'],
            [['ApellidoPaterno', 'ApellidoMaterno', 'Nombre', 'RFC', 'IMSS'], 'string']
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
            'ApellidoPaterno' => 'Apellido Paterno',
            'ApellidoMaterno' => 'Apellido Materno',
            'Nombre' => 'Nombre',
            'IdEstatus' => 'Id Estatus',
            'RFC' => 'Rfc',
            'IMSS' => 'Imss',
            'IdDepartamento' => 'Id Departamento',
            'IdTurno' => 'Id Turno',
            'IdPuesto' => 'Id Puesto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['IdEmpleado' => 'IdEmpleado']);
    }
}
