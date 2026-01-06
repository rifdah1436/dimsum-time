public function about()
{
    $cartCount = auth()->check() ? auth()->user()->cartItems()->count() : 0;
    
    return view('about', [
        'cartCount' => $cartCount
    ]);
}