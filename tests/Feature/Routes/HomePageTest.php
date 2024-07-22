<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;

class HomePageTest extends TestCase{

    public function test_user_can_get_home_route(){
        $response = $this->get("/");
        $response->assertStatus(200);
    
    }

}