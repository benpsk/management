<?php

namespace Tests\Feature;

use App\Models\Company\Company;
use App\Models\User;
use CompanyTableSeeder;
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
}
