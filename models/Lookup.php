<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $position
 */
class Lookup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lookup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'position' => 'Position',
        ];
    }
}
