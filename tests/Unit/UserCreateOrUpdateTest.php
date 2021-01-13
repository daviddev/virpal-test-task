<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserCreateOrUpdateTest extends TestCase
{

    use RefreshDatabase;
    public $user;

    /**
     * @after
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\User')->create();

    }

    /**
     * A basic unit test example.
     * @runInSeparateProcess
     * @return void
     */
    public function testCreateOrUpdateCustomerUser()
    {
        $repository = new UserRepository($this->user);

        $request = Request::create('users/store', 'POST', array([
            'role' => env('app.customer-role-id'),
            'name' => Str::random(8),
            'email' => Str::random(10) . '@gmail.com',
            'dob_or_orgid' => now(),
            'phone' => rand(9, 11),
            'mobile' => rand(9, 11),
            'password' => Str::random(8),
            'consumer_type' => 'paid',
            'customer_type' => 'customer_type',
            'username' => 'User name',
            'post_code' => 0566,
            'address' => '1st quarter',
            'city' => 'Yerevan',
            'town' => 'Armavir',
            'country' => 'Armenia',
            'additional_info' => Str::random(20),
            'status' => 1,
            'new_towns' => 'New Town'
        ]));

        $response = $repository->updateOrCreate(null, $request);

        $this->assertDatabaseHas('companies', [
            'name' => $request->get('name'),
            'additional_info' => 'Created automatically for user ' . $this->user->id,
        ]);

        $this->assertDatabaseHas('departments', [
            'name' => $request->get('name'),
            'additional_info' => 'Created automatically for user ' . $this->user->id,
        ]);

        $this->assertDatabaseHas('user_meta', [
            'consumer_type' => $request->get('consumer_type'),
            'customer_type' => $request->get('customer_type'),
            'username' => $request->get('username'),
            'post_code' => $request->get('post_code'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'town' => $request->get('town'),
            'country' => $request->get('country'),
            'reference' => '0',
            'additional_info' => $request->get('additional_info'),
            'cost_place' => '',
            'fee' => '',
            'time_to_charge' => '',
            'time_to_pay' => '',
            'charge_ob' => '',
            'customer_id' => '',
            'charge_km' => '',
            'maximum_km' => '',
        ]);

        $this->assertDatabaseHas('towns', [
            'townname' => $request->get('new_towns')
        ]);

        $this->assertTrue(!!$response);

        $this->assertDatabaseHas('users', [
            'role' => $request->get('role'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'dob_or_orgid' => $request->get('dob_or_orgid'),
            'phone' => $request->get('phone'),
            'mobile' => $request->get('mobile'),
            'password' => $request->get('password'),
            'consumer_type' => $request->get('consumer_type'),
            'customer_type' => $request->get('customer_type'),
            'username' => $request->get('username'),
            'post_code' => $request->get('post_code'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'town' => $request->get('town'),
            'country' => $request->get('country'),
            'additional_info' => $request->get('additional_info'),
            'status' => $request->get('status'),
            'new_towns' => $request->get('new_towns'),
        ]);
    }

    /**
     * A basic unit test example.
     * @runInSeparateProcess
     * @return void
     */
    public function testCreateOrUpdateTranslatorUser()
    {
        $repository = new UserRepository($this->user);

        $request = Request::create('users/store', 'POST', array([
            'role' => env('app.customer-role-id'),
            'name' => Str::random(8),
            'email' => Str::random(10) . '@gmail.com',
            'dob_or_orgid' => now(),
            'phone' => rand(9, 11),
            'mobile' => rand(9, 11),
            'password' => Str::random(8),
            'consumer_type' => 'paid',
            'translator_type' => 'translator_type',
            'worked_for' => 'yes',
            'organization_number' => rand(8),
            'gender' => 'male',
            'translator_level' => 'High',
            'address' => '1st quarter',
            'post_code' => 1534,
            'additional_info' => Str::random(20),
            'address_2' => Str::random(8),
            'town' => 'New Town',
            'user_language' => [1, 2],
            'user_towns_projects' => [3, 5],
        ]));

        $response = $repository->updateOrCreate($this->user->id, $request);


        $this->assertDatabaseHas('user_meta', [
            'translator_type' => $request->get('translator_type'),
            'worked_for' => $request->get('worked_for'),
            'organization_number' => $request->get('organization_number'),
            'gender' => $request->get('gender'),
            'translator_level' => $request->get('translator_level'),
            'additional_info' => $request->get('additional_info'),
            'post_code' => $request->get('post_code'),
            'address' => $request->get('address'),
            'address_2' => $request->get('address_2'),
            'town' => $request->get('town'),
        ]);

        $this->assertDatabaseHas('user_languages', [
            [
                'user_id' => $this->user->id,
                'lang_id' => 1
            ],
            [
                'user_id' => $this->user->id,
                'lang_id' => 2
            ],
        ]);

        $this->assertDatabaseHas('user_towns', [
            [
                'user_id' => $this->user->id,
                'town_id' => 3
            ],
            [
                'user_id' => $this->user->id,
                'town_id' => 5
            ],
        ]);

        $this->assertTrue(!!$response);

        $this->assertDatabaseHas('users', [
            'role' => $request->get('role'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'dob_or_orgid' => $request->get('dob_or_orgid'),
            'phone' => $request->get('phone'),
            'mobile' => $request->get('mobile'),
            'password' => $request->get('password'),
            'consumer_type' => $request->get('consumer_type'),
            'status' => $request->get('status'),
        ]);
    }
}
