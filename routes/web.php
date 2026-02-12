<?php

use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminNoticeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MembershipApplicationReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\MemberAreaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\NoticeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MemberAreaController::class, 'index'])->name('home');
Route::get('/dashboard', [MemberAreaController::class, 'index'])->name('dashboard');
Route::get('/dashboard/slider-images', [MemberAreaController::class, 'sliderImages'])->name('dashboard.slider-images');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/membership/apply', [MembershipApplicationController::class, 'create'])->name('membership.create');
    Route::post('/membership/apply', [MembershipApplicationController::class, 'store'])->name('membership.store');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/membership-applications', [MembershipApplicationReviewController::class, 'index'])
            ->name('membership-applications.index');
        Route::post('/membership-applications/{application}/approve', [MembershipApplicationReviewController::class, 'approve'])
            ->name('membership-applications.approve');
        Route::post('/membership-applications/{application}/reject', [MembershipApplicationReviewController::class, 'reject'])
            ->name('membership-applications.reject');

        Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
        Route::post('/members/{user}/membership', [AdminMemberController::class, 'updateMembership'])->name('members.membership.update');
        Route::post('/members/{user}/toggle-admin', [AdminMemberController::class, 'toggleAdmin'])->name('members.admin.toggle');

        Route::get('/notices/create', [AdminNoticeController::class, 'createPage'])->name('notices.create');
        Route::get('/notices/list', [AdminNoticeController::class, 'listPage'])->name('notices.list');
        Route::post('/notices', [AdminNoticeController::class, 'store'])->name('notices.store');
        Route::put('/notices/{notice}', [AdminNoticeController::class, 'update'])->name('notices.update');
        Route::delete('/notices/{notice}', [AdminNoticeController::class, 'destroy'])->name('notices.destroy');
        Route::post('/notices/{notice}/toggle-public', [AdminNoticeController::class, 'togglePublic'])->name('notices.toggle-public');

        Route::get('/media/slider/create', [AdminMediaController::class, 'sliderCreatePage'])->name('media.slider.create');
        Route::get('/media/slider/list', [AdminMediaController::class, 'sliderListPage'])->name('media.slider.list');
        Route::post('/media/slider', [AdminMediaController::class, 'storeSliderItem'])->name('media.slider.store');
        Route::post('/media/slider/{sliderItem}/replace-image', [AdminMediaController::class, 'replaceSliderImage'])->name('media.slider.replace-image');
        Route::post('/media/slider/{sliderItem}/toggle', [AdminMediaController::class, 'toggleSliderItem'])->name('media.slider.toggle');
        Route::delete('/media/slider/{sliderItem}', [AdminMediaController::class, 'destroySliderItem'])->name('media.slider.destroy');

        Route::get('/media/banner/create', [AdminMediaController::class, 'bannerCreatePage'])->name('media.banner.create');
        Route::get('/media/banner/list', [AdminMediaController::class, 'bannerListPage'])->name('media.banner.list');
        Route::post('/media/banner', [AdminMediaController::class, 'storeBanner'])->name('media.banner.store');
        Route::post('/media/banner/{banner}/replace-image', [AdminMediaController::class, 'replaceBannerImage'])->name('media.banner.replace-image');
        Route::post('/media/banner/{banner}/toggle', [AdminMediaController::class, 'toggleBanner'])->name('media.banner.toggle');
        Route::delete('/media/banner/{banner}', [AdminMediaController::class, 'destroyBanner'])->name('media.banner.destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
