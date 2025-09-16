<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sort = request()->get('sort', 'desc');
        $transaction = Transaction::with(['product', 'user',])
            ->orderBy('created_at', $sort)
            ->paginate(20);
            

        return response()->json($transaction);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
       $userId = auth()->id();

       return DB::transaction(function () use ($request, $userId) {
        $data = $request->only([
            'product_id',
            'type',
            'quantity',
        ]);

        $product = Product::lockForUpdate()->findOrFail($data['product_id']);

        $prevStock = $product->stock;
        $qty = $data['quantity'];

        if ($data['type'] === 'out' && $qty > $prevStock) {
            return response()->json([
                'message' => 'Insufficient stock for this transaction.',
                'error' => ['quantity' => 'Insufficient stock available.']
            ], 422);
        }

        $newStock = $data['type'] === 'in' ? $prevStock + $qty : $prevStock - $qty;

        $product->stock = $newStock;
        $product->save();

        $transaction = Transaction::create([
            'product_id' => $data['product_id'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'created_by' => $userId,
            'prev_stock' => $prevStock,
            'new_stock' => $newStock,
            'note' => $data['note'] ?? null,
        ]);
        $transaction->load('product', 'user');

        return response()->json([
            'message' => 'Transaction created successfully.',
            'data' => $transaction
        ], 201);
       });
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return $transaction;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction, $id)
    {
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
