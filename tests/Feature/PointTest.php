<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Point;

class PointTest extends TestCase
{
    use RefreshDatabase; //обновляет имзенения в бд

    /** @test */
    public function test_point_can_be_stored()
    {

        $this->withoutExceptionHandling();

        $data = [
            'title' => 'Краевой центр переливания крови',
            'city' => 'Владивосток',
            'address' => 'Октябрьская ул., 6, Владивосток, Приморский край, 690091',
            'geolocation' => '43.12476607828302, 131.8847024076707',
            'first_blood_group_count' => 125,
            'second_blood_group_count' => 52,
            'third_blood_group_count' => 228,
            'fourth_blood_group_count' => 48,
            'enough_count' => 123,
        ];

        $response = $this->post('/api/points', $data);

        $response->assertOk();
        // $response->assertStatus(200);

        $this->assertDatabaseCount('points', 1);

        $point = Point::first();

        $this->assertEquals($data['title'], $point->title);
        $this->assertEquals($data['city'], $point->city);
        $this->assertEquals($data['address'], $point->address);
        $this->assertEquals($data['geolocation'], $point->geolocation);
        $this->assertEquals($data['first_blood_group_count'], $point->first_blood_group_count);
        $this->assertEquals($data['second_blood_group_count'], $point->second_blood_group_count);
        $this->assertEquals($data['third_blood_group_count'], $point->third_blood_group_count);
        $this->assertEquals($data['fourth_blood_group_count'], $point->fourth_blood_group_count);
        $this->assertEquals($data['enough_count'], $point->enough_count);
    }
}
