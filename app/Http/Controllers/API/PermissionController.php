<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'role' => $user->role,
            'permissions' => [
                'manage_product' => $user->can('create', Product::class),
                'manage_category' => $user->can('create', Category::class),
                'manage_transaction' => $user->can('create', Transaction::class),
            ]
        ]);
    }
}
