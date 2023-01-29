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

    public static function uploadFile($file)
    {
       $destinationPath = public_path('files');
       $file_url =\Str::random(12).''.time().'.'.$file->getClientOriginalExtension();
       $file->move($destinationPath,$file_url);
       return $file_url;
    }

    public static function deleteFile($file_url)
    {
        $destinationPath = public_path('files');
        try {
            unlink($destinationPath.'/'.$file_url);
        } catch (\Exception $e) {}
    }
}
