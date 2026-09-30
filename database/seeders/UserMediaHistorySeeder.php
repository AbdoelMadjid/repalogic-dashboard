<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserMediaHistory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserMediaHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::with(['config'])->get();

        foreach ($users as $user) {
            // Check if media history already exists for this user
            if (UserMediaHistory::where('user_id', $user->id)->exists()) {
                continue;
            }

            $userCreated = $user->created_at ?? Carbon::now()->subMonths(2);

            // 1. Initial Avatar Creation
            UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'avatar',
                'file_path' => $user->avatar ?: 'assets/images/users/user-default.jpg',
                'file_name' => 'profile-avatar-' . $user->id . '.jpg',
                'description' => 'Foto Profil Avatar Awal',
                'meta_data' => [
                    'source' => 'system_init',
                    'updated_at' => $userCreated->format('Y-m-d H:i:s'),
                ],
                'created_at' => $userCreated,
                'updated_at' => $userCreated,
            ]);

            // 2. Cover Photo Initialization
            $coverImage = $user->config?->cover_image ?: 'assets/images/profile-bg.jpg';
            UserMediaHistory::create([
                'user_id' => $user->id,
                'media_type' => 'cover',
                'file_path' => $coverImage,
                'file_name' => 'cover-banner-' . $user->id . '.jpg',
                'description' => 'Foto Sampul Banner Profil',
                'meta_data' => [
                    'position_y' => (int) ($user->config?->cover_position_y ?? 50),
                    'height' => (int) ($user->config?->cover_height ?? 320),
                    'blur' => (int) ($user->config?->cover_blur ?? 0),
                    'color' => $user->config?->cover_color ?: '#313a46',
                ],
                'created_at' => $userCreated->copy()->addDays(2),
                'updated_at' => $userCreated->copy()->addDays(2),
            ]);

            // 3. Optional secondary avatar update for some users
            if ($user->id % 2 === 0) {
                UserMediaHistory::create([
                    'user_id' => $user->id,
                    'media_type' => 'avatar',
                    'file_path' => $user->avatar ?: 'assets/images/users/user-default.jpg',
                    'file_name' => 'updated-avatar-' . $user->id . '.jpg',
                    'description' => 'Pembaruan Foto Avatar HD',
                    'meta_data' => [
                        'source' => 'profil_pengguna',
                        'updated_at' => $userCreated->copy()->addWeeks(1)->format('Y-m-d H:i:s'),
                    ],
                    'created_at' => $userCreated->copy()->addWeeks(1),
                    'updated_at' => $userCreated->copy()->addWeeks(1),
                ]);
            }
        }
    }
}
