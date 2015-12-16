<?php

namespace frontend\models\produccion;

use Yii;

/**
 * This is the model class for table "v_CiclosComponentes".
 *
 * @property integer $IdProgramacion
 * @property integer $IdProgramacionSemana
 * @property integer $IdProgramacionDia
 * @property integer $IdArea
 * @property integer $IdAreaAct
 * @property integer $Anio
 * @property integer $Semana
 * @property string $Dia
 * @property integer $IdProducto
 * @property string $Producto
 * @property string $Aleacion
 * @property integer $PiezasMolde
 * @property integer $CiclosMolde
 * @property integer $CiclosMoldeA
 * @property string $PesoCasting
 * @property string $PesoArania
 * @property integer $Prioridad
 * @property integer $Programadas
 * @property integer $FechaMoldeo
 * @property string $LlevaSerie
 * @property integer $SerieInicio
 * @property integer $IdConfiguracionSerie
 * @property integer $IdParteMolde
 * @property integer $Componente
 * @property integer $OkComponentesMoldeo
 * @property integer $RecComponentesMoldeo
 * @property integer $RepComponentesMoldeo
 * @property integer $RecComponentesCerrado
 * @property integer $OkMoldesCerrados
 * @property integer $BaseDivicion
 */
class VCiclosComponentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_CiclosComponentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdArea', 'IdAreaAct', 'Anio', 'Semana', 'Dia', 'IdProducto', 'PiezasMolde', 'PesoCasting', 'PesoArania'], 'required'],
            [['IdProgramacion', 'IdProgramacionSemana', 'IdProgramacionDia', 'IdArea', 'IdAreaAct', 'Anio', 'Semana', 'IdProducto', 'PiezasMolde', 'CiclosMolde', 'CiclosMoldeA', 'Prioridad', 'Programadas', 'FechaMoldeo', 'SerieInicio', 'IdConfiguracionSerie', 'IdParteMolde', 'Componente', 'OkComponentesMoldeo', 'RecComponentesMoldeo', 'RepComponentesMoldeo', 'RecComponentesCerrado', 'OkMoldesCerrados', 'BaseDivicion'], 'integer'],
            [['Dia'], 'safe'],
            [['Producto', 'Aleacion', 'LlevaSerie'], 'string'],
            [['PesoCasting', 'PesoArania'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'IdProgramacionSemana' => 'Id Programacion Semana',
            'IdProgramacionDia' => 'Id Programacion Dia',
            'IdArea' => 'Id Area',
            'IdAreaAct' => 'Id Area Act',
            'Anio' => 'Anio',
            'Semana' => 'Semana',
            'Dia' => 'Dia',
            'IdProducto' => 'Id Producto',
            'Producto' => 'Producto',
            'Aleacion' => 'Aleacion',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'CiclosMoldeA' => 'Ciclos Molde A',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
            'Prioridad' => 'Prioridad',
            'Programadas' => 'Programadas',
            'FechaMoldeo' => 'Fecha Moldeo',
            'LlevaSerie' => 'Lleva Serie',
            'SerieInicio' => 'Serie Inicio',
            'IdConfiguracionSerie' => 'Id Configuracion Serie',
            'IdParteMolde' => 'Id Parte Molde',
            'Componente' => 'Componente',
            'OkComponentesMoldeo' => 'Ok Componentes Moldeo',
            'RecComponentesMoldeo' => 'Rec Componentes Moldeo',
            'RepComponentesMoldeo' => 'Rep Componentes Moldeo',
            'RecComponentesCerrado' => 'Rec Componentes Cerrado',
            'OkMoldesCerrados' => 'Ok Moldes Cerrados',
            'BaseDivicion' => 'Base Divicion',
        ];
    }
}
