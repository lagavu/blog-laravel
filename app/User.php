<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property string password
 * @property mixed image
 */
class User extends Authenticatable
{
    use Notifiable;

    const IS_ADMIN = 1;
    const IS_NO_ADMIN = 0;
    const IS_BANNED = 1;
    const IS_ACTIVE = 0;

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

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
    }

    public function delete()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) { return; }

        Storage::delete('uploads/' . $this->image);
        $filename = Str::random(10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getAvatar()
    {
        if ($this->image == null)
        {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->image;
    }

    public function makeAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
        $this->save();
    }

    public function makeNoAdmin()
    {
        $this->is_admin = User::IS_NO_ADMIN;
        $this->save();
    }

    public function toogleAdmin($value)
    {
        if($value == null)
        {
            return $this->makeNoAdmin();
        }
        return $this->makeAdmin();
    }

    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    public function toogleBan($value)
    {
        if($value == null)
        {
            return $this->unban();
        }

        return $this->ban();
    }

}
