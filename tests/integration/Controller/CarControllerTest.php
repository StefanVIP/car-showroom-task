<?php

namespace App\Tests\integration\Controller;

class CarControllerTest extends AppTestCase
{
    public function testGetCarList(): void
    {
        $this->get('/api/v1/cars');

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertIsArray($response);
        $this->assertObjectHasProperty('id', $response[0]);
        $this->assertObjectHasProperty('brand', $response[0]);
        $this->assertObjectHasProperty('photo', $response[0]);
        $this->assertObjectHasProperty('price', $response[0]);
    }

    public function testGetCarDetails(): void
    {
        $this->get('/api/v1/cars/1');

        $this->assertResponseStatusCodeSame(200);

        $response = $this->getResponseJSON();

        $this->assertObjectHasProperty('id', $response);
        $this->assertObjectHasProperty('brand', $response);
        $this->assertObjectHasProperty('model', $response);
        $this->assertObjectHasProperty('photo', $response);
        $this->assertObjectHasProperty('price', $response);
    }
}
