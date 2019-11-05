<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree;
use Illuminate\Validation\Rule;

class NodeController extends Controller
{
    protected $treedModel;
    public function __construct(Tree $treedModel){
        $this->treedModel=$treedModel;
    }    
    public function createOrigin(Request $req,$id){
        if($tree=$this->treedModel->getTreeById($id)){
            if(!empty($tree->data)){
                return response()->json(["errors"=>[__('api.errors.origin')]], 412);
            }
            $validation = \Validator::make($req->all(),[ 
                'node' => 'required|integer',
            ]);
            if($validation->fails()){
                return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
            }
            if($tree=$this->treedModel->updateTreeNodes(["id"=> $id,"data" => [$req->node=>false]])){
                return response()->json(["message"=>__('api.message.create_origin')], 201);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.insert_node_origin')]], 500);    
            }              
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);
        }        
        
    }
    public function get(Request $req,Int $id,Int $node){
        if($tree=$this->treedModel->getTreeById($id)){
            if($nodeFind=$this->getNode($tree->data,$node)){
                return response()->json(["node"=>$nodeFind], 200);
            }
            else{
                return response()->json(["errors"=>[__('api.errors.not_found.node')]], 404);
            }
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        }        
    } 
    public function create(Request $req,Int $id,Int $node){
        if($tree=$this->treedModel->getTreeById($id)){
            $validation = \Validator::make($req->all(),[ 
                'node' => 'required|integer',
            ]);
            if($validation->fails()){
                return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
            }
            if($this->getNode($tree->data,$req->node)){
                return response()->json(["errors"=>[__('api.errors.duplicate_node',["node"=>$req->node])]], 404);
            }             
            $dataTree=$this->executeActionNode($tree->data,$node,$req->node,"createNode");
            if($dataTree==$tree->data){
                return response()->json(["errors"=>[__('api.errors.not_found.node')]], 404);
            }
            if(isset($dataTree->errors)){
                return response()->json(["errors"=>$dataTree->errors], 412);    
            }
            if($tree=$this->treedModel->updateTreeNodes(["id"=> $id,"data" => (array)$dataTree])){
                return response()->json(["message"=>__('api.message.create_node',["node"=>$req->node,"node2"=>$node])], 201);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.insert_node')]], 500);    
            }            
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        } 
    }
    public function update(Request $req,Int $id,Int $node){
        if($tree=$this->treedModel->getTreeById($id)){
            $validation = \Validator::make($req->all(),[ 
                'node' => 'required|integer',
            ]);
            if($validation->fails()){
                return response()->json(["errors"=>$validation->errors()->toArray()], 412);    
            }
            if($this->getNode($tree->data,$req->node)){
                return response()->json(["errors"=>[__('api.errors.duplicate_node',["node"=>$req->node])]], 404);
            }             
            $dataTree=$this->executeActionNode($tree->data,$node,$req->node,"updateNode");
            if($dataTree==$tree->data){
                return response()->json(["errors"=>[__('api.errors.not_found.node')]], 404);
            }
            if($tree=$this->treedModel->updateTreeNodes(["id"=> $id,"data" => (array)$dataTree])){
                return response()->json(["message"=>__('api.message.update_node',["node"=>$req->node,"node2"=>$node])], 202);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.update_node')]], 500);    
            }            
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        } 
    }
    public function delete(Request $req,Int $id,Int $node){
        if($tree=$this->treedModel->getTreeById($id)){
            $dataTree=$this->executeActionNode($tree->data,$node,false,"deleteNode");
            if($dataTree==$tree->data){
                return response()->json(["errors"=>[__('api.errors.not_found.node')]], 404);
            }
            if($tree=$this->treedModel->updateTreeNodes(["id"=> $id,"data" => (array)$dataTree])){
                return response()->json(["message"=>__('api.message.delete_node',["node"=>$node])], 202);   
            }
            else{
                return response()->json(["errors"=>[__('api.errors.delete_node')]], 500);    
            }            
        }
        else{
            return response()->json(["errors"=>[__('api.errors.not_found.tree')]], 404);    
        } 
    }
    public function executeActionNode($treeData,Int $idNode,Int $node,String $method){
        foreach($treeData as $key=>$data){
            if($key==$idNode){
                $this->$method($treeData,$key,$node);
                return $treeData;
            }
            else if($data){
                $treeDataTemp=$this->executeActionNode($treeData->{$key},$idNode,$node,$method);
                if(!isset($treeDataTemp->errors)){
                    $treeData->{$key}=$treeDataTemp;
                }
                else{
                    $treeData=$treeDataTemp;
                    return $treeData;
                }
            }
        }
        return $treeData;
    }              
    public function getNode($treeData,Int $node){
        foreach($treeData as $key=>$data){
            if($key==$node){
                return (!$data)?__('api.message.empty_node'):$data;
            }
            else if($data){
                if($nodeFind=$this->getNode($data,$node)){
                    return $nodeFind;              
                }                
            }
        }
        return false;
    }
    public function createNode(&$treeData,Int $idNode,Int $node){
        if($treeData->{$idNode} && count((array)$treeData->{$idNode})==2){
            $treeData = json_decode('{"errors":"'.__('api.errors.full_node',["node"=>$idNode]).'"}');
        }
        else{
            if(!$treeData->{$idNode}){
                $treeData->{$idNode}=json_decode('{"'.$node.'":false}');
            }
            else{
                $treeData->{$idNode}->{$node}=false;
            }
        }
    }        
    public function updateNode(&$treeData,Int $idNode,Int $node){
        $treeData->{$node}=$treeData->{$idNode};
        unset($treeData->{$idNode});        
    }        
    public function deleteNode(&$treeData,Int $idNode,Int $node){
        unset($treeData->{$idNode});        
    }        
}
