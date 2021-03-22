<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
    public function render()
    {
        return ["errors:" => "No permission for this operation. Product does not belong to you."];
    }
}
