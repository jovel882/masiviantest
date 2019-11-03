<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree;
use Illuminate\Validation\Rule;

class TreeController extends Controller
{
    protected $treedModel;
    public function __construct(Tree $treedModel){
        $this->treedModel=$treedModel;
    }
    public function search(Request $req){
        $validation = \Validator::make($req->all(),[ 
            'name' => 'required',
            'like' => 'required|boolean',
        ]);
        if($validation->fails()){
            return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
        }        
        if($tree=$this->treedModel->searchTreeByName($req->name,$req->like)){
            return response()->json(["tree"=>$tree->toArray()], 200);   
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }        
    }
    public function get(Request $req,Int $id){
        if($tree=$this->treedModel->getTreeById($id)){
            return response()->json(["tree"=>$tree->toArray()], 200);    
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }        
    }
    public function getAll(Request $req){
        return response()->json(["tree"=>$this->treedModel->getAll()->toArray()], 200);    
    }
    public function create(Request $req){
        $validation = \Validator::make($req->all(),[ 
            'name' => 'required|unique:trees,name',
        ]);
        if($validation->fails()){
            return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
        }        
        if($tree=$this->treedModel->createTree(["name" => $req->name])){
            return response()->json(["tree"=>$tree->id], 201);   
        }
        else{
            return response()->json(["errors"=>[__('api.errors.insert')]], 500);    
        }        
    }    
    public function update(Request $req,Int $id){
        if($tree=$this->treedModel->getTreeById($id)){
            $validation = \Validator::make($req->all(),[ 
                'name' => [
                    'required',
                    Rule::unique('trees', 'name')->ignore($tree->id)                
                ],
            ]);
            if($validation->fails()){
                return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
            }        
            if($tree=$this->treedModel->updateTree(["id"=> $id,"name" => $req->name])){
                return response()->json(["message"=>__('api.message.update_tree')], 202);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.update')]], 500);    
            }        
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }        
    }    
    public function delete(Request $req,Int $id){
        if($tree=$this->treedModel->getTreeById($id)){      
            if($tree=$this->treedModel->deleteTree($id)){
                return response()->json(["message"=>__('api.message.delete_tree')], 202);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.delete')]], 500);    
            }        
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }        
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
            $firstNode=array_key_first((array)$tree->data);
            if(!$tree->data){
                return response()->json(["errors"=>[__('api.errors.empty')]], 406);
            }
            $antecesorsFirst=[];
            if($firstNode!=$req->{"first-node"}){
                $this->getAllAntecesors($tree->data,$req->{"first-node"},$antecesorsFirst);
                if(count($antecesorsFirst)==0){
                    return response()->json(["errors"=>[__('api.errors.not_found.first-node')]], 404);
                }
            }
            $antecesorsSecond=($req->{"second-node"}!=$req->{"first-node"})?[]:$antecesorsFirst;
            if($firstNode!=$req->{"second-node"} && count($antecesorsSecond)==0){
                $this->getAllAntecesors($tree->data,$req->{"second-node"},$antecesorsSecond);
                if(count($antecesorsSecond)==0){
                    return response()->json(["errors"=>[__('api.errors.not_found.second-node')]], 404);
                }
            }
            $lowestAntecesor=false;
            if(count($antecesorsFirst)>count($antecesorsSecond)){
                $antecesorsTemp=$antecesorsSecond;
                $antecesorsSecond=$antecesorsFirst;
                $antecesorsFirst=$antecesorsTemp;
            }
            foreach($antecesorsFirst as $value){
                if(array_search($value, $antecesorsSecond)!==false){                        
                    $lowestAntecesor=(int)$value;
                    break;
                }                
            }                            
            if(!$lowestAntecesor){
                return response()->json(["errors"=>[__('api.errors.not_found.antecesor')]], 404);
            }                        
            return response()->json(compact("lowestAntecesor"), 200);    
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }
    }
    private function getAllAntecesors($treeData,Int $idSearch,array &$antecesors){
        foreach($treeData as $key=>$data){
            if($key==$idSearch){
                return true;
            }
            else if($data){
                if($this->getAllAntecesors($data,$idSearch,$antecesors)){
                    $antecesors[]=$key;
                    return true;              
                }
            }
        }
        return false;
    }    
}
