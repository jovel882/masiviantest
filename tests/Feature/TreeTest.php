<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TreeTest extends TestCase
{
    use DatabaseTransactions;

    protected $treedModelTest;

    public function setUp() :void
    {
        parent::setUp();
        $this->treedModelTest=factory(\App\Models\Tree::class)->create([
            'data' => [
                67 => [
                    39 => [
                        28 => [
                            29 => false
                        ],
                        44 => false
                    ],
                    76 => [
                        74 => false,
                        85 => [
                            83 => false,
                            87 => false
                        ]
                    ]
                ],
            ],
        ]);        
    }    
    /**
     * Valida que la busqueda por nombre en cualquier posicion del string se puede realizar.
     *
     * @test
     * @return void
     */
    public function CanSearchTreeForNameAny()
    {
        $quantityChar=strlen($this->treedModelTest->name);
        $aleatorio=rand(0,($quantityChar-4));
        $response = $this->json('GET', route('tree_search'),['name'=>substr($this->treedModelTest->name,$aleatorio,4),'any' => 1]);
        $response
            ->assertStatus(200)
            ->assertJson([
                "tree"=>[
                    [
                        "name" => $this->treedModelTest->name,
                        "id" => $this->treedModelTest->id,
                    ]
                ]
            ]);
    }
    /**
     * Valida que la busqueda por nombre exacto se puede realizar.
     *
     * @test
     * @return void
     */
    public function CanSearchTreeForNameExact()
    {
        $response = $this->json('GET', route('tree_search'),['name'=>$this->treedModelTest->name,'any' => 0]);
        $response
            ->assertStatus(200)
            ->assertJson([
                "tree"=>[
                    [
                        "name" => $this->treedModelTest->name,
                        "id" => $this->treedModelTest->id,
                    ]
                ]
            ]);
    }
    /**
     * Valida que se pueda obtener todos los arboles disponibles.
     *
     * @test
     * @return void
     */
    public function CanGetAllTree()
    {
        $response = $this->json('GET', route('tree_getAll'));
        $response
            ->assertStatus(200)
            ->assertJsonCount($this->treedModelTest->getAll()->count(), "tree")
            ->assertJsonFragment($this->treedModelTest->toArray());
    }
    /**
     * Valida que se pueda obtener un arbol especifico.
     *
     * @test
     * @return void
     */
    public function CanGetTree()
    {
        $response = $this->json('GET', route('tree_get',["id"=>$this->treedModelTest->id]));
        $response
            ->assertStatus(200)
            ->assertJson([
                "tree"=> [
                    "name" => $this->treedModelTest->name,
                    "id" => $this->treedModelTest->id,
                ]
            ]);
    }
    /**
     * Valida que se pueda crear un arbol.
     *
     * @test
     * @return void
     */
    public function CanCreateTree()
    {
        $response = $this->json('POST', route('tree_create'),["name"=> "test_".microtime()]);
        $response
        ->assertStatus(201)
        ->assertJsonStructure([
            "tree"
            ]);
    }            
    /**
     * Valida que se pueda actualizar un arbol.
     *
     * @test
     * @return void
     */
    public function CanUpdateTree()
    {
        $response = $this->json('PUT', route('tree_update',["id"=>$this->treedModelTest->id]),["name"=> "test_".microtime()]);
        $response
        ->assertStatus(202)
        ->assertJsonStructure([
            "message"
            ]);
    }            
    /**
     * Valida que se pueda eliminar un arbol.
     *
     * @test
     * @return void
     */
    public function CanDeleteTree()
    {
        $response = $this->json('DELETE', route('tree_delete',["id"=>$this->treedModelTest->id]));
        $response
        ->assertStatus(202)
        ->assertJsonStructure([
            "message"
            ]);
    }
    /**
     * Valida que la busqueda del antecesor comun mas cercano funcione.
     *
     * @test
     * @return void
     */
    public function CanlowestCommonAncestor()
    {
        $response = $this->json('GET', route('tree_lowestCommonAncestor', ['id' => $this->treedModelTest->id]),["first-node"=>29,"second-node"=>44]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'lowestAntecesor' => 39,
            ]);
    }                
}