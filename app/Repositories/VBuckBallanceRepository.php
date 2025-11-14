<?php

namespace App\Repositories;
use App\Models\VBuckBallance;

class VBuckBallanceRepository
{
    public function create(array $data): VBuckBallance
    {
        return VBuckBallance::create($data);
    }

    public function userTotalVBucks(int $userId): int
    {
        return VBuckBallance::where('user_id', $userId)->sum("value");
    }

    public function userVBuckBallance(int $userId)
    {
        return VBuckBallance::where('user_id', $userId)->paginate();
    }
}
