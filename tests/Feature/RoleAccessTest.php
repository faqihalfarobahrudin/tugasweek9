<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    public function test_guest_redirected_to_login(): void
    {
        $this->get('/admin/users')->assertRedirect('/login');
    }

    public function test_admin_access(): void
    {
        $admin = User::factory()->make(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/users')->assertStatus(200);
        $this->actingAs($admin)->get('/kelola-materi')->assertStatus(200);
        $this->actingAs($admin)->get('/nilai-saya')->assertStatus(403);
    }

    public function test_dosen_access(): void
    {
        $dosen = User::factory()->make(['role' => 'dosen']);

        $this->actingAs($dosen)->get('/kelola-materi')->assertStatus(200);
        $this->actingAs($dosen)->get('/kelola-nilai')->assertStatus(200);
        $this->actingAs($dosen)->get('/admin/users')->assertStatus(403);
    }

    public function test_mahasiswa_access(): void
    {
        $mahasiswa = User::factory()->make(['role' => 'mahasiswa']);

        $this->actingAs($mahasiswa)->get('/materi')->assertStatus(200);
        $this->actingAs($mahasiswa)->get('/nilai-saya')->assertStatus(200);
        $this->actingAs($mahasiswa)->get('/kelola-materi')->assertStatus(403);
        $this->actingAs($mahasiswa)->get('/admin/users')->assertStatus(403);
    }
}