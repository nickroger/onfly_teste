<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Orders\CreateOrderDTO;
use App\DTO\Orders\UpdateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class OrderController extends Controller
{
    public function __construct(
        protected OrderService $order
    ) {}
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     security={{"token": {}}},
     *     summary="List all Orders",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="show result according to page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="An paged array of orders",
     *         @OA\Header(header="x-next", @OA\Schema(type="string"), description="A link to the next page of responses")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $orders = $this->order->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 2),
        );

        return ApiAdapter::toJson($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/orders",
     *     security={{"token": {}}},
     *     summary="Create Order",
     *     tags={"Orders"},
     *   @OA\Parameter(
     *      name="destiny",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="going_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="back_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="id_user",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="An paged array of orders",
     *         @OA\Header(header="x-next", @OA\Schema(type="string"), description="A link to the next page of responses")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function store(StoreUpdateOrderRequest $request)
    {
        $order = $this->order->new(
            CreateOrderDTO::makeFromRequest($request)
        );
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     security={{"token": {}}},
     *     summary="List orders based by ID",
     *     description="Returns a order based on a single ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         description="ID of order",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="order response",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *     )
     * )
     */
    public function show(string $id)
    {
        if (!$order = $this->order->findOne($id)) {
            return response()->json([
                'error' => "Not Found"
            ], Response::HTTP_NOT_FOUND);
        }
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/orders",
     *     security={{"token": {}}},
     *     summary="Update Order",
     *     tags={"Orders"},
     *   @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="destiny",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="going_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="back_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          format="date"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="id_user",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="number"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="An paged array of orders",
     *         @OA\Header(header="x-next", @OA\Schema(type="string"), description="A link to the next page of responses")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function update(StoreUpdateOrderRequest $request, string $id)
    {
        if (!$order = $this->order->update(
            UpdateOrderDTO::makeFromRequest($request, $id)
        )) {
            return response()->json([
                'error' => "Not Found"
            ], Response::HTTP_NOT_FOUND);
        }
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     security={{"token": {}}},
     *     summary="Delete order based by id",
     *     description="deletes a single order based on the ID",
     *     operationId="deletePet",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         description="ID of order to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="order deleted"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *     )
     * )
     */
    public function destroy(string $id)
    {
        if (!$this->order->findOne($id)) {
            return response()->json([
                'error' => "Not Found"
            ], Response::HTTP_NOT_FOUND);
        }
        $this->order->delete($id);

        return response()->json([
            'message' => 'Order deleted'
        ], Response::HTTP_NO_CONTENT);
    }
}
