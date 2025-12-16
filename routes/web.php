<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\{
    PageController,
    AuthController,
    FilterController,
    ConnectorController,
    SettingsController,
    UserController,
    HideoutController,
    ServiceController,
    BuildController,
    CharacterController,
};

use App\Http\Controllers\DataExportImportController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('data')->group(function () {
        Route::get('/dashboard', [DataExportImportController::class, 'dashboard'])->name('data.dashboard');

        Route::get('/export-all', [DataExportImportController::class, 'exportAll'])->name('data.export.all');
        Route::post('/import-all', [DataExportImportController::class, 'importAll'])->name('data.import.all');

        Route::get('/export-table', [DataExportImportController::class, 'exportTable'])->name('data.export.table');
        Route::post('/import-table', [DataExportImportController::class, 'importTable'])->name('data.import.table');

        Route::get('/export-item', [DataExportImportController::class, 'exportItem'])->name('data.export.item');
        Route::post('/import-item', [DataExportImportController::class, 'importItem'])->name('data.import.item');
    });
});


// ? Статичные страницы
Route::get('/', [PageController::class, 'main'])->name('pages.main');
Route::get('/menu', [PageController::class, 'menu'])->name('pages.menu');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/community', [PageController::class, 'community'])->name('pages.community');


Route::get('/tree', [PageController::class, 'passiveTree'])->name('json.tree');

// ? Персонажи
Route::prefix('characters')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [CharacterController::class, 'index'])->name('characters.index');
        Route::get('/{name}', [CharacterController::class, 'show'])->name('characters.show');
        Route::get('/{name}/download', [CharacterController::class, 'download'])->name('characters.download');
        Route::post('/{name}/upload', [CharacterController::class, 'upload'])->name('characters.upload');
    });
});

// ? Пользователи
Route::prefix('users')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');

        Route::middleware(['admin'])->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        });
    });

    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

});

// ? Убежища изгнанников
Route::prefix('hideouts')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [HideoutController::class, 'create'])->name('hideouts.create');
        Route::post('/', [HideoutController::class, 'store'])->name('hideouts.store');
        Route::get('/{hideout}/edit', [HideoutController::class, 'edit'])->name('hideouts.edit');
        Route::put('/{hideout}', [HideoutController::class, 'update'])->name('hideouts.update');
        Route::delete('/{hideout}', [HideoutController::class, 'destroy'])->name('hideouts.destroy');
        Route::post('/{hideout}/restore', [HideoutController::class, 'restore'])->name('hideouts.restore');
    });

    Route::get('/', [HideoutController::class, 'index'])->name('hideouts.index');
    Route::get('/{hideout}', [HideoutController::class, 'show'])->name('hideouts.show');
    Route::get('/{hideout}/download', [HideoutController::class, 'download'])->name('hideouts.download');
});

// ? Объявления услуг
Route::prefix('services')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::post('/{service}/restore', [ServiceController::class, 'restore'])->name('services.restore');
    });

    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/{service}/whisp', [ServiceController::class, 'whisp'])->name('services.whisp');
});

// ? Сборки персонажей
Route::prefix('builds')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [BuildController::class, 'create'])->name('builds.create');
        Route::post('/', [BuildController::class, 'store'])->name('builds.store');
        Route::get('/{build}/edit', [BuildController::class, 'edit'])->name('builds.edit');
        Route::put('/{build}', [BuildController::class, 'update'])->name('builds.update');
        Route::delete('/{build}', [BuildController::class, 'destroy'])->name('builds.destroy');
        Route::post('/{build}/restore', [BuildController::class, 'restore'])->name('builds.restore');
        Route::get('/{build}/building', [BuildController::class, 'building'])->name('builds.building');
        Route::get('/{build}/tree', [BuildController::class, 'tree'])->name('builds.tree');
    });

    Route::get('/', [BuildController::class, 'index'])->name('builds.index');
    Route::get('/{build}', [BuildController::class, 'show'])->name('builds.show');
});

// ? Фильтры предметов
Route::prefix('filters')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [FilterController::class, 'create'])->name('filters.create');
        Route::post('/', [FilterController::class, 'store'])->name('filters.store');
        Route::get('/{filter}/edit', [FilterController::class, 'edit'])->name('filters.edit');
        Route::put('/{filter}', [FilterController::class, 'update'])->name('filters.update');
        Route::delete('/{filter}', [FilterController::class, 'destroy'])->name('filters.destroy');
        Route::post('/{filter}/restore', [FilterController::class, 'restore'])->name('filters.restore');
    });

    Route::middleware(['admin'])->group(function () {
        Route::get('/{filter}/export', [FilterController::class, 'export'])->name('filters.export');
        Route::post('/{filter}/import', [FilterController::class, 'import'])->name('filters.import');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/{filter}', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/{filter}', [SettingsController::class, 'update'])->name('settings.store');
        Route::delete('/{filter}', [SettingsController::class, 'destroy'])->name('settings.destroy');
        Route::middleware(['throttle:10,1'])->get('/{filter}/download', [SettingsController::class, 'download'])->name('settings.download');
    });

    Route::get('/', [FilterController::class, 'index'])->name('filters.index');
    Route::get('/{filter}', [FilterController::class, 'show'])->name('filters.show');
    Route::get('/{filter}/download', [FilterController::class, 'download'])->name('filters.download');
});

// ? Внешние ссылки
Route::redirect('/discord', 'https://discord.gg/rx5fZ7keRD', 301)->name('link.discord');
Route::redirect('/forumpoe', 'https://ru.pathofexile.com/forum/view-thread/2426037', 301)->name('link.forumpoe');
Route::redirect('/develop', 'http://dev.custompoe.ru', 301)->name('link.develop');

// ? Аудентификация
Route::prefix('auth')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
        Route::get('/relogin', [AuthController::class, 'relogin'])->name('auth.relogin');
        Route::get('/repassword', [AuthController::class, 'repassword'])->name('auth.repassword');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/login', [AuthController::class, 'enter'])->name('auth.enter');
    });


    Route::get('/back', function () {
        return redirect()->route('auth.login')->with(['info' => 'Требуется авторизация']);
    })->name('login');
});

// ? Коннектор
Route::prefix('connect')->group(function () {
    Route::post('/register', [ConnectorController::class, 'register'])->name('connect.register');
    Route::post('/feedback', [ConnectorController::class, 'feedback'])->name('connect.feedback');
});

// ? Авторизация
Route::prefix('oauth')->group(function () {
    Route::get('/login', [AuthController::class, 'poeLogin'])->name('oauth.login');
    Route::get('/enter', [AuthController::class, 'poeEnter'])->name('oauth.enter');
});

// Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name('oauth.redirect');
// Route::get('/auth/callback', [AuthController::class, 'callback'])->name('oauth.callback');

// ? Динамичные страницы
// Route::resource('filters', FilterController::class);
// Route::resource('modules', RuleController::class);