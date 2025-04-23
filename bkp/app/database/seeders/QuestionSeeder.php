<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            ['text' => 'Sensação de morte iminente ou pânico', 'type' => 'scale'],
            ['text' => 'Medo Intenso', 'type' => 'scale'],
            ['text' => 'Desrealização', 'type' => 'scale'],
            ['text' => 'Despersonalização', 'type' => 'scale'],
            ['text' => 'Crises conversivas', 'type' => 'scale'],
            ['text' => 'Crises dissociativas', 'type' => 'scale'],
            ['text' => 'Queixas somáticas persistentes ou hipocondríacas', 'type' => 'scale'],
            ['text' => 'Pensamentos ou comportamentos repetitivos', 'type' => 'scale'],
            ['text' => 'Pensamento de inutilidade ou culpa', 'type' => 'scale'],
            ['text' => 'Ideia suicida ou tentativa de suicídio', 'type' => 'scale'],
            ['text' => 'Isolamento social', 'type' => 'scale'],
            ['text' => 'Auto agressividade com o corpo ou terceiros', 'type' => 'scale'],
            ['text' => 'Desinibição social ou sexual', 'type' => 'scale'],
            ['text' => 'Atos impulsivos ou hiperatividade', 'type' => 'scale'],
            ['text' => 'Euforia', 'type' => 'scale'],
            ['text' => 'Elevação desproporcional de autoestima', 'type' => 'scale'],
            ['text' => 'Delírio', 'type' => 'scale'],
            ['text' => 'Alucinação', 'type' => 'scale'],
            ['text' => 'Alteração do curso de pensamento', 'type' => 'scale'],
            ['text' => 'Perda do juízo crítico da realidade', 'type' => 'scale'],
            ['text' => 'Delírio e tremor', 'type' => 'scale'],
            ['text' => 'Tremor associado ao hálito etílico e sudorese etílica', 'type' => 'scale'],
            ['text' => 'Incapacidade de redução e controle do uso de drogas', 'type' => 'scale'],
            ['text' => 'Manifestação de risco para si e para terceiros', 'type' => 'scale'],
            ['text' => 'Intolerância', 'type' => 'scale'],
            ['text' => 'Dificuldade manifestada na infância ou adolescência de compreender e transmitir informações', 'type' => 'scale'],
            ['text' => 'Movimentos corporais ou comportamentais estereotipados', 'type' => 'scale'],
            ['text' => 'Desatenção manifestada na infância ou adolescência', 'type' => 'scale'],
            ['text' => 'Inquietação constante manifestada na infância ou adolescência', 'type' => 'scale'],
            ['text' => 'Regressão', 'type' => 'scale'],
            ['text' => 'Perda de memória', 'type' => 'scale'],
            ['text' => 'Perda de capacidade ocupacional', 'type' => 'scale'],
            ['text' => 'Desorientação temporal ou de espaço', 'type' => 'scale'],
            ['text' => 'Resistência ao tratamento', 'type' => 'scale'],
            ['text' => 'Recorrência ou recaída', 'type' => 'scale'],
            ['text' => 'Uso de substâncias psicoativas', 'type' => 'scale'],
            ['text' => 'Exposição continuada ao estresse', 'type' => 'scale'],
            ['text' => 'Precariedade de suporte social', 'type' => 'scale'],
            ['text' => 'Precariedade de suporte familiar', 'type' => 'scale'],
            ['text' => 'Testemunha de violência', 'type' => 'scale'],
            ['text' => 'Autor ou vítima de violência', 'type' => 'scale'],
            ['text' => 'Perda de funcionalidade familiar ou afetiva', 'type' => 'scale'],
            ['text' => 'Vulnerabilidade econômica ou ambiental', 'type' => 'scale'],
            ['text' => 'Comorbidades ou outra condição crônica associada', 'type' => 'scale'],
            ['text' => 'Faixa etária >14 e <18', 'type' => 'scale'],
            ['text' => 'Abandono e/ou atraso escolar', 'type' => 'scale'],
        ];

        foreach ($questions as $question) {
            DB::table('questions')->insert([
                'text' => $question['text'],
                'type' => $question['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}