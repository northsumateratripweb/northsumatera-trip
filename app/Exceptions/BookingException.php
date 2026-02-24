<?php

namespace App\Exceptions;

use Exception;

class BookingException extends Exception
{
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => $this->getMessage(),
                'status' => 'error'
            ], 400);
        }

        return back()->with('error', $this->getMessage())->withInput();
    }
}
