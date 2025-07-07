<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Deck;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $nombres = ["victor","hugo","cristobal","alberto","james","raquel","virginia","carlos","jonay","lautaro"];
        $comandantes = ["Kudo, King Among Bears","Urza, Chief Artificer","Niv-Mizzet, Visionary","Urtet, Remnant of Memnarch","Mendicant Core, Guidelight","Bladewing, Deathless Tyrant","Gluntch, the Bestower","Kros, Defense Contractor","Xyris, the Writhing Storm","Norin the Wary"];
        for ($i=0; $i < 10; $i++) { 
            $role = "user";
            if($i < 3){
                $role ="admin";
            }
            DB::table('users')->insert([
            'username' => $nombres[$i],
            'email' => $nombres[$i]."@email.es",
            'password' => bcrypt('123456'),
            'role' => $role,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        }

        for ($i=0; $i < 16; $i++) { 
            $comandanteActual = $comandantes[rand(0,9)];
            $usuario = rand(0,9);
            DB::table('decks')->insert([
            'name' => fake()->name(),
            'description' => Str::random(15),
            'commander' => $comandanteActual,
            'decklist' => '["1 '.$comandanteActual.'"]',
            'owner_name' => $nombres[$usuario],
            'owner_id' => (int)$usuario+1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}