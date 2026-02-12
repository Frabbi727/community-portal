<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberAreaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');

Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])->name('membership.create');
Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])->name('membership.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/member-area', [MemberAreaController::class, 'index'])->name('member.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
