<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->unsignedInteger('price');
            $table->json('features');
            $table->json('features_off')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('membership_plans')->insert([
            [
                'slug'         => 'basic',
                'name'         => 'Basic',
                'price'        => 2500,
                'features'     => json_encode(['Pristup teretani', 'Svlacionice i tusevi', 'Besplatno parkiranje']),
                'features_off' => json_encode(['Grupni treninzi', 'Personalni trener', 'Sauna i wellness']),
                'is_featured'  => 0,
                'is_active'    => 1,
                'sort_order'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'slug'         => 'standard',
                'name'         => 'Standard',
                'price'        => 4500,
                'features'     => json_encode(['Pristup teretani', 'Svlacionice i tusevi', 'Besplatno parkiranje', '2× grupna treninga/ned', 'Nutritivni plan']),
                'features_off' => json_encode(['Sauna i wellness']),
                'is_featured'  => 1,
                'is_active'    => 1,
                'sort_order'   => 2,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'slug'         => 'premium',
                'name'         => 'Premium',
                'price'        => 7000,
                'features'     => json_encode(['Pristup teretani', 'Svlacionice i tusevi', 'Besplatno parkiranje', 'Neograniceni grupni treninzi', '4× personalni trening/mes', 'Sauna i wellness zona']),
                'features_off' => json_encode([]),
                'is_featured'  => 0,
                'is_active'    => 1,
                'sort_order'   => 3,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
