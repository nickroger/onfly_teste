<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Orders\CreateOrderDTO;
use App\DTO\Orders\UpdateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $order
    ) {}
    public function index(Request $request)
    {
        $orders = $this->order->getAll(
            data_start: $request->going_date,
            data_end: $request->back_date
        );
        return view('orders.index', compact('orders'));
    }
    public function create(User $user)
    {
        $users = $this->order->getAllUser();
        return view('orders.create', compact('users'));
    }

    public function store(StoreUpdateOrderRequest $request, Order $order)
    {
        $this->order->new(CreateOrderDTO::makeFromRequest($request));
        return redirect()
            ->route('orders.index')
            ->with('message', 'Cadastrado com sucesso!');
    }
    public function show(string $id)
    {
        if (!$this->order->findOne($id)) {
            return back();
        }
        $order = $this->order->findOne($id);
        return view('orders.show', compact('order'));
    }
    public function edit(string $id, User $user)
    {
        if (!$this->order->findOne($id)) {
            return back();
        }
        $order = $this->order->findOne($id);

        $users = $this->order->getAllUser();
        return view('orders.edit', compact('order', 'users'));
    }
    public function update(StoreUpdateOrderRequest $request, Order $order, string $id)
    {
        $product = $this->order->update(UpdateOrderDTO::makeFromRequest($request));
        if (!$product) {
            return back();
        }
        return redirect()
            ->route('orders.index')
            ->with('message', 'Atualizado com sucesso!');
    }
    public function destroy(string $id)
    {
        $this->order->delete($id);
        return redirect()
            ->route('orders.index')
            ->with('message', 'Deletado com sucesso!');
    }
}
