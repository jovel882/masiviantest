<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class NodeFunctionsTest extends TestCase
{
    protected $nodeControllerTest;
    protected $dataTest;

    public function setUp() :void
    {
        parent::setUp();
        $this->nodeControllerTest = new \App\Http\Controllers\NodeController(new \App\Models\Tree());
        $this->dataTest = json_decode('{
            "67": {
              "39": {
                "28": {
                  "29": false
                },
                "44": false
              },
              "76": {
                "74": false,
                "85": {
                  "83": false,
                  "87": false
                }
              }
            }
          }');
    }
    /**
     * Valida que se pueda crear un nodo.
     *
     * @test
     * @return void
     */
    public function CanCreateNode()
    {
        $tempNode=$this->dataTest->{67}->{39};
        $this->nodeControllerTest->createNode($tempNode,44,5);
        $dataTest= json_decode('{
                "28": {
                  "29": false
                },
                "44": {
                    "5": false
                }
            }');        
        $this->assertEquals($tempNode,$dataTest);                
    }
    /**
     * Valida que se pueda actualizar un nodo.
     *
     * @test
     * @return void
     */
    public function CanUpdateNode()
    {
        $tempNode=$this->dataTest->{67}->{39};
        $this->nodeControllerTest->updateNode($tempNode,44,5);
        $dataTest= json_decode('{
                "28": {
                  "29": false
                },
                "5": false
            }');        
        $this->assertEquals($tempNode,$dataTest);                
    }
    /**
     * Valida que se pueda eliminar un nodo.
     *
     * @test
     * @return void
     */
    public function CanDeleteNode()
    {
        $tempNode=$this->dataTest->{67}->{39};
        $this->nodeControllerTest->deleteNode($tempNode,44,5);
        $dataTest= json_decode('{
                "28": {
                  "29": false
                }
            }');        
        $this->assertEquals($tempNode,$dataTest);                
    }        
    /**
     * Valida que se pueda ejecutar una funcion sobre un nodo.
     *
     * @test
     * @return void
     */
    public function CanExecuteActionNode()
    {
        $dataResponse=$this->nodeControllerTest->executeActionNode($this->dataTest,44,5,"createNode");
        $dataTest= json_decode('{
            "67": {
              "39": {
                "28": {
                  "29": false
                },
                "44": {
                    "5": false
                }
              },
              "76": {
                "74": false,
                "85": {
                  "83": false,
                  "87": false
                }
              }
            }
          }');        
        $this->assertEquals($dataResponse,$dataTest);                
    }
    /**
     * Valida que se pueda obtener un nodo.
     *
     * @test
     * @return void
     */
    public function CanGetNode()
    {
        $dataResponse=$this->nodeControllerTest->getNode($this->dataTest,85);
        $dataTest= json_decode('{
                "83": false,
                "87": false
            }');        
        $this->assertEquals($dataResponse,$dataTest);                
    }        
}
