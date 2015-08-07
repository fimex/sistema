<?php

namespace common\models\dux;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "v_Productos".
 *
 * @property integer $IdProducto
 * @property integer $IdMarca
 * @property integer $IdPresentacion
 * @property integer $IdAleacion
 * @property integer $IdProductoCasting
 * @property string $Identificacion
 * @property string $Descripcion
 * @property string $ProductoCasting
 * @property string $Marca
 * @property string $Presentacion
 * @property string $Aleacion
 * @property integer $PiezasMolde
 * @property integer $CiclosMolde
 * @property string $PesoCasting
 * @property string $PesoArania
 */
class VProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_Productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdProducto', 'IdMarca', 'IdPresentacion', 'IdAleacion'], 'required'],
            [['IdProducto', 'IdMarca', 'IdPresentacion', 'IdAleacion', 'IdProductoCasting', 'PiezasMolde', 'CiclosMolde'], 'integer'],
            [['Identificacion', 'Descripcion', 'ProductoCasting', 'Marca', 'Presentacion', 'Aleacion'], 'string'],
            [['PesoCasting', 'PesoArania'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdProducto' => 'Id Producto',
            'IdMarca' => 'Id Marca',
            'IdPresentacion' => 'Id Presentacion',
            'IdAleacion' => 'Id Aleacion',
            'IdProductoCasting' => 'Id Producto Casting',
            'Identificacion' => 'Identificacion',
            'Descripcion' => 'Descripcion',
            'ProductoCasting' => 'Producto Casting',
            'Marca' => 'Marca',
            'Presentacion' => 'Presentacion',
            'Aleacion' => 'Aleacion',
            'PiezasMolde' => 'Piezas Molde',
            'CiclosMolde' => 'Ciclos Molde',
            'PesoCasting' => 'Peso Casting',
            'PesoArania' => 'Peso Arania',
        ];
    }
    
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VProductos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'IdProducto' => $this->IdProducto,
            'IdMarca' => $this->IdMarca,
            'IdPresentacion' => $this->IdPresentacion,
            'IdAleacion' => $this->IdAleacion,
            'IdProductoCasting' => $this->IdProductoCasting,
            'Identificacion' => $this->Identificacion,
            'Descripcion' => $this->Descripcion,
            'ProductoCasting' => $this->ProductoCasting,
            'Marca' => $this->Marca,
            'Presentacion' => $this->Presentacion,
            'Aleacion' => $this->Aleacion,
            'PiezasMolde' => $this->PiezasMolde,
            'CiclosMolde' => $this->CiclosMolde,
            'PesoCasting' => $this->PesoCasting,
            'PesoArania' => $this->PesoArania,
        ]);

        $query->andFilterWhere(['like', 'Identificacion', $this->Identificacion])
            ->andFilterWhere(['like', 'Descripcion', $this->Descripcion]);

        return $dataProvider;
    }
    
    public function getProductos($marca,$area){
       /* $area = Yii::$app->session->get('area');
       
        $area = $area['IdArea'];
         $id = $_GET['area'];
         echo 'Area'.$id;*/
        $result = $this->find()->where([
            'IdPresentacion' => $area,
            'IdMarca' => $marca
        ])->asArray()->all();
        
        if(count($result)!=0){
            return new ArrayDataProvider([
                'allModels' => $result,
                'key'=>['IdProgramacionSemana'],
                'id'=>'IdProgramacion',
                'sort'=>array(
                    'attributes'=>array_keys($result[0]),
                ),
                'pagination'=>false,
            ]);
        }
        return [];
    }
}
