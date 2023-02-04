<?php

namespace Tests\Feature;

use App\Models\Company\Company;
use App\Models\User;
use Database\Seeders\CompanyTableSeeder;
use Database\Seeders\RoleTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleTableSeeder::class]);
        $this->user = $this->getUser();
    }

    private function getUser(): User
    {
        return User::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_company_home_page_contain_empty_data()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('No Data Available!');
    }

    public function test_company_home_page_contain_data()
    {
        $this->seed([CompanyTableSeeder::class]);

        $company = Company::latest()->first();

        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('companies', function ($collection) use ($company) {
            return $collection->contains($company);
        });
    }

    public function test_admin_can_see_company_create_button()
    {
        $this->user->roles()->attach(1);

        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Add Company');
    }

    public function test_non_admin_cant_see_company_create_button()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Add Company');
    }

    public function test_admin_can_access_company_create_action()
    {
        $this->user->roles()->attach(1);

        $response = $this->actingAs($this->user)->get('/company/create');

        $response->assertStatus(200);
    }

    public function test_non_admin_cant_access_company_create_action()
    {
        $response = $this->actingAs($this->user)->get('/company/create');

        $response->assertStatus(403);
    }

    public function test_create_company_validation_fail()
    {
        $this->user->roles()->attach(1);

        // $response = $this->actingAs($this->user)
        //     ->withHeaders([
        //         'Accept' => 'application/json',
        //     ])
        //     ->post(
        //         '/company',
        //         []
        //     );

        // $response->assertStatus(422);
        // $response->assertJsonValidationErrors([
        //     "name" => [
        //         "Company Name is required"
        //     ],
        //     "email" => [
        //         "The email field is required."
        //     ]
        // ]);

        $response = $this->actingAs($this->user)
            ->post(
                '/company',
                []
            );
        $response->assertStatus(302);
        $response->assertInvalid(['name', 'email']);
    }
}
