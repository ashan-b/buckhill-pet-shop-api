<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrderController\OrderCreateRequest;
use App\Http\Requests\Api\V1\OrderController\OrderIndexRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use JwtTokenHelper;
    use ResponseGenerator;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Tag(
     *     name="Orders",
     *     description="Orders API endpoint"
     * )
     *
     * @OA\Get(
     *     path="/api/v1/orders",
     *     summary="List all orders",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     * @OA\Parameter(
     *     in="query",
     *     name="page",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *   @OA\Parameter(
     *     in="query",
     *     name="limit",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *     @OA\Parameter(
     *     in="query",
     *     name="sortBy",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *     @OA\Parameter(
     *     in="query",
     *     name="desc",
     *      @OA\Schema(
     *          type="boolean"
     *      )
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index(OrderIndexRequest $request)
    {
        $limit = $request->get('limit', 15);
        $sortBy = $request->get('sortBy', 'id');
        $desc = $request->boolean('desc', false);

        $orders = Order::with(['user', 'orderStatus', 'payment'])->orderBy(
            $sortBy,
            $desc == true ? 'DESC' : 'ASC'
        )->paginate($limit);

        return $this->sendSuccess($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    /**
     *
     * @OA\Post(
     *     path="/api/v1/order/create",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *     required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"order_status_uuid","products","address"},
     *                 @OA\Property(
     *                     property="order_status_uuid",
     *                     type="string",
     *                     description="Order status UUID"
     *                 ),
     *                 @OA\Property(
     *                     property="payment_uuid",
     *                     type="string",
     *                     description="Payment UUID"
     *                 ),
     *                 @OA\Property(
     *                      property="products",
     *                      type="array",
     *                      description="Array of objects with product uuid and quantity",
     *                      @OA\Items(
     *                              @OA\Property(property="uuid", type="string"),
     *                              @OA\Property(property="quantity", type="integer")
     *                              ),
     *                  ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="object",
     *                     description="Billing and Shipping address",
     *                      @OA\Property(property="billing", type="string"),
     *                      @OA\Property(property="shipping", type="string"),
     *                 ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(OrderCreateRequest $request)
    {
        $user_uuid = $this->getUserUuid($request);

        $order = Order::create(
            [
                'uuid' => Str::uuid()->toString(),
                'order_status_uuid' => $request->order_status_uuid,
                'payment_uuid' => $request->payment_uuid,
                'products' => $request->products,
                'address' => $request->address,
                'user_uuid' => $user_uuid,
                'amount'=>0
            ]
        );

        return $this->sendSuccess(["order" => $order]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function testState(\Illuminate\Http\Request $request)
    {
        $order = new Order;
//        $order = Order::find(1);
//        $order->uuid="123";

//        $order->setGraph($manage);
        $filename = "main_graph";
        $order->setGraph($filename);
//        dd($order->getCurrentState());
//        dd($order->getNextTransitions());
//        dd($order->can('state_0_to_state_1'));
//        $order->process('state_0_to_state_2');
//
////dd($order->order_status_state);
////dd($order->order_status_id);
//        $order->products = ["UUID" => "123"];
//        $order->address = ["address" => "123"];
//        $order->amount = 100;
//        $order->user_id = 1;
//        $order->payment_id = null;
//        $order->save();
        $order->setCurrentStateByStateTitle("canceled");
        dd($order->getCurrentState());
//$order->setOrderStatusState("state_1");
//        $order->setConfig($config);
//        $order->setObject($order);
//
////        dd($order->getState());
////        dd($order->apply("state_1"));
//        dd($order->can("state_1"));
    }

    /**
    * @OA\Get(
    *     path="/api/v1/order/{uuid}/download",
    *     summary="Download a order",
    *     tags={"Orders"},
    *     security={{"bearerAuth":{}}},
     * @OA\Parameter(
     *     in="path",
     *     name="uuid",
     *     required=true,
     *     @OA\Examples(example="Order paid with credit card.", value="edb8e045-650c-3225-a27c-f31e7c78a3e4", summary="Order paid with credit card."),
     *     @OA\Examples(example="Order paid with bank transfer.", value="7c691a23-44a0-35c8-a040-f08f2dd5de1a", summary="Order paid with bank transfer."),
     *
     *      @OA\Schema(
     *          type="string"
    *      )
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
    *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
    *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
    *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
    *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
    *     )
     * )
     */
    public function download(Request $request, $uuid)
    {
        $order = Order::where('uuid',$uuid)->first();
        if($order==null){
            return $this->sendError("Not found.",[],[],404);
        }
        $pdf = Pdf::loadView('api.v1.order.invoice', ['order'=>$order]);
        return $pdf->download('order_'.$order->uuid.'.pdf');
    }
}
