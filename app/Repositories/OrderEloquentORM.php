<?php

namespace App\Repositories;

use App\DTO\Orders\CreateOrderDTO;
use App\DTO\Orders\UpdateOrderDTO;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use stdClass;

class OrderEloquentORM implements OrderRepositoryInterface
{
    public function __construct(
        protected Order $model,
        protected User $modeluser
    ) {}
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $result = $this->model
            ->paginate($totalPerPage, ['*'], 'page', $page);
        return new PaginationPresenter($result);
    }
    public function findOne(string $id): stdClass | null
    {
        $order = $this->model->find($id);
        if (!$order) {
            return null;
        }
        return (object) $order->toArray();
    }
    public function getAll(string $filter = null, string $data_going = null, string $data_back = null): array
    {
        return $this->model
            ->where(function ($query) use ($data_going, $data_back) {
                if ($data_going and $data_back) {
                    $query->whereBetween('going_date', [$data_going, $data_back]);
                    $query->orwhereBetween('back_date', [$data_going, $data_back]);
                }
            })
            ->get()
            ->toArray();
    }
    public function getAllUser(): array
    {
        return $this->modeluser
            ->get()
            ->toArray();
    }
    public function delete(string $id): void
    {
        $order = $this->model->findOrFail($id);

        $order->delete();
    }
    public function new(CreateOrderDTO $dto): stdClass
    {
        $order =  $this->model->create((array) $dto);
        return (object) $order->toArray();
    }
    public function update(UpdateOrderDTO $dto): stdClass|null
    {
        if (!$order = $this->model->find($dto->id)) {
            return null;
        }

        $order->update((array) $dto);
        return (object) $order->toArray();
    }
}
