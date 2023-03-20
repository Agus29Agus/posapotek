Route::group(['middleware' => 'auth'], function () {
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::resource('/category', CategoryController::class);

    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
    Route::post('/product/print-barcode', [ProductController::class, 'printBarcode'])->name('product.print_barcode');
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
    Route::get('/purchase_detail/loadform/{diskon}/{total}', [PurchaseDetailController::class, 'loadForm'])->name('purchase_detail.load_form');
    Route::resource('/purchase_detail', PurchaseDetailController::class)->except('create', 'show', 'edit');

    Route::get('/sell/data', [SellController::class, 'data'])->name('sell.data');
    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::get('/sell/{id}', [SellController::class, 'show'])->name('sell.show');
    Route::delete('/sell/{id}', [SellController::class, 'destroy'])->name('sell.destroy');

    Route::get('/transaction/new', [SellController::class, 'create'])->name('transaction.new');
    Route::post('/transaction/save', [SellController::class, 'store'])->name('transaction.save');
    Route::get('/transaction/done', [SellController::class, 'done'])->name('transaction.done');
    Route::get('/transaction/nota-small', [SellController::class, 'notaSmall'])->name('transaction.nota_small');
    Route::get('/transaction/nota-big', [SellController::class, 'notaBig'])->name('transaction.nota_big');

    Route::get('/transaction/{id}/data', [SellDetailController::class, 'data'])->name('transaction.data');
    Route::get('/transaction/loadform/{diskon}/{total}/{diterima}', [SellDetailController::class, 'loadForm'])->name('transaction.load_form');
    Route::resource('/transaction', SellDetailController::class)->except('create', 'show', 'edit');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/data/{begin}/{end}', [ReportController::class, 'data'])->name('report.data');
    Route::get('/report/pdf/{begin}/{end}', [ReportController::class, 'exportPDF'])->name('report.export_pdf');

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('user.update_profile');
});