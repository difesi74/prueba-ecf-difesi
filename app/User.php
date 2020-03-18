<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Dummie data for user
     * 
     * @var array
     */
    private $data = ['id' => 0, 'email' => ''];

    /**
     * Dummie table for user
     * 
     * @var array
     */
    private static $dummieUserTable = [
        ['id' => 1, 'email' => 'info1@example.com'],
        ['id' => 2, 'email' => 'info2@example.com'],
        ['id' => 3, 'email' => 'info3@example.com'],
    ];

    /**
     * Set user data
     * 
     * @param integer $user_id
     * @return boolean
     */
    public function setData($user_id = 0)
    {
        $set = false;

        $index = array_search($user_id, array_column(self::$dummieUserTable, 'id'));

        if (($index !== false) && array_key_exists($index, self::$dummieUserTable)) {
            $this->data = self::$dummieUserTable[$index];
            $set = true;
        }
        
        return $set;
    }

    /**
     * Get user data
     * 
     * @return array
     */
    public function getData()
    {
       return $this->data; 
    }
}
