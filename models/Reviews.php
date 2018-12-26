<?php

namespace app\models;

use Yii;
use Yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $id_city
 * @property string $title
 * @property int $rating
 * @property string $img
 * @property int $id_autor
 * @property string $date_create
 * @property string $description
 *
 * @property User $autor
 * @property City $city
 */
class Reviews extends \yii\db\ActiveRecord
{

    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[/*'id_city',*/ 'title', 'description', 'rating'], 'required'],
            [[/*'id_city',*/ 'rating', 'id_autor'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['title', 'description'], 'string'],
            [['date_create'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['img'], 'string', 'max' => 255],
            [
                ['id_autor'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_autor' => 'id']
            ],
          /*  [
               ['id_city'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['id_city' => 'id']
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'rating' => 'Rating',
            'img' => 'Img',
            'id_autor' => 'Id Autor',
            'date_create' => 'Date Create',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(User::className(), ['id' => 'id_autor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        //  return $this->hasMany(City::className(), ['review_id'=>'id']);
        return $this->hasMany(City::className(), ['id' => 'city_id'])
            ->select(['id', 'name'])
            ->viaTable('city_review', ['review_id' => 'id']);
    }

    public function uploadFile(UploadedFile $file)
    {
        $this->image = $file;
        $filename = strtolower(md5(uniqid($file->baseName)) . '.' . $file->extension);
        $file->saveAs(Yii::getAlias('@webroot') . '/uploads/' . $filename);
        $this->img = $filename;
        $this->save();
        return $filename;
    }


    private function generateFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    private function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';

    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if (!empty($currentImage) && $currentImage != null) {
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    public function saveImage()
    {
        $filename = $this->generateFilename();
        $this->image->saveAs($this->getFolder() . $filename);
        $this->img->save(false);
        return $filename;
    }

    public function getCityName()
    {
        $city = $this->getCity()->one();
        $name = $city->name;
        return $name;
    }

    public function getImage()
    {

        if ($this->img) {
            //   return 'web/uploads/'.$this->image;
            return ($this->img) ? '/uploads/' . $this->img : '/no-image.png';
            //  return  Yii::getAlias('@web') . 'uploads/'.$this->image;
        } else {
            return null;
        }
    }

    public function getAuthor()
    {
        $user = $this->getAutor()->one();
        $name = $user->fio;
        return $name;
    }

    public function saveReview()
    {
        $this->id_autor = Yii::$app->user->id;
        return $this->save(false);
    }

    public function saveCities($cities){
        if(is_array($cities)){
            foreach ($cities as $city_id){
                $city=City::findOne($city_id);
                $this->link('city',$city);
            }
        }
    }


}
