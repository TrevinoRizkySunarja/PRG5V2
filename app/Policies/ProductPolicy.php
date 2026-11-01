<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        return $product->user_id !== null && (int) $product->user_id === (int) $user->getKey();
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->update($user, $product);
    }
}
