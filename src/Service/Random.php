<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProjectRepository;

class Random
{

    private $em;
    private $repository;

    public function __construct(EntityManagerInterFace $em, ProjectRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function getProjects()
    {
        return $this->repository->findAll();
    }

    public function getInt(int $min = 0, int $max = 100): int
    {
        return random_int($min, $max);
    }
}
