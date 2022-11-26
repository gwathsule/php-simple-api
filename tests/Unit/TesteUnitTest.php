<?php 

namespace Tests\Unit;

use Core\Teste;
use PHPUnit\Framework\TestCase;

class TesteUnitTest extends TestCase
{

    public function test_call_test()
    {
        $teste = new Teste();
    
        $this->assertEquals('foo', $teste->bar());
        $this->assertCount(1, [1]);
    }
}
