<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NodeTest extends TestCase
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
     * Valida que se pueda crear el nodo raiz de un arbol.
     *
     * @test
     * @return void
     */
    public function CanCreateNodeOrigin()
    {
        $tree=$this->treedModelTest->createTree(["name" => "test_".microtime()]);
        $response = $this->json('POST', route('tree_node_createOrigin',["id"=>$tree->id]),["node"=> 5]);
        $response
        ->assertStatus(201)
        ->assertJsonStructure([
            "message"
            ]);
    }
    /**
     * Valida que se pueda obtener un nodo especifico.
     *
     * @test
     * @return void
     */
    public function CanGetNode()
    {
        $response = $this->json('GET', route('tree_node_get',["id"=>$this->treedModelTest->id,"node"=>85]));
        $response
            ->assertStatus(200)
            ->assertJson([
                "node"=> (array) $this->treedModelTest->data->{67}->{76}->{85}
                ]);
    }
    /**
     * Valida que se pueda crear un nodo.
     *
     * @test
     * @return void
     */
    public function CanCreateNode()
    {
        $response = $this->json('POST', route('tree_node_create',["id"=>$this->treedModelTest->id,"node"=>83]),["node"=> 5]);
        $response
        ->assertStatus(201)
        ->assertJsonStructure([
            "message"
            ]);
    }
    /**
     * Valida que se pueda actualizar un nodo.
     *
     * @test
     * @return void
     */
    public function CanUpdateNode()
    {
        $response = $this->json('PUT', route('tree_node_update',["id"=>$this->treedModelTest->id,"node"=>83]),["node"=> 5]);
        $response
        ->assertStatus(202)
        ->assertJsonStructure([
            "message"
            ]);
    }
    /**
     * Valida que se pueda eliminar un nodo.
     *
     * @test
     * @return void
     */
    public function CanDeleteNode()
    {
        $response = $this->json('DELETE', route('tree_node_delete',["id"=>$this->treedModelTest->id,"node"=>83]));
        $response
        ->assertStatus(202)
        ->assertJsonStructure([
            "message"
            ]);
    }                          
}
