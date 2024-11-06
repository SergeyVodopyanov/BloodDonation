<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Point;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Point\PointResource;

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

    /** @test */
    public function test_point_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $point = Point::factory()->create();
        // Log::info('П.С.К. из фабрики', $point->toArray());


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

        $response = $this->patch('api/points/' . $point->id, $data);
        $response->assertOk();
        $updatedPoint = Point::first();
        // Log::info('обновлённый П.С.К.', $updatedPoint->toArray());


        $this->assertEquals($data['title'], $updatedPoint->title);
        $this->assertEquals($data['city'], $updatedPoint->city);
        $this->assertEquals($data['address'], $updatedPoint->address);
        $this->assertEquals($data['geolocation'], $updatedPoint->geolocation);
        $this->assertEquals($data['first_blood_group_count'], $updatedPoint->first_blood_group_count);
        $this->assertEquals($data['second_blood_group_count'], $updatedPoint->second_blood_group_count);
        $this->assertEquals($data['third_blood_group_count'], $updatedPoint->third_blood_group_count);
        $this->assertEquals($data['fourth_blood_group_count'], $updatedPoint->fourth_blood_group_count);
        $this->assertEquals($data['enough_count'], $updatedPoint->enough_count);
        $this->assertEquals($point->id, $updatedPoint->id);
    }

    /** @test */
    public function response_for_route_points_index_is_pointresource_collection()
    {
        $this->withoutExceptionHandling();

        $points = Point::factory(10)->create();
        $response = $this->get('/api/points');
        Log::info('Список П.С.К., возвращаемый из контроллера', $response->json());

        // Преобразуем коллекцию моделей в JSON-формат с помощью ресурса
        $expected = PointResource::collection($points)->response()->getData(true);
        Log::info('Список П.С.К. в виде коллекции', $expected);

        // Сравниваем JSON-ответ с ожидаемым результатом
        $response->assertJson($expected);
    }
}
