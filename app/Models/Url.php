<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urls';

    protected $hidden = [
        //
    ];

    /**
     *
     * fillable properties
     */
    protected $fillable = [
        'id',
        'user_id',
        'url',
        'slug',
        'redirect_count'
    ];

    protected $casts = [
        //
    ];

    public function scopeUser($query, $userId=null){
        if($userId){
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    public function scopeSorting($query,$sort)
    {
        if($sort){
            if($sort[1]=='asc'){
                return $query->orderBy($sort[0]);
            }else{
                return $query->orderByDesc($sort[0]);
            }
        }else{
            return $query;
        }
    }

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function getShortenUrlAttribute(){
        return route('shorten-url', ['slug' => $this->slug]);
    }
}
