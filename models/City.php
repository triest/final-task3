<?php

namespace app\models;

use Yii;
use Yii\base\Model;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property string $date_create
 *
 * @property Reviews[] $reviews
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_create'], 'safe'],
            [['date_create'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['name'], 'string', 'max' => 255],
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
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['id' => 'review_id'])
            ->viaTable('city_review', ['city_id' => 'id']);
    }

}
