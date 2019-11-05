<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class TreeFunctionsTest extends TestCase
{
    protected $treedControllerTest;
    protected $dataTest;

    public function setUp() :void
    {
        parent::setUp();
        $this->treedControllerTest = new \App\Http\Controllers\TreeController(new \App\Models\Tree());
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
     * Valida que se pueda obtener todos los antecesores.
     *
     * @test
     * @return void
     */
    public function CanGetAllAntecesors()
    {
        $antecesorsTest=[];
        $this->treedControllerTest->getAllAntecesors($this->dataTest,85,$antecesorsTest);
        $this->assertEquals(["76","67"],$antecesorsTest);                
    }    
}
