<?php

namespace Database\Seeders;

use App\Models\GroupClass;
use App\Models\Trainer;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    /**
     * Demo trainers — personal trainers are bookable per session,
     * group trainers run recurring classes instead.
     */
    public function run(): void
    {
        $personal = [
            [
                'name'            => 'Marko Markovic',
                'specialty'       => 'Snaga & Kondicija',
                'bio'             => '10 godina iskustva u radu sa klijentima svih nivoa. Specijalizovan za izgradnju misicne mase i gubitak masti. Bivsi profesionalni sportista sa jasnim pristupom ka rezultatima.',
                'session_price'   => 3000,
                'avatar_initials' => 'MM',
                'avatar_gradient' => 'linear-gradient(140deg, #1c0500 0%, #2e0a00 100%)',
            ],
            [
                'name'            => 'Ana Jovanovic',
                'specialty'       => 'Yoga & Pilates',
                'bio'             => 'Sertifikovani instruktor joge i pilatesa sa 8 godina iskustva. Pomaze klijentima da postignu balans tela i uma kroz holistican i personalizovan pristup treninzima.',
                'session_price'   => 3000,
                'avatar_initials' => 'AJ',
                'avatar_gradient' => 'linear-gradient(140deg, #080a1c 0%, #0d112e 100%)',
            ],
            [
                'name'            => 'Nikola Stojanovic',
                'specialty'       => 'HIIT & Kardio',
                'bio'             => 'Bivsi atleticar sa 5 drzavnih titula. Specijalizovan za kardio programe i HIIT koji daju brze i vidljive rezultate. Radi sa klijentima koji zele da sagore mast i povecaju kondiciju.',
                'session_price'   => 3000,
                'avatar_initials' => 'NS',
                'avatar_gradient' => 'linear-gradient(140deg, #001a08 0%, #002d10 100%)',
            ],
        ];

        foreach ($personal as $data) {
            Trainer::updateOrCreate(
                ['name' => $data['name']],
                $data + ['trainer_type' => 'personal', 'is_active' => true]
            );
        }

        $boxer = Trainer::updateOrCreate(
            ['name' => 'Milos Doknic'],
            [
                'specialty'       => 'Boks i kickbox',
                'bio'             => 'Profesionalni boks trener. Grupni treninzi se odrzavaju tri puta nedeljno.',
                'session_price'   => null,
                'avatar_initials' => 'MD',
                'avatar_gradient' => 'linear-gradient(140deg, #1c1500 0%, #2e2300 100%)',
                'trainer_type'    => 'group',
                'is_active'       => true,
            ]
        );

        GroupClass::updateOrCreate(
            ['trainer_id' => $boxer->id, 'name' => 'Boks'],
            [
                'sala'              => 'Sala A',
                'days_of_week'      => 'Pon, Sre, Pet',
                'time_start'        => '16:00',
                'sessions_per_week' => 3,
                'monthly_price'     => 2900,
                'description'       => 'Grupni boks trening za sve nivoe — tehnika, kondicija i sparing.',
                'is_active'         => true,
            ]
        );
    }
}
