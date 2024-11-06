<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
{
    use RefreshDatabase; //обновляет имзенения в бд

    /** @test */
    public function test_user_can_be_stored()
    {

        $this->withoutExceptionHandling();

        Storage::fake('local');

        $file = File::create('my_image.png');

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
            'image' => $file,
        ];

        $response = $this->post('/api/users', $data);

        $response->assertOk();

        $this->assertDatabaseCount('users', 1);

        $user = User::first();

        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['middle_name'], $user->middle_name);
        $this->assertEquals($data['passport_series'], $user->passport_series);
        $this->assertEquals($data['passport_number'], $user->passport_number);
        $this->assertEquals($data['city'], $user->city);
        // $this->assertEquals('storage/app/images/' . $file->hashName(), $user->image_url);
        $this->assertEquals('images/' . $file->hashName(), $user->image_url);


        // НЕПОНЯТНО ПОЧЕМУ НЕ НАХОДИТСЯ ФАЙЛ ПО УКАЗАННОМУ ПУТИ, ЕСЛИ ОН НА САМОМ ДЕЛЕ СОЗДАЁТСЯ
        Storage::disk('local')->assertExists($user->image_url);
    }
}
