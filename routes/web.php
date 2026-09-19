<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\CommunityMemberController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::view('/tentang-kami', 'about')->name('about');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{gallery:slug}', [GalleryController::class, 'show'])->name('galleries.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/gabung-komunitas', [CommunityMemberController::class, 'create'])->name('community-members.create');
Route::post('/gabung-komunitas', [CommunityMemberController::class, 'store'])->name('community-members.store');