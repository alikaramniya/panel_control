<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Middleware\CheckUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get("/", [UserController::class, "index"])
    ->middleware("auth")
    ->name("home");

Route::get("/dashboard", [UserController::class, "dashboard"])
    ->middleware(["auth", CheckUserIsAdmin::class])
    ->name("dashboard");

Route::post("/user/update/own/password", [
    UserController::class,
    "updatePassword",
])
    ->middleware(["auth"])
    ->name("user.update.own.password");

Route::middleware([CheckUserIsAdmin::class, "auth"])
    ->prefix("user")
    ->controller(UserController::class)
    ->group(function () {
        Route::get("/list", "usersList")->name("user.list");
        Route::get("/search", "search")->name("user.search");
        Route::get("/toggle/{user}", "toggle")->name("user.toggle.role");
        Route::get("/create", "create")->name("user.create");
        Route::get("/delete/{user}", "delete")->name("user.delete");
        Route::post("/upload", "upload")->name("user.upload.profile");
        Route::get("/image", "getImage")->name("user.profile.image");
        Route::post("/store", "store")->name("user.store");
        Route::get("/update", "updatePassword")->name("user.update.password");
        Route::get("/user", "user")->name("profile.user");
    });
Route::middleware(["auth"])
    ->prefix("document")
    ->controller(DocumentController::class)
    ->group(function () {
        Route::middleware(CheckUserIsAdmin::class)->group(function () {
            Route::post("/send", "store")->name("user.document.send");
            Route::delete("/delete/{document}", "destroy")->name(
                "document.delete",
            );
            Route::get("/list", "listDocument")->name("document.list");
        });
        Route::get("/download/{document}", "download")->name(
            "document.download",
        );
        Route::get("/show/{document}", "show")->name("document.show");
    });

require __DIR__ . "/auth.php";
