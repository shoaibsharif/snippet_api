<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'title', 'body', 'snippet_id'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $casts = ['id' => 'string'];
    protected $keyType = 'string';

    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }

    public function afterOrder()
    {
        $adjacent = self::where('order', '>', $this->order)->orderBy('order', 'asc')->first();
        if (!$adjacent) {
            return self::orderBy('order', 'desc')->first()->order + 1;
        }
        return ($this->order + $adjacent->order) / 2;
    }

    public function beforeOrder()
    {
        $adjacent = self::where('order', '<', $this->order)->orderBy('order', 'desc')->first();
        if (!$adjacent) {
            return self::orderBy('order', 'asc')->first()->order - 1;
        }
        return ($this->order + $adjacent->order) / 2;
    }
}
