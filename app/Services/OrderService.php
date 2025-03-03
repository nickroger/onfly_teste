<?php

namespace App\Services;

use App\DTO\Orders\CreateOrderDTO;
use App\DTO\Orders\UpdateOrderDTO;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use stdClass;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $repository,
    ) {}

    public function paginate(
        int $page = 1,
        int $totalPerPage = 15
    ): PaginationInterface {
        return $this->repository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
        );
    }

    public function getAll(string $filter = null, string $data_start = null, string $data_end = null): array
    {
        return $this->repository->getAll($filter, $data_start, $data_end);
    }
    public function getAllUser(string $filter = null): array
    {
        return $this->repository->getAllUser($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateOrderDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }

    public function update(UpdateOrderDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
