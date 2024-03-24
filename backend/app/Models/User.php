<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table ='users';
    protected $primaryKey ='id';
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'email',
        'name',
        'password'
    ];
    public function getAuthIdentifierName(){
        return 'email';
    }
    public function getAuthIdentifier(){
        return $this->email;
    }
    public function getAuthPassword(){
        return $this->password;
    }
    public function getRememberToken(){
        return $this->token;
    }
    public function getRememberTokenName(){
        return 'token';
    }
    public function setRememberToken($token){
        return $this->token = $token;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
