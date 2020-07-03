<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//  FRONTEND

Route::group(['prefix' => 'cart'], function () {
    Route::get('', 'frontend\CartController@getCart');
    Route::get('add', 'frontend\CartController@addCart');
    Route::get('del/{rowId}', 'frontend\CartController@delCart');
    //must name rowId because name of variable in model Cart.php is rowId
    Route::get('update/{rowId}/{qty}', 'frontend\CartController@updateCart');

});

Route::group(['prefix' => 'product'], function () {
    Route::get('detail/{slug_prd}', 'frontend\ProductController@getDetail');
    Route::get('shop', 'frontend\ProductController@getShop');
    Route::get('{slug_cate}', 'frontend\ProductController@getPrdCate');
});

Route::group(['prefix' => 'checkout'], function () {
    Route::get('', 'frontend\CheckoutController@getCheckout');
    Route::post('', 'frontend\CheckoutController@postCheckout');

    Route::get('complete/{order_id}', 'frontend\CheckoutController@getComplete');
});

Route::get('about', 'frontend\HomeController@getAbout');

Route::get('contact', 'frontend\HomeController@getContact');

Route::get('', 'frontend\HomeController@getIndex');
Route::post('send', 'frontend\HomeController@sendMail');


//BACKEND   
Route::get('login', 'backend\LoginController@getLogin')->middleware('checkLogout');
Route::post('login', 'backend\LoginController@postLogin');

Route::group(['prefix' => 'admin', 'middleware' => 'checkLogin'], function () {
    //admin
    Route::get('', 'backend\IndexController@getIndex');
    Route::get('logout', 'backend\LoginController@getLogout');

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('add', 'backend\ProductController@getAddProduct');
        Route::post('add', 'backend\ProductController@postAddProduct');
        Route::get('edit/{productId}', 'backend\ProductController@getEditProduct');
        Route::post('edit/{productId}', 'backend\ProductController@postEditProduct');
        Route::get('del/{productId}', 'backend\ProductController@getDelProduct');
        Route::get('', 'backend\ProductController@getProduct');
    });
    
    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('', 'backend\CategoryController@getCategory');
        Route::post('', 'backend\CategoryController@postAddCategory');
        Route::get('edit/{cateId}', 'backend\CategoryController@getEditCategory');
        Route::post('edit/{cateId}', 'backend\CategoryController@postEditCategory');
        Route::get('del/{cateId}', 'backend\CategoryController@getDelCategory');
    });
    
    //user
    Route::group(['prefix' => 'user'], function () {
        Route::get('add', 'backend\UserController@getAddUser');
        Route::post('add', 'backend\UserController@postAddUser');
        Route::get('edit/{idUser}', 'backend\UserController@getEditUser');
        Route::post('edit/{idUser}', 'backend\UserController@postEditUser');
        Route::get('del/{idUser}', 'backend\UserController@getDelUser');
        Route::get('', 'backend\UserController@getUser');
        
    });

    //order
    Route::group(['prefix' => 'order'], function () {
        Route::get('', 'backend\OrderController@getOrder');
        Route::get('detail/{orderId}', 'backend\OrderController@getDetailOrder');
        Route::get('paid/{orderId}', 'backend\OrderController@getPaid');
        Route::get('processed', 'backend\OrderController@getProcessed');
    });
});

//=========================================================================================
//SCHEMA
Route::group(['prefix' => 'schema'], function () {
    //create table
    Route::get('create', function () {
        Schema::create('users', function ($table) {
            $table->bigIncrements('id');
            $table->string('address', 100)->nullable()->default('text');
            $table->timestamps();
        });
        Schema::create('users', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable;
            $table->bigInterger('user-id')->unsign();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

    });

    //Edit table
    Route::get('edit', function () {
        //rename table
        Schema::rename('users', 'list-users');
    });

    //Delete table if exists
    Route::get('delete', function () {
        Schema::dropIfExists('list-users');
    });

    //interact with columns
        //update doctrine: composer require doctrine/dbal
    Route::get('edit-col', function () {

        Schema::table('users', function ($table) {
            //edit attribute of column
            $table->string('name', 50)->nullable()->change();

            //add column
            $table->boolean('level')->nullable()->default(false);

            //add column at determinded position
            $table->boolean('confirmed')->nullable()->default(false)->after('name');

            //drop column
            $table->dropColumn('level');

        });
    });

});
//QUERY BUILDER
Route::group(['prefix' => 'query'], function () {
    //insert data into db
    Route::get('insert', function () {
        //insert a record
        DB::table('users')->insert([
            "email" => "Thao@gmail.com",
            "password" => "Thao123",
            "full" => "Thao Bich",
            "address" => "Giai Phong",
            "phone" => 8888,
            "level" => "1"
        ]);
        //insert many records
        DB::table('users')->insert([
            ["email" => "Van@gmail.com",
            "password" => "Van123",
            "full" => "Van Thuy",
            "address" => "Giai Phong",
            "phone" => 444,
            "level" => "1"],

            ["email" => "Ngan@gmail.com",
            "password" => "Ngan123",
            "full" => "Ngan Trinh",
            "address" => "Giai Phong",
            "phone" => 555,
            "level" => "1"],

            ["email" => "Hien@gmail.com",
            "password" => "Hien123",
            "full" => "Hien Nguyen",
            "address" => "Giai Phong",
            "phone" => 777,
            "level" => "1"]

        ]);
    }); 
    
    //update a record by id
    Route::get('update', function () {
        DB::table('users')->where('id', 2)->update([
            "address"=>"Thai Binh",
            "phone"=> 55555555
        ]);
    });

    //delete a record by id
    Route::get('del', function () {
        DB::table('users')->where('id', 3)->delete();
    });

    //other queries
    Route::get('get-user', function () {
        //get many records
        DB::table('users')->get();

        //get the first record: first()
        //get the last record: latest()
        DB::table('users')->first();

        //get a record by id
        DB::table('users')->find(2);
        // dd($user); */

        //get records with the condition
        //id # 3
        DB::table('users')->where('id','<>',3)->get();

        //where-where
        DB::table('users')->where('id', '>', 1)->where('id', '<', 4)->get();

        //orWhere
        DB::table('users')->where('id', '<', 2)->orwhere('id', '>', 4)->get();

        //whereBetween
        DB::table('users')->whereBetween('id', [1, 2])->get();

    });

    //sort: oderBy()
    Route::get('order-by', function () {
        DB::table('users')->orderBy('id', 'desc')->get();
    });

    //get the number of records: take()
    Route::get('take', function () {
        DB::table('users')->take(2)->get();
    });

    //skip records
    Route::get('skip', function () {
        $user = DB::table('users')->skip(1)->take(2)->get();
        dd($user);
    });
});

//RELATIONSHIP

//1-1
Route::get('oneToOne', function () {
    $user = App\User::find(1);
    $info = $user->info()->get();
    dd($user->toarray());
});

//1-1 inverse
Route::get('oneToOneInverse', function () {
    $info = App\models\Info::find(3);
    $user = $info->user()->get();
});

//1-many
Route::get('oneToMany', function () {
    $cate = App\models\Category::find(6);
    $prd = $cate->product()->get();
    dd($cate->toarray());
});

//1-many inverse
Route::get('oneToManyInverse', function () {
    $prd = App\models\Product::find(3);
    $cate = $prd->category->get();
    dd($prd->toarray());
});

