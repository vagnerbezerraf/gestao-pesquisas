<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionGroup;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $group = QuestionGroup::firstOrCreate(
            ['name' => 'Mapeamento de Saúde Mental'],
            ['description' => 'Grupo de perguntas do formulário de mapeamento de saúde mental.']
        );

        $questionsData = [
            'Sensação de morte iminente ou pânico' => 5,
            'Medo Intenso' => 2,
            'Desrealização' => 3,
            'Despersonalização' => 3,
            'Crises conversivas' => 3,
            'Crises dissociativas' => 3,
            'Queixas somáticas persistentes ou hipocondríacas' => 1,
            'Pensamentos ou comportamentos repetitivos' => 3,
            'Pensamento de inutilidade ou culpa' => 4,
            'Ideia suicida ou tentativa de suicídio' => 9,
            'Isolamento social' => 6,
            'Auto agressividade com o corpo ou terceiros' => 9,
            'Desinibição social ou sexual' => 7,
            'Atos impulsivos ou hiperatividade' => 3,
            'Euforia' => 4,
            'Elevação desproporcional de autoestima' => 2,
            'Delírio' => 8,
            'Alucinação' => 10,
            'Alteração do curso de pensamento' => 9,
            'Perda do juízo crítico da realidade' => 10,
            'Delírio e tremor' => 10,
            'Tremor associado ao hálito etílico e sudorese etílica' => 3,
            'Incapacidade de redução e controle do uso de drogas' => 6,
            'Manifestação de risco para si e para terceiros' => 6,
            'Intolerância' => 3,
            'Dificuldade manifestada na infância ou adolescência de compreender e transmitir informações' => 3,
            'Movimentos corporais ou comportamentais estereotipados' => 5,
            'Desatenção manifestada na infância ou adolescência' => 4,
            'Inquietação constante manifestada na infância ou adolescência' => 2,
            'Regressão' => 1,
            'Perda de memória' => 3,
            'Perda de capacidade ocupacional' => 4,
            'Desorientação temporal ou de espaço' => 5,
            'Resistência ao tratamento' => 4,
            'Recorrência ou recaída' => 9,
            'Uso de substâncias psicoativas' => 10,
            'Exposição continuada ao estresse' => 3,
            'Precariedade de suporte social' => 3,
            'Precariedade de suporte familiar' => 6,
            'Testemunha de violência' => 4,
            'Autor ou vítima de violência' => 8,
            'Perda de funcionalidade familiar ou afetiva' => 6,
            'Vulnerabilidade econômica ou ambiental' => 3,
            'Comorbidades ou outra condição crônica associada' => 3,
            'Faixa etária >14 e <18' => 10,
            'Abandono e/ou atraso escolar' => 6,
        ];

        foreach ($questionsData as $text => $weight) {
            Question::create([
                'text' => $text,
                'description' => $text,
                'type' => 'boolean',
                'weight' => $weight,
                'question_group_id' => $group->id,
            ]);
        }
    }
}
