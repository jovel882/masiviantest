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
    public function getAll(){
        return self::all();
    }
    public function createTree($data){
        try {
            return self::create($data);
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }         
    }
    public function updateTree($data){
        try {
            return self::findOrFail($data["id"])->fill($data)->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }         
    }
    public function deleteTree($id){
        try {
            return self::findOrFail($id)->delete();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }         
    }
    public function searchTreeByName($name,$like){
        $tree=self::whereName($name);
        if($like){
            $tree=self::where('name', 'like', '%'.$name.'%');
        }        
        return $tree->get();
    }
}
