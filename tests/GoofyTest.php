<?php

namespace Eduzz\Goofy\Tests;

use Eduzz\Goofy\Goofy;
use Mockery as M;

class GoofyTest extends BaseTest
{
    
    public function testGoofyCanBeInitialized()
    {
        $hermesMock = M::spy(\Eduzz\Hermes\Hermes::class);
        $goofy = new Goofy('test', $hermesMock);
        $this->assertInstanceOf(Goofy::class, $goofy);
    }

    public function testGoofyCanPublishAMessage()
    {

        $hermesMock = M::mock(\Eduzz\Hermes\Hermes::class);

        $hermesMock->shouldReceive('publish')
            ->withArgs(
                function ($args) {
                
                    $message = json_decode($args->getMessage());

                    $this->assertEquals('00000000000000000000000000000000', $message->tracker_id);
                    $this->assertEquals('test', $message->application);
                    $this->assertEquals('test', $message->flow);
                    $this->assertEquals('xpto', $message->step->name);
                    $this->assertEquals('carlos', $message->data->name);
                    $this->assertEquals(50, $message->data->id);

                    return true;
                }
            )
            ->andReturnUsing(
                function ($args) {
                    return true;
                }
            );

        $goofy = new Goofy('test', $hermesMock);

        $goofy->publish(
            '00000000000000000000000000000000',
            'test',
            'xpto',
            [
                "name" => "carlos",
                "id" => 50
            ]
        );
    }

}
