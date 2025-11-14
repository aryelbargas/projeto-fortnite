<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\VBuckBallanceRepository;

class UserService
{

    public function __construct(
        private UserRepository $userRepository,
        private VBuckBallanceRepository $vBuckBallanceRepository
    ) {}

    public function create(array $data) 
    {
        $user = $this->userRepository->create($data);
        $this->vBuckBallanceRepository->create(
            [
                "value" => 10000,
                "description" => 'Criou a conta.',
                "user_id" => $user->id
            ]
        );

        return $user;
    }

    public function findByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function userTotalVBucks(int $userId): int
    {
        return $this->vBuckBallanceRepository->userTotalVBucks($userId);
    }

    public function userVBuckBallance(int $userId)
    {
        return $this->vBuckBallanceRepository->userVBuckBallance($userId);
    }
}