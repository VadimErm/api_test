<?php

namespace app\models;


/**
 * This is the model class for table "tweeterUsers".
 *
 * @property int $id
 * @property string $name
 */
class TweeterUser extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tweeterUsers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }

}
