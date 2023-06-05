<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    CategoryController,
    ReportController,
    ProductController,
    MemberController,
    SpendingController,
    PurchaseController,
    PurchaseDetailController,
    SellController,
    SellDetailController,
    SettingController,
    SupplierController,
    UserController,
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/personal.page', function() {
    return view('personalpage');
})->name('personal.page');

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function(){
//     return view('home');
// })->name('dashboard');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
        Route::resource('/category', CategoryController::class);

        Route::group(['as'=>'product.','prefix'=>'product','controller'=>ProductController::class],function(){
            Route::get('data','data')->name('data');
            Route::post('delete-selected','deleteSelected')->name('delete_selected');
            Route::post('print-barcode','printBarcode')->name('print_barcode');
        });
        Route::resource('/product', ProductController::class);

        Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
        Route::post('/member/print-member', [MemberController::class, 'printMember'])->name('member.print_member');
        Route::resource('/member', MemberController::class);
        
        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);

        Route::get('/spending/data', [SpendingController::class, 'data'])->name('spending.data');
        Route::resource('/spending', SpendingController::class);

        Route::get('/purchase/data', [PurchaseController::class, 'data'])->name('purchase.data');
        Route::get('/purchase/{id}/create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::resource('/purchase', PurchaseController::class)->except('create');

        Route::get('/purchase_detail/{id}/data', [PurchaseDetailController::class, 'data'])->name('purchase_detail.data');
        Route::get('/purchase_detail/loadform/{diskon}/{total}/{cost}', [PurchaseDetailController::class, 'loadForm'])->name('purchase_detail.load_form');
        Route::resource('/purchase_detail', PurchaseDetailController::class)->except('create', 'show', 'edit');

        Route::get('/sell/data', [SellController::class, 'data'])->name('sell.data');
        Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
        Route::get('/sell/{id}', [SellController::class, 'show'])->name('sell.show');
        Route::delete('/sell/{id}', [SellController::class, 'destroy'])->name('sell.destroy');

    });

    Route::group(['middleware' => 'level:1,2'], function () {
        
        Route::group(['as'=>'transaction.','prefix'=>'/transaction'],function(){
            Route::group(['controller'=>SellController::class],function(){
                Route::get('new', 'create')->name('new');
                Route::post('save', 'store')->name('save');
                Route::get('done', 'done')->name('done');
                Route::get('nota-small', 'notaSmall')->name('nota_small');
                Route::get('nota-big', 'notaBig')->name('nota_big');
            });

            Route::group(['controller'=>SellDetailController::class],function(){
                Route::get('{id}/data','data')->name('data');        
                Route::get('loadform/{diskon}/{total}/{received}/{tax}','loadForm')->name('load_form');
            });
        });
        Route::resource('/transaction', SellDetailController::class)->except('create', 'show', 'edit');
    });

    Route::group(['middleware' => 'level:1'], function () {
        Route::group(['as'=>'report.','controller'=>ReportController::class],function(){
            Route::get('/report','index')->name('index');
            Route::get('/report/data/{begin}/{end}','data')->name('data');
            Route::get('/report/pdf/{begin}/{end}','exportPDF')->name('export_pdf');
        });

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);
        Route::group(['as'=>'setting.','controller'=>SettingController::class],function(){
            Route::get('/setting','index')->name('index');
            Route::get('/setting/first','show')->name('show');
            Route::post('/setting','update')->name('update');
        });
    });
 
    Route::group(['middleware' => 'level:1,2','controller'=>UserController::class,'as'=>'user.'], function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('update_profile');
    });
});
