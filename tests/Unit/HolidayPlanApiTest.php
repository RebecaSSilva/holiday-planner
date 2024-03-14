<?php
/**
 * HolidayPlanController Unit Tests Documentation
 *
 * The purpose of these unit tests is to ensure that the functions in the HolidayPlanController behave as expected,
 * including handling requests, data validation, and responses.
 */

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\HolidayPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class HolidayPlanApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the behavior of the index route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when accessed.
     * - Usage: Validates if the home page loads successfully.
     */
    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test the behavior of the show route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when accessing an existing holiday plan.
     * - Usage: Validates if a specific holiday plan is fetched successfully.
     */
    public function testShow()
    {
        $user = User::factory()->create();
        $holidayPlan = HolidayPlan::factory()->create();
        $response = $this->actingAs($user)->get("/holiday-plans/{$holidayPlan->id}");
        $response->assertStatus(200);
    }
    
    /**
     * Test the behavior of the store route.
     *
     * - Expected Behavior: Expects the route to return a status code of 201 (Created) when creating a new holiday plan.
     * - Usage: Validates if a new holiday plan is created successfully.
     */
    public function testStore()
    {
        $holidayPlanData = HolidayPlan::factory()->make()->toArray();
        $response = $this->actingAs($user = User::factory()->create())->post('/holiday-plans', $holidayPlanData);
        $response->assertStatus(201);
    }

    /**
     * Test the behavior of the update route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when updating an existing holiday plan.
     * - Usage: Validates if an existing holiday plan is updated successfully.
     */
    public function testUpdate()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $holidayPlanData = HolidayPlan::factory()->make()->toArray();
        $response = $this->actingAs($user = User::factory()->create())->post("/holiday-plans-edit/{$holidayPlan->id}", $holidayPlanData);
        $response->assertStatus(200);
    }

    /**
     * Test the behavior of the destroy route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when deleting an existing holiday plan.
     * - Usage: Validates if an existing holiday plan is deleted successfully.
     */
    public function testDestroy()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $response = $this->actingAs($user = User::factory()->create())->delete("/holiday-plans/{$holidayPlan->id}");
        $response->assertStatus(200);
    }

    /**
     * Test the behavior of the generate PDF route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when generating a PDF for an existing holiday plan.
     * - Usage: Validates if a PDF is generated successfully for an existing holiday plan.
     */
    public function testGeneratePdf()
    {
        $holidayPlan = HolidayPlan::factory()->create();
        $response = $this->actingAs($user = User::factory()->create())->get("/holiday-plans/{$holidayPlan->id}/generate-pdf");
        $response->assertStatus(200);
    }

    /**
     * Test the behavior of the data table route.
     *
     * - Expected Behavior: Expects the route to return a status code of 200 (OK) when fetching data for DataTables.
     * - Usage: Validates if the DataTable data is retrieved successfully.
     */
    public function testDataTable()
    {
        HolidayPlan::factory()->count(10)->create();
        $response = $this->actingAs($user = User::factory()->create())->post('/holiday-plans/datatable');
        $response->assertStatus(200);
    }
}
