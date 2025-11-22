<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AddProductComponent;
use App\Livewire\AdminOverview;
use App\Livewire\BrowseProductsComponent;
use App\Livewire\CartComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\OrderManagementComponent;
use App\Livewire\ProductManagementComponent;
use App\Livewire\SingleProductComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\AddUpcomingStock;
use App\Livewire\Admin\CustomerList;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChatController;
use App\Livewire\UpcomingStockList;
use App\Livewire\SearchResults;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;






// Age Verification Page
Route::get('/age-verify', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('auth.age-verify');
})->name('age.verify')->middleware('auth');

// Age Verification Submit

Route::post('/age-verify', function (Request $request) {
    $user = Auth::user();
    $user->is_verified_age = true;
    $user->save();


    

    return redirect()->route('dashboard')
        ->with('message', '🎉 Welcome! You are now verified as 18+');
})->name('age.verify.submit')->middleware('auth');



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('message', '✅ Successfully logged out!');
})->name('logout');




Route::prefix('sales')->group(function () {
    Route::get('/weekly', [SalesController::class, 'weekly'])->name('sales.weekly');
    Route::get('/monthly', [SalesController::class, 'monthly'])->name('sales.monthly');
    Route::get('/yearly', [SalesController::class, 'yearly'])->name('sales.yearly');
});



Route::get('/search-results', SearchResults::class)->name('search.results');


Route::get('/my-orders', \App\Livewire\UserOrders::class)
    ->name('user.orders')
    ->middleware('auth');


Route::get('/upcoming-stock', UpcomingStockList::class)->name('upcoming.stock');


// User chat
Route::middleware(['auth','rolemanager:customer'])->group(function () {
    Route::get('/chat', [ChatController::class, 'userChat'])->name('user.chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('user.chat.send');
});

// Admin chat
Route::middleware(['auth','rolemanager:admin'])->group(function () {
    Route::get('/admin/chat', [ChatController::class, 'adminChat'])->name('admin.chat');
    Route::get('/admin/chat/messages/{user}', [ChatController::class, 'getUserMessages']);
    Route::post('/admin/chat/send', [ChatController::class, 'sendMessage'])->name('admin.chat.send');
});





Route::middleware(['auth', 'rolemanager:admin'])->group(function () {
    Route::get('/admin/profile/update', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});



Route::get('/admin/customers', CustomerList::class)->name('admin.customers');


Route::get('/', function () {
    return view('welcome');
    
});

// Customer dashboard
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::middleware(['auth', 'verified','rolemanager:admin'])->group(function () {

    Route::get('/admin/dashboard', AdminOverview::class)->name('admin.dashboard');

    Route::get('/admin/categories', CategoryComponent::class)->name('admin.categories');

    Route::get('/admin/add-product', AddProductComponent::class)->name('admin.add-product');

    Route::get('/admin/upcoming-stocks', AddUpcomingStock::class)->name('upcoming.stocks');

    Route::get('/admin/orders', OrderManagementComponent::class)->name('admin.orders');
});



Route::get('/', BrowseProductsComponent::class)->name('products.browse');

Route::get('/product/{id}', SingleProductComponent::class)->name('product.show');

Route::get('/category/{id}', [CategoryController::class, 'index'])->name('category.show');

Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function(){

    Route::get('/cart', CartComponent::class)->name('cart');
});




Route::get('/privacy-policy', function () {
    return view('privacy_policy');
})->name('privacy.policy');


Route::get('/cookie-policy', function () {
    return view('cookie_policy');
})->name('cookie.policy');


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);



Route::get("auth/google", [GoogleController::class, "redirectToGoogle"])->name("redirect.google");
Route::get("auth/google/callback", [GoogleController::class, "handleGoogleCallback"]);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
