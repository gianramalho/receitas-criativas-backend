<?php

namespace App\Repositories;

use App\Models\Domain\Instruction;

interface InstructionRepositoryInterface
{
    public function store(array $data): ?Instruction;
}
