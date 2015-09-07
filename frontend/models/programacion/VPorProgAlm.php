<?php

namespace frontend\models\programacion;
use frontend\models\programacion\ProgramacionesAlma;
use Yii;

/**
 * This is the model class for table "V_porProgAlm".
 *
 * @property integer $IdProgramacion
 * @property integer $idalma
 */
class VPorProgAlm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'V_porProgAlm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProgramacion'], 'required'],
            [['IdProgramacion', 'idalma'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProgramacion' => 'Id Programacion',
            'idalma' => 'Idalma',
        ];
    }
	
	public function generaProgAlmas(){
		
		$almasSinProg = $this->find()->asArray()->all();
		//print_r ($almasSinProg);exit;
		foreach($almasSinProg as $alma){
                            $almasProgramadas = new ProgramacionesAlma();
                            $almas_prog['ProgramacionesAlma'] = [
                                'IdProgramacion' => $alma['IdProgramacion'],
                                'IdEmpleado' => Yii::$app->user->identity->IdEmpleado,
                                'IdProgramacionEstatus' => 1,
                                'IdAlmas' => $alma['idalma'],
                                'Programadas' => 0,
                                'Hechas' => 0,
                            ];
                            $almasProgramadas->load($almas_prog);
                            $tmp = $almasProgramadas->save();
							var_dump($tmp);
                        }
		
	}
}
