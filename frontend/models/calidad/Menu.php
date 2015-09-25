<?php

namespace frontend\models\calidad;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property string $nombre
 * @property integer $parte
 * @property string $titulo
 *
 * @property MenuTipo[] $menuTipos
 * @property Tipo[] $tipos
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mysql_calidad');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'parte', 'titulo'], 'required'],
            [['parte'], 'integer'],
            [['titulo'], 'string'],
            [['nombre'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'parte' => 'Parte',
            'titulo' => 'Titulo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuTipos()
    {
        return $this->hasMany(MenuTipo::className(), ['menu' => 'parte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipos()
    {
        return $this->hasMany(Tipo::className(), ['id' => 'tipo'])->viaTable('menu_tipo', ['menu' => 'parte']);
    }
}
