<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase; //обновляет имзенения в бд

    /** @test */
    public function test_point_can_be_stored()
    {

        $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => '1234',
            'passport_number' => '567890',
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertOk();
        // $response->assertStatus(200);

        $this->assertDatabaseCount('users', 1);

        $point = User::first();

        $this->assertEquals($data['email'], $point->email);
        // $this->assertEquals($data['password'], $point->password);
        $this->assertEquals($data['last_name'], $point->last_name);
        $this->assertEquals($data['first_name'], $point->first_name);
        $this->assertEquals($data['middle_name'], $point->middle_name);
        $this->assertEquals($data['passport_series'], $point->passport_series);
        $this->assertEquals($data['passport_number'], $point->passport_number);
        $this->assertEquals($data['city'], $point->city);
        $this->assertEquals($data['blood_group'], $point->blood_group);
    }
}
