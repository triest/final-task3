<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $fio;
    public $phone;
    
    public function rules()
    {
        return [
            [['username','email','password','phone'], 'required'],
            [['username'], 'string'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass'=>'app\models\User', 'targetAttribute'=>'email'],
            [['fio'],'string'],
            [['phone'],'string'],

        ];
    }


    public function signup()
    {
        if($this->validate())
        {
            $user = new User();
            $user->attributes = $this->attributes;
            return $user->create();
        }
    }

}