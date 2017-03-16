<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class VozTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        // $this->get('/');

        // $this->assertEquals(
        //     $this->response->getContent(), $this->app->version()
        // );
   

        $this->json('POST', '/user', ['name' => 'Sally'])
             ->seeJsonEquals([
                'created' => true,
             ]);
    }
}
