<?php

namespace common\models\dux;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "v_marcas".
 *
 * @property integer $IdMarca
 * @property string $Marca
 * @property integer $IdPresentacion
 */
class VMarcas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_marcas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMarca', 'Marca', 'IdPresentacion'], 'required'],
            [['IdMarca', 'IdPresentacion'], 'integer'],
            [['Marca'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMarca' => 'Id Marca',
            'Marca' => 'Marca',
            'IdPresentacion' => 'Id Presentacion',
        ];
    }
    
    public function getMarcas($area){
        //$area = Yii::$app->session->get('area');
        //$area = $area['IdArea'];
        return $this->find()->where(['IdPresentacion' => $area])->all();
    }
}
