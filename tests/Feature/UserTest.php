<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserTest extends TestCase
{
    use RefreshDatabase; //обновляет имзенения в бд

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }
    /** @test */
    public function test_user_can_be_stored()
    {
        $this->withoutExceptionHandling();

        $file = File::create('my_image.png');

        $data = [
            'email' => 'ivanov@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
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
        $this->assertEquals('images/' . $file->hashName(), $user->image_url);


        // ПРОВЕРКА С СУЩЕСТВОВАНИЕМ ФАЙЛА, С КОТОРОЙ БЫЛИ ПРОБЛЕМЫ
        Storage::disk('local')->assertExists($user->image_url);
    }

    /** @test */
    public function attribute_email_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => '',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('email');
    }

    /** @test */
    public function attribute_email_has_type_email_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];


        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('email');
    }

    /** @test */
    public function attribute_email_is_unique_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'person@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];


        $this->post('/api/users', $data);

        $data = [
            'email' => 'person@bk.ru',
            'password' => '3638638',
            'password_confirmation' => '3638638',
            'last_name' => 'Петров',
            'first_name' => 'Пётр',
            'middle_name' => 'Петрович',
            'passport_series' => 2452,
            'passport_number' => 764385,
            'city' => 'Магадан',
            'blood_group' => 'Третья группа крови',
        ];

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('email');
    }

    /** @test */
    public function attribute_image_has_type_file_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
            'image' => 'afdgfadasadf',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('image');
    }

    /** @test */
    public function attribute_password_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('password');
    }

    /** @test */
    public function attribute_password_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => 111,
            'password_confirmation' => 111,
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('password');
    }

    /** @test */
    public function attribute_password_is_confirmed_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => 'AAAAAAAAAAA',
            'password_confirmation' => 'BBBBBBBBBBBB',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('password');
    }

    /** @test */
    public function attribute_last_name_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => '',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('last_name');
    }

    /** @test */
    public function attribute_last_name_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 100,
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('last_name');
    }

    /** @test */
    public function attribute_first_name_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => '',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('first_name');
    }

    /** @test */
    public function attribute_first_name_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 100,
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('first_name');
    }

    /** @test */
    public function attribute_middle_name_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 100,
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        // $response->assertStatus(302);
        $response->assertInvalid('middle_name');
    }

    /** @test */
    public function attribute_passport_series_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => '',
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('passport_series');
    }

    /** @test */
    public function attribute_passport_series_has_type_integer_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 'строка',
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('passport_series');
    }

    /** @test */
    public function attribute_passport_number_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => '',
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('passport_number');
    }

    /** @test */
    public function attribute_passport_number_has_type_integer_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 'строка',
            'city' => 'Владивосток',
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('passport_number');
    }

    /** @test */
    public function attribute_city_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => '',
            'blood_group' => 'Вторая группа крови',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('city');
    }

    /** @test */
    public function attribute_city_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 123,
            'blood_group' => 'Вторая группа крови',
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('city');
    }

    /** @test */
    public function attribute_blood_group_is_required_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123321',
            'password_confirmation' => '123321',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => '',
        ];

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('blood_group');
    }

    /** @test */
    public function attribute_blood_group_has_type_string_for_storing_a_user()
    {
        // $this->withoutExceptionHandling();

        $data = [
            'email' => 'ivanov03@bk.ru',
            'password' => '123',
            'password_confirmation' => '123',
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'passport_series' => 1234,
            'passport_number' => 567890,
            'city' => 'Владивосток',
            'blood_group' => 123,
        ];

        Log::info('содержимое $data', $data);

        $response = $this->post('/api/users', $data);

        $response->assertInvalid('blood_group');
    }

    // /** @test */
    // public function user_can_be_apdated()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $file = File::create('my_image.png');
    //     $data = [
    //         'email' => 'editedivanov@bk.ru',
    //         'password' => 'editedivanov123321',
    //         'password_confirmation' => 'editedivanov123321',
    //         'last_name' => 'editedivanovИванов',
    //         'first_name' => 'editedivanovИван',
    //         'middle_name' => 'editedivanovИванович',
    //         'passport_series' => 123423232,
    //         'passport_number' => 567890232323,
    //         'city' => 'editedivanovВладивосток',
    //         'blood_group' => 'Третья группа крови',
    //         'image' => $file,
    //     ];

    //     $response = $this->patch('api/users/' . $user->id, $data);
    //     $response->assertOk();
    //     $updatedUser = User::first();

    //     $this->assertEquals($data['email'], $user->email);
    //     $this->assertEquals($data['last_name'], $user->last_name);
    //     $this->assertEquals($data['first_name'], $user->first_name);
    //     $this->assertEquals($data['middle_name'], $user->middle_name);
    //     $this->assertEquals($data['passport_series'], $user->passport_series);
    //     $this->assertEquals($data['passport_number'], $user->passport_number);
    //     $this->assertEquals($data['city'], $user->city);
    //     $this->assertEquals('images/' . $file->hashName(), $user->image_url);
    //     $this->assertEquals($user->id, $updatedUser->id);
    // }
}
