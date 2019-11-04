<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Tree;

class CanlowestCommonAncestorTest extends TestCase
{
    /**
     * Valida que la busqueda se este realizando correctamente.
     *
     * @test
     * @return void
     */
    public function CanlowestCommonAncestor()
    {
        $tree = factory(\App\Models\Tree::class)->create([
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
        // $response = $this->json('GET', '/api/tree/'.$tree->id.'/lowestCommonAncestor',["first-node"=>29,"second-node"=>44]);
        $response = $this->json('GET', route('tree_lowestCommonAncestor', ['id' => $tree->id]),["first-node"=>29,"second-node"=>44]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'lowestAntecesor' => 39,
            ]);
        $tree->forceDelete();
    }
}
