<?php

namespace App\Repositories\Contracts;

use App\DTO\Orders\CreateOrderDTO;
use App\DTO\Orders\UpdateOrderDTO;
use stdClass;

interface OrderRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null, string $data_start = null, string $data_end = null): array;
    public function getAllUser(): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateOrderDTO $dto): stdClass;
    public function update(UpdateOrderDTO $dto): stdClass|null;
}
