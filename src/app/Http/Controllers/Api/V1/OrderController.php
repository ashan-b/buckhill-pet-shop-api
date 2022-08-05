<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrderController\OrderCreateRequest;
use App\Http\Requests\Api\V1\OrderController\OrderIndexRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $desc === true ? 'DESC' : 'ASC'
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
     *                     description="Order status UUID",
     *                      example="41c92f2b-2d6d-34e3-a792-9e80d3ae4bc3"
     *                 ),
     *                 @OA\Property(
     *                     property="payment_uuid",
     *                     type="string",
     *                     description="Payment UUID",
     *                      example="ca149cd3-dc20-3bd9-a7c7-e7ac34b38020"
     *                 ),
     *                 @OA\Property(
     *                      property="products",
     *                      type="array",
     *                      description="Array of objects with product uuid and quantity",
     *                      @OA\Items(
     *                              @OA\Property(property="uuid", type="string", example="2a6eacf2-7c97-3519-976d-a7989d7b138d"),
     *                              @OA\Property(property="quantity", type="integer", example=1)
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
        $products = $request->get('products');
        $address = $request->get('address');
        $order_status_uuid = $request->get('order_status_uuid');
        $payment_uuid = $request->get('payment_uuid');

        $products = json_decode('[' . $products . ']');
        $address = json_decode($address);

        $successArray = [];
        $errorArray = [];
        $orderTotal = 0;

        //Validation
        foreach ($products as $product) {
            if (!property_exists($product, 'uuid')) {
                $error = [
                    "product" => $product,
                    "error_message" => "Invalid product. Product uuid is required.",
                ];
                array_push($errorArray, $error);
            }
            if (!property_exists($product, 'quantity')) {
                $error = [
                    "product" => $product,
                    "error_message" => "Invalid product. Product quantity is required.",
                ];
                array_push($errorArray, $error);
            }

            $loadedProduct = Product::where("uuid", $product->uuid)->first();

            if ($loadedProduct === null) {
                $error = [
                    "product" => $product,
                    "error_message" => "Invalid product.",
                ];
                array_push($errorArray, $error);
            }

            if (is_numeric($product->quantity) === false) {
                $error = [
                    "product" => $product,
                    "error_message" => "Quantity must numeric.",
                ];
                array_push($errorArray, $error);
            }

            if (fmod($product->quantity, 1) !== 0.00) {
                //Don't allow decimal.
                $error = [
                    "product" => $product,
                    "error_message" => "Quantity must be integer.",
                ];
                array_push($errorArray, $error);
            }

            if ($product->quantity < 1) {
                $error = [
                    "product" => $product,
                    "error_message" => "Quantity must be greater than 0.",
                ];
                array_push($errorArray, $error);
            }

            if ($loadedProduct !== null) {
                $lineTotal = round($loadedProduct->price * $product->quantity, 2);

                $updatedProduct = [
                    "uuid" => $loadedProduct->uuid,
                    "price" => $loadedProduct->price,
                    "product" => $loadedProduct->title,
                    "quantity" => $product->quantity,
                    "total" => $lineTotal,
                ];
                array_push($successArray, $updatedProduct);

                $orderTotal += $lineTotal;
            }
        }

        if (!property_exists($address, 'billing')) {
            $error = [
                "address" => $address,
                "error_message" => "The address.billing field is required.",
            ];
            array_push($errorArray, $error);
        }

        if (!property_exists($address, 'shipping')) {
            $error = [
                "address" => $address,
                "error_message" => "The address.shipping field is required.",
            ];
            array_push($errorArray, $error);
        }

        //Check if payment has been already used
        $payment = Payment::where("uuid", $payment_uuid)->first();
        if ($payment->order !== null) {
            $error = [
                "payment" => $payment,
                "error_message" => "This payment belongs to another order.",
            ];
            array_push($errorArray, $error);
        }

        if (!empty($errorArray)) {
            return $this->sendError("Validation Error", $errorArray, [], 422);
        }

        $order = new Order();
        $order->user_uuid = $this->getUserUuid($request);
        //Validate against state machine. Initial order status will be assigned
        $order->setGraph("main_graph");
        $order->products = $successArray;
        $order->address = $address;
        //User story: If the  total amount is higher than 500 free delivery.Else 15
        $order->delivery_fee = $orderTotal > 500 ? 0 : 15;
        $order->amount = $orderTotal;

        $order->payment_uuid = $payment_uuid;

        // Using state machine to change the state.
        // $order->order_status_uuid will be automatically assigned through state machine.
        if ($order->canChangeStateByPrimaryKey($order_status_uuid) === true) {
            $order->changeCurrentStateByStatePrimaryKey($order_status_uuid);
        }
        $order->save();

        return $this->sendSuccess(["order" => $order]);
    }

    public function testState(): void
    {
//        $order = new Order;
//        $order->setGraph("main_graph");
//        dd($order->getCurrentState());
//        $order->setCurrentStateByStatePrimaryKey("8fe0053a-6bbe-34e7-820f-19812a6e62e5");
//        dd($value);

        $order = Order::find(1);
//        $order->uuid="123";

//        $order->setGraph($manage);
        $filename = "main_graph";
        $order->setGraph($filename);
        $order->setCurrentStateByStatePrimaryKey("canc");
        $order->save();
//        dd($order->getCurrentState());
//        dd($order->getNextTransitions());
//        dd($order->can('state_0_to_state_1'));
//        $order->process('state_0_to_state_2');
//        $order->process('paid_to_shipped');

//        dd($order->getCurrentState());
//
        ////dd($order->order_status_state);
        ////dd($order->order_status_id);
//        $order->products = ["UUID" => "123"];
//        $order->address = ["address" => "123"];
//        $order->amount = 100;
//        $order->user_id = 1;
//        $order->payment_id = null;
        ////        $order->save();
//        $order->setCurrentStateByStateTitle("canceled");
//        dd($order->getCurrentState());
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
    public function download($uuid)
    {
        $order = Order::where('uuid', $uuid)->first();
        if ($order === null) {
            return $this->sendError("Not found.", [], [], 404);
        }
        $pdf = Pdf::loadView('api.v1.order.invoice', ['order' => $order]);
        return $pdf->download('order_' . $order->uuid . '.pdf');
    }
}
