<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function approve($id)
    {
        $request = \App\Models\Request::findOrFail($id);
        if ($request->type == "discount_override") {
            $quote = $request->quote;
            $quote->update([
               'discount' => $request->data[0]['discount_overrride'],
               'discount_override' => 0.00,
               'discount_override_note' => null,
            ]);
            $request->update([
                'status' => 'approved'
            ]);
        }
        return redirect()->back();
    }

    public function reject($id)
    {
        $request = \App\Models\Request::findOrFail($id);
        if ($request->type == "discount_override") {
            $quote = $request->quote;
            $quote->update([
                'discount_override' => 0.00,
                'discount_override_note' => null,
            ]);
            $request->update([
                'status' => 'rejected'
            ]);
        }
        return redirect()->back();
    }
}
