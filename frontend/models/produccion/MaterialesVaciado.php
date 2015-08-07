<?php

namespace frontend\models\produccion;

use common\models\catalogos\Procesos;
use Yii;
use yii\data\ArrayDataProvider;
use common\models\catalogos\Materiales;
use common\models\catalogos\SubProcesos;

/**
 * This is the model class for table "MaterialesVaciado".
 *
 * @property integer $IdMaterialVaciado
 * @property integer $IdProduccion
 * @property integer $IdMaterial
 * @property double $Cantidad
 *
 * @property Materiales $idMaterial
 * @property Producciones $idProduccion
 */
class MaterialesVaciado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MaterialesVaciado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProduccion', 'IdMaterial', 'Cantidad'], 'required'],
            [['IdProduccion', 'IdMaterial'], 'integer'],
            [['Cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMaterialVaciado' => 'Id Material Vaciado',
            'IdProduccion' => 'Id Produccion',
            'IdMaterial' => 'Id Material',
            'Cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaterial()
    {
        return $this->hasOne(Materiales::className(), ['IdMaterial' => 'IdMaterial'])
            ->with('idSubProceso');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduccion()
    {
        return $this->hasOne(Producciones::className(), ['IdProduccion' => 'IdProduccion']);
    }
    
    public function getDetalle($produccion){
        $result = $this->find()->with('idMaterial')->where("IdProduccion = $produccion")->asArray()->all();

        if(count($result)!=0){
            foreach ($result as &$res) {
                $res['Material'] = $res['idMaterial']['Descripcion'];
            }
            
            return new ArrayDataProvider([
                'allModels' => $result,
                'id'=>'IdMaterialVaciado',
                'sort'=>array(
                    'attributes'=> $result[0],
                ),
                'pagination'=>false,
            ]);
        }
        return [];
    }
}


