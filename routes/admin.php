<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SMSController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Auth\LoginController;
//use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SendSmsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PickupPointController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildcategoryController;



// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/adminlogin', [LoginController::class, 'adminlogin'])->name('admin.login');
Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home')
->middleware('is_admin');


Route::middleware('is_admin')->group(function () {
  Route::get('/admin/home', [AdminController::class, 'admin'])->name('admin.home');
  Route::get('/admin/logout', [AdminController::class, 'adminlogout'])->name('admin.logout');
  Route::get('/admin/password/change', [AdminController::class, 'passwordchange'])->name('admin.password.change');

  Route::post('/admin/password/update', [AdminController::class, 'PasswordUpdate'])->name('admin.password.update');
});

//for category
Route::group(['prefix' => 'category', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');;
    Route::post('/update', [CategoryController::class, 'update'])->name('category.update');

});
//for sub category
Route::group(['prefix' => 'subcategory', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [SubCategoryController::class, 'index'])->name('subcategory.index');
    Route::post('/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
    Route::get('/delete/{id}', [SubCategoryController::class, 'delete'])->name('subcategory.delete');

    Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');;
    Route::post('/update', [SubCategoryController::class, 'update'])->name('subcategory.update');

});

//for childcategory
Route::group(['prefix' => 'Childcategory', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [ChildcategoryController::class, 'index'])->name('childcategory.index');
    Route::post('/store', [ChildcategoryController::class, 'store'])->name('childcategory.store');
    Route::get('/delete/{id}', [ChildcategoryController::class, 'delete'])->name('childcategory.delete');

    Route::get('/edit/{id}', [ChildcategoryController::class, 'edit'])->name('childcategory.edit');;
    Route::post('/update', [ChildcategoryController::class, 'update'])->name('childcategory.update');

});

//for brands
Route::group(['prefix' => 'brand', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [BrandController::class, 'index'])->name('brand.index');
    Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');

    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/update', [BrandController::class, 'update'])->name('brand.update');

    Route::get('/', [BrandController::class, 'brandpdf'])->name('brand-index-pdf');
    Route::get('/removeall', [BrandController::class, 'removeall'])->name('brand.removeall');



});
//for offer coupon
//for coupon
Route::group(['prefix' => 'coupon', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [CouponController::class, 'index'])->name('coupon.index');
    Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::delete('/delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete');

    Route::get('/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::post('/update', [CouponController::class, 'update'])->name('coupon.update');

   // Route::get('/', [CouponController::class, 'couponpdf'])->name('coupon-index-pdf');
   // Route::get('/removeall', [CouponController::class, 'removeall'])->name('coupon.removeall');



});
//for warehouse
Route::group(['prefix' => 'warehouse', 'middleware' => ['is_admin']], function(){
    Route::get('/index', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::post('/store', [WarehouseController::class, 'store'])->name('warehouse.store');
    Route::get('/delete/{id}', [WarehouseController::class, 'delete'])->name('warehouse.delete');

    Route::get('/edit/{id}', [WarehouseController::class, 'edit'])->name('warehouse.edit');
    Route::post('/update', [WarehouseController::class, 'update'])->name('warehouse.update');

});
//get child category for product

Route::get('/getchildcategory/{id}', [ProductController::class, 'getchildcategory'])->name('getchildcategory.product');;
//for Product
Route::group(['prefix' => 'product', 'middleware' => ['is_admin']], function(){
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/index', [ProductController::class, 'index'])->name('product.index');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');;
   //Route::post('/update', [ProductController::class, 'update'])->name('product.update');
   Route::get('/not-featured/{id}', [ProductController::class, 'notfeatured'])->name('notfeature');
   Route::get('/active-featured/{id}', [ProductController::class, 'activefeatured'])->name('activefeatured');

   Route::get('/not-deal/{id}', [ProductController::class, 'notdeal'])->name('notdeal');
   Route::get('/active-deal/{id}', [ProductController::class, 'activedeal'])->name('activedeal');

   Route::get('/not-status/{id}', [ProductController::class, 'notstatus'])->name('notstatus');
   Route::get('/active-status/{id}', [ProductController::class, 'activestatus'])->name('activestatus');


});
//admin setting
Route::group(['prefix' => 'setting', 'middleware' => ['is_admin']], function(){
    //seo setting
    Route::group(['prefix' => 'seo', 'middleware' => ['is_admin']], function(){
        Route::get('/', [SettingController::class, 'seo'])->name('seo.setting');
        Route::post('/update/{id}', [SettingController::class, 'seoUpdate'])->name('seo.setting.update');


    });

    //website setting website.setting
    Route::group(['prefix' => 'website', 'middleware' => ['is_admin']], function(){
        Route::get('/', [SettingController::class, 'website'])->name('website.setting');
        Route::post('/update/{id}', [SettingController::class, 'WebsiteUpdate'])->name('website.setting.update');


    });

        //smtp setting
        Route::group(['prefix' => 'smtp', 'middleware' => ['is_admin']], function(){
            Route::get('/', [SettingController::class, 'smtp'])->name('smtp.setting');
            Route::post('/update/{id}', [SettingController::class, 'smtpUpdate'])->name('smtp.setting.update');


        });

        //page setting
        Route::group(['prefix' => 'page', 'middleware' => ['is_admin']], function(){
            Route::get('/', [PageController::class, 'index'])->name('page.index');
            Route::post('/store', [PageController::class, 'store'])->name('page.store');
            Route::get('/create', [PageController::class, 'create'])->name('page.create');
            Route::get('/delete/{id}', [PageController::class, 'delete'])->name('page.delete');

            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
            Route::post('/update/{id}', [PageController::class, 'update'])->name('page.update');


        });

     //picup point setting
     Route::group(['prefix' => 'pickuppoint', 'middleware' => ['is_admin']], function(){
        Route::get('/', [PickupPointController::class, 'index'])->name('pickuppoint.index');
        Route::post('/store', [PickupPointController::class, 'store'])->name('pickuppoint.store');
        Route::delete('/delete/{id}', [PickupPointController::class, 'delete'])->name('pickuppoint.delete');

        Route::get('/edit/{id}', [PickupPointController::class, 'edit'])->name('pickuppoint.edit');
        Route::post('/update', [PickupPointController::class, 'update'])->name('pickuppoint.update');
      //error should id

    });

//sms crud
    Route::group(['prefix' => 'sms', 'middleware' => ['is_admin']], function(){
        Route::get('/', [SMSController::class, 'index'])->name('sms.index');
        Route::get('/inputform', [SMSController::class, 'inputform'])->name('sms.inputform');
        Route::post('/store', [SMSController::class, 'store'])->name('sms.store');
        Route::get('/delete/{id}', [SMSController::class, 'delete'])->name('sms.delete');

        Route::get('/edit/{id}', [SMSController::class, 'edit'])->name('sms.edit');
        Route::post('/update/{id}', [SMSController::class, 'update'])->name('sms.update');


    });
//for use send sms
    Route::group(['prefix' => 'sendsms', 'middleware' => ['is_admin']], function(){
        Route::get('/', [SMSController::class, 'sendsmsindex'])->name('sendsms.index');

       Route::get('/individualpage', [SendSmsController::class, 'individualpage'])->name('student.individualpage');
       Route::get('/byclasspage', [SendSmsController::class, 'byclass'])->name('student.byclass');
       Route::get('/byclassespage', [SendSmsController::class, 'byclasses'])->name('student.byclasses');
       Route::get('/getStudentsPhoneNumbers', [SendSmsController::class, 'getStudentsPhoneNumbers'])->name('sendsms.getStudentsPhoneNumbers');

       Route::get('/searchbyindividual', [SendSmsController::class, 'searchbyindividual'])->name('student.searchbyindividual');
       Route::get('/searchbyclass', [SendSmsController::class, 'searchbyclass'])->name('student.searchbyclass');

    });



    Route::group(['prefix' => 'student', 'middleware' => ['is_admin']], function(){
        Route::get('/', [StudentController::class, 'index'])->name('student.index');

         Route::post('/store', [StudentController::class, 'store'])->name('student.store');



    });



});
