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
            [['id_city', 'title', 'description'], 'required'],
            [['id_city', 'rating', 'id_autor'], 'integer'],
            [['title', 'description'], 'string'],
            [['date_create'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['img'], 'string', 'max' => 255],
            [['id_autor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_autor' => 'id']],
            [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['id_city' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_city' => 'Id City',
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
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    public function uploadFile(UploadedFile $file)
    {
        $this->image = $file;
        $filename=strtolower(md5(uniqid($file->baseName)).'.'.$file->extension);
        $file->saveAs(Yii::getAlias('@webroot').'/uploads/'.$filename);
        $this->img=$filename;
        $this->save();
        return $filename;
     //   return $file;
       // var_dump($file);
     //    die();
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
        if($this->fileExists($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }
    public function fileExists($currentImage)
    {
        if(!empty($currentImage) && $currentImage != null)
        {
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




}
