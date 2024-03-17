<?php

namespace Database\Seeders;

use App\Models\Domain\Instruction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructions = [
            ['description' => 'Bata no liquidificador 1 banana, os ovos, o leite e o óleo.', 'step' => 1, 'recipes_id' => 1,],
            ['description' => 'Depois, acrescente o açucar e bata mais um pouco.', 'step' => 2, 'recipes_id' => 1,],
            ['description' => 'Em uma vasilha coloque a farinha de trigo, a aveia e o fermento e acrescente a mistura do liquidificador, mexendo bem com uma colher de pau.', 'step' => 3, 'recipes_id' => 1,],
            ['description' => 'Em uma forma média quadrada, untada e enfarinhada, coloque metade da massa, as 5 bananas restantes cortadas em rodelas finas e salpique a canela.', 'step' => 4, 'recipes_id' => 1,],
            ['description' => 'Coloque o restante da massa e leve ao forno quente.', 'step' => 5, 'recipes_id' => 1,],
            ['description' => 'Unte um refratário com margarina.', 'step' => 1, 'recipes_id' => 2,],
            ['description' => 'Forre o fundo com 6 fatias de pão de forma.', 'step' => 2, 'recipes_id' => 2,],
            ['description' => 'Colocar metade do molho de tomate temperado, presunto, camada de requeijão, metade da mussarela, restante do pão de forma, molho de tomate, creme de leite, mussarela, tomate em rodelas, orégano.', 'step' => 3, 'recipes_id' => 2,],
            ['description' => 'Leve o refratário ao forno até a mussarela derreter (fiz no micro-ondas)', 'step' => 4, 'recipes_id' => 2,],
            ['description' => 'Coloque todos os ingredientes em um prato e misture-os até que fiquem homogêneos.', 'step' => 1, 'recipes_id' => 3,],
            ['description' => 'Depois, aqueça um pouquinho uma frigideira sem óleo, sem azeite e sem manteiga, somente a frigideira e logo após coloque a massa.', 'step' => 2, 'recipes_id' => 3,],
            ['description' => 'Espere um tempo até que ela fique um pouco douradinha embaixo, se preferir virar a crepioca, vire-a com a ajuda de uma colher ou garfo.', 'step' => 3, 'recipes_id' => 3,],
            ['description' => 'Ou coloque uma tampa que cubra toda a frigideira e espere ela cozinhar até o ponto do seu gosto, mais queimadinho ou mais branquinho.', 'step' => 4, 'recipes_id' => 3,],
        ];

        foreach ($instructions as $instruction) {
            Instruction::create($instruction);
        }
    }
}
