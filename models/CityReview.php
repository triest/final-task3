<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city_review".
 *
 * @property int $id
 * @property int $city_id
 * @property int $review_id
 *
 * @property City $city
 * @property Reviews $review
 */
class CityReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'review_id'], 'integer'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::className(), 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'review_id' => 'Review ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::className(), ['id' => 'review_id']);
    }


}
