<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionGroup;

class QuestionGroupSeeder extends Seeder
{
    public function run(): void
    {
        QuestionGroup::firstOrCreate(
            ['name' => 'Mapeamento de Saúde Mental'],
            ['description' => 'Grupo de perguntas do formulário de mapeamento de saúde mental.']
        );
    }
}
