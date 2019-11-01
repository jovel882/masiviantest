<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree;

class TreeController extends Controller
{
    protected $treedModel;
    public function __construct(Tree $treedModel){
        $this->treedModel=$treedModel;
    }
    public function lowestCommonAncestor(Request $req,Int $id){
        if($tree=$this->treedModel->getTreeById($id)){
            $validation = \Validator::make($req->all(),[ 
                    'first-node' => 'required|integer',
                    'second-node' => 'required|integer',
            ]);
        
            if($validation->fails()){
                return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
            }
            return response()->json($tree->toArray(), 200);    
        }
        else{
            return response()->json(["errors"=>["Tree not found"]], 404);    
        }
    }    
}
