<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InventoryService
{
  public function stockIn(
    Product $product,
    int $qty,
    ?string $notes = null
  ): StockMovement {
    $before = $product->stock;

    $product->increment('stock', $qty, []);

    return StockMovement::create([
      'product_id' => $product->id,
      'type' => 'IN',
      'quantity' => $qty,
      'stock_before' => $before,
      'stock_after' => $before + $qty,
      'notes' => $notes,
      'created_by' => Auth::id(),
    ]);
  }

  public function stockOut(
    Product $product,
    int $qty,
    ?string $notes = null
  ): StockMovement {
    if ($product->stock < $qty) {
      throw ValidationException::withMessages([
        'quantity' => 'Stok tidak mencukupi'
      ]);
    }

    $before = $product->stock;

    $product->decrement('stock', $qty, []);

    return StockMovement::create([
      'product_id' => $product->id,
      'type' => 'OUT',
      'quantity' => $qty,
      'stock_before' => $before,
      'stock_after' => $before - $qty,
      'notes' => $notes,
      'created_by' => Auth::id(),
    ]);
  }

  public function adjustment(
    Product $product,
    int $newStock,
    ?string $notes = null
  ): StockMovement {

    $before = $product->stock;

    $product->update([
      'stock' => $newStock,
    ]);

    return StockMovement::create([
      'product_id' => $product->id,
      'type' => 'ADJUSTMENT',
      'quantity' => $newStock,
      'stock_before' => $before,
      'stock_after' => $newStock,
      'notes' => $notes,
      'created_by' => Auth::id(),
    ]);
  }
}
