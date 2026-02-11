<?php

namespace Tests\Feature;

use App\Models\Region;
use Modules\Core\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RegionTest extends TestCase
{
    use RefreshDatabase;

    protected $permission;

    protected function setUp(): void
    {
        parent::setUp();

        $this->permission = Permission::firstOrCreate(['name' => 'manage_regions', 'guard_name' => 'sanctum']);
        app()['cache']->forget(config('permission.cache.key'));
    }

    private function createToken($role = 'admin', $withPermission = true)
    {
        $user = User::factory()->create();
        Role::firstOrCreate(['name' => $role]);
        $user->assignRole($role);

        if ($withPermission) {
            $user->givePermissionTo($this->permission);
            app()['cache']->forget(config('permission.cache.key'));
            $user = $user->fresh();
        }

        return $user->createToken('test-token')->plainTextToken;
    }


    //! Authorization Tests

    public function test_guest_cannot_access_regions()
    {
        $response = $this->getJson('/api/regions');
        $response->assertStatus(200);
    }

    public function test_user_without_permission_cannot_create_region()
    {
        $token = $this->createToken('user', false);

        $regionData = ['name' => 'Unauthorized Region', 'name_ar' => 'منطقة غير مصرح بها'];
        $response = $this->withToken($token)->postJson('/api/regions', $regionData);
        $response->assertStatus(403);
    }

    public function test_user_without_permission_cannot_update_region()
    {
        $token = $this->createToken('user', false);

        $region = Region::create(['name' => 'Old Region', 'name_ar' => 'منطقة قديمة']);
        $response = $this->withToken($token)->putJson("/api/regions/{$region->id}", ['name' => 'Edited']);
        $response->assertStatus(403);
    }

    public function test_user_without_permission_cannot_delete_region()
    {
        $token = $this->createToken('user', false);

        $region = Region::create(['name' => 'NoDelete', 'name_ar' => 'ممنوع حذف']);
        $response = $this->withToken($token)->deleteJson("/api/regions/{$region->id}");
        $response->assertStatus(403);
    }

    //! CRUD Tests

    public function test_can_list_regions()
    {
        $token = $this->createToken();

        Region::factory()->count(3)->create();

        $response = $this->withToken($token)->getJson('/api/regions');
        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data' => [['id', 'name', 'name_ar', 'created_at', 'updated_at']],
            'message'
        ]);

        $this->assertCount(3, $response->json('data'));
    }

    public function test_create_region()
    {
        $token = $this->createToken();

        $regionData = ['name' => 'Test Region', 'name_ar' => 'منطقة اختبار'];
        $response = $this->withToken($token)->postJson('/api/regions', $regionData);
        $response->assertStatus(201)->assertJsonStructure(['status', 'data', 'message']);

        $this->assertDatabaseHas('regions', $regionData);
    }

    public function test_update_region()
    {
        $token = $this->createToken();

        $region = Region::create(['name' => 'Old Region', 'name_ar' => 'منطقة قديمة']);
        $response = $this->withToken($token)->putJson("/api/regions/{$region->id}", ['name' => 'Updated Region']);
        $response->assertStatus(200)->assertJsonStructure(['status', 'data', 'message']);

        $this->assertDatabaseHas('regions', ['name' => 'Updated Region']);
    }

    public function test_delete_region()
    {
        $token = $this->createToken();

        $region = Region::create(['name' => 'ToDelete', 'name_ar' => 'منطقة للحذف']);
        $response = $this->withToken($token)->deleteJson("/api/regions/{$region->id}");
        $response->assertStatus(200)->assertJsonStructure(['status', 'data', 'message']);

        $this->assertDatabaseMissing('regions', ['id' => $region->id]);
    }

    //! Validation Tests

    public function test_create_region_validation_errors()
    {
        $token = $this->createToken();

        $response = $this->withToken($token)->postJson('/api/regions', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'name_ar']);
    }

    public function test_create_region_duplicate_name()
    {
        $token = $this->createToken();

        $regionData = ['name' => 'Duplicate', 'name_ar' => 'مكرر'];
        Region::create($regionData);

        $response = $this->withToken($token)->postJson('/api/regions', $regionData);
        $response->assertStatus(422)->assertJsonValidationErrors(['name']);
    }
}
