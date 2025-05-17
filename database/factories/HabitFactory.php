<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habit>
 */
class HabitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $habits = [
            'Acordar cedo',
            'Beber água',
            'Praticar exercícios',
            'Ler um livro',
            'Meditar',
            'Estudar programação',
            'Evitar açúcar',
            'Dormir 8 horas por noite',
            'Escrever no diário',
            'Planejar o dia',
            'Beber 2 litros de água por dia',
            'Evitar alimentos processados',
            'Comer frutas diariamente',
            'Fazer alongamento pela manhã',
            'Tomar sol por 15 minutos',
            'Focar em uma tarefa por vez',
            'Evitar redes sociais durante o trabalho',
            'Fazer pausas a cada 90 minutos',
            'Revisar as metas da semana',
            'Organizar a mesa de trabalho',
            'Agradecer por 3 coisas diariamente',
            'Aprender uma palavra nova em outro idioma',
            'Limitar o tempo de tela à noite',
            'Fazer uma caminhada após o almoço',
            'Checar e responder e-mails em horários definidos',
            'Evitar multitarefas',
            'Revisar o orçamento pessoal',
            'Lavar a louça após as refeições',
            'Separar roupas para doação',
            'Praticar um hobby por 30 minutos'
        ];

        return [
            'user_id' => User::factory(),
            'uuid' => fake()->uuid(),
            'name' => fake()->randomElement($habits),
        ];
    }
}
