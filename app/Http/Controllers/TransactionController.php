<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Transaction;
use App\Models\User;
use App\Events\TransactionReceived;
use Exception;

class TransactionController extends Controller
{
    /**
    * TransactionController constructor.
    * @param Transaction $transaction
    */
    public function __construct(Transaction $transaction)
    {
      $this->transaction = $transaction;
    }

    /**
    * Responds to a GET request into
    * /transaction endpoint with all transactions
    *
    * @return JsonResponse
    */
    public function index(): JsonResponse
    {
        $transaction = $this->transaction->all();
        return response()->json($transaction);
    }

    /**
    * Responds to a GET request into
    * /transaction/{id} endpoint with the
    * respective transaction
    *
    * @return JsonResponse
    * @param Int $id
    */
    public function show($id): JsonResponse
    {
        try{
            $transaction = $this->transaction->findOrFail($id);
            return response()->json($transaction);

        }catch(Exception $e) {

            return response()->json(
                ['error' => 'The requested resource does not exist.'],
                JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
    * Handle a POST request into
    * /transaction endpoint
    *
    * @return JsonResponse
    * @param Request $request
    */
    public function store(Request $request): JsonResponse
    {
        $this->transaction->payer();
        $payerId = $request->payer_id;
        $payeeId = $request->payee_id;
        $value = $request->value;

        $pendingTransaction = $request->validate(
            $this->transaction->rules(),
            $this->transaction->feedback()
        );

        if ( $this->transaction->authorizePayerType($payerId) ) {

            $pendingTransaction = $this->transaction
                ->create($pendingTransaction);

            if( $this->transaction->authorizeBalance($payerId, $value, $pendingTransaction) ) {
                $this->transaction->beginTransaction($payerId, $payeeId, $value);

                if( $this->transaction->authorizeExternalService($pendingTransaction) ) {
                    event(new TransactionReceived($this->transaction->getPayeeUser($payeeId)));
                    return response()->json(
                        ['ok' => 'Successful operation'],
                        JsonResponse::HTTP_OK
                    );
                }else {
                    $this->transaction->revertTransaction($payerId, $payeeId, $value);
                    return response()->json(
                        ['error' => 'Non authorized by external service'],
                        JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                    );
                }
            }
            return response()->json(
                ['error' => 'Unable to process payment: Low card balance'],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        return response()->json(
            ['error' => 'This type of user cannot make transactions'],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
