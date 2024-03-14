<?

namespace App\Repositories;

use App\Models\Domain\Instruction;

class InstructionRepository
{
    public function store(array $data): ?Instruction
    {
        return Instruction::create($data);
    }
}