<?php

namespace App\Models;

use App\Http\Resources\Snippet\SnippetResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Snippet extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['user_id', 'title', 'is_public'];
    protected $casts = ['id' => 'string'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $touches = ['steps'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($snippet) {
            $snippet->steps()->create([
                'order' => 1
            ]);
        });
    }

    public function isPublic()
    {
        return $this->is_public;
    }

    public function scopePublic(Builder $builder)
    {
        return $builder->where('is_public', true);
    }

    public function steps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Step::class)->orderBy('order', 'asc');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->latest();
    }


    public function toSearchableArray()
    {

//        $array = $this->toArray();
//        unset($array['created_at']);
//        unset($array['updated_at']);
//        unset($array['user_id']);
//        $array['steps'] = $this->steps()->get()->map(function ($data) {
//            return ['title' => $data['title'], 'body' => $data['body']];
//        });
//        $array['author'] = $this->user()->get()->map(function ($data) {
//            return ['name' => $data['name'], 'email' => $data['email']];
//        });

        $arr = SnippetResource::make($this->load('steps'))->jsonSerialize();

        unset($arr['owner']);

        return $arr;
    }
}
