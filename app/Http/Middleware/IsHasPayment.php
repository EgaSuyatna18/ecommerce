<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Payment;

class IsHasPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Payment::where('user_id', $request->user()->id)->where('status', 'pending')->exists()) return redirect('/payment')->withErrors(['You Have Unfinished Payment!']);
        return $next($request);
    }
}
