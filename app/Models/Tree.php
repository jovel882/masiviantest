<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tree extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
    public function setdataAttribute(array $value)
    {
        $this->attributes['data'] = json_encode($value);
    }    
    public function getTreeById($id){
        return self::find($id);
    }
}
