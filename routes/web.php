    <?php

    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\ReviewController;
    use App\Http\Controllers\ServiceController;
    use App\Http\Controllers\BookingController;
    use App\Http\Controllers\Admin\AdminController;
    use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
    use App\Http\Controllers\Admin\MasterController;
    use App\Http\Controllers\Admin\PromotionController;
    use App\Http\Controllers\Admin\AppointmentController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\PetController;
    use App\Http\Controllers\UserProfileController;
    use App\Http\Controllers\HomeController;

    // Главная страница — через контроллер
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::view('/welcome', 'welcome')->name('welcome');
    Route::view('/about', 'about')->name('about');
    Route::view('/contacts', 'contacts')->name('contacts');
    Route::view('/promotions', 'promotions')->name('promotions');
    Route::view('/confirm', 'confirm')->name('confirm');

    // Публичные услуги
    Route::get('/services', [ServiceController::class, 'showServicesPage'])->name('services');

    // Регистрация и авторизация
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1')->name('register.post');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Публичные отзывы
    Route::get('/works', [ReviewController::class, 'index'])->name('works');
    Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

    // Админ-панель (+ заявки/appointments c обновлением статуса):
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('services', AdminServiceController::class);
        Route::resource('masters', MasterController::class);
        Route::resource('promotions', PromotionController::class);
        Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::post('appointments/{id}/status', [AppointmentController::class, 'setStatus'])->name('appointments.status');
    });

    // Бронирование (только для авторизованных)
    Route::middleware('auth')->group(function () {
        Route::get('/booking', [BookingController::class, 'step1'])->name('booking');
        Route::post('/booking/size', [BookingController::class, 'postSize'])->name('booking.size');
        Route::get('/booking/service', [BookingController::class, 'step2'])->name('booking.service');
        Route::post('/booking/service', [BookingController::class, 'postService'])->name('booking.service.post');
        Route::get('/booking/time', [BookingController::class, 'step3'])->name('booking.time');
        Route::post('/booking/time', [BookingController::class, 'postTime'])->name('booking.time.post');
        Route::get('/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
        Route::post('/booking/confirm', [BookingController::class, 'store'])->name('booking.store');
        Route::post('/booking/time/ajax', [BookingController::class, 'getBusyTimesAjax'])->name('booking.time.ajax');
    });

    // Питомцы (только для авторизованных)
    Route::middleware('auth')->group(function () {
        Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
        Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    });

    // Профиль пользователя (только для авторизованных)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::post('/profile/add-pet', [UserProfileController::class, 'addPet'])->name('profile.addPet');
        Route::post('/profile/delete-pet/{id}', [UserProfileController::class, 'deletePet'])->name('profile.deletePet');
        Route::post('/profile/edit-user', [UserProfileController::class, 'editUser'])->name('profile.editUser');
        Route::get('/profile/edit-avatar', [UserProfileController::class, 'editAvatar'])->name('profile.edit.avatar');
    });
