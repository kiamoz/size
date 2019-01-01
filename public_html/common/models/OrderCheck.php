<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class OrderCheck extends Model
{

    public $order_id,$order_email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['order_id', 'order_email'], 'required'],
          
        
            // password is validated by validatePassword()
            [['order_email'],'email'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */


    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
 

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
 
}
