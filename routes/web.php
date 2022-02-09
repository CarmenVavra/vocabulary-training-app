<?php

use App\Http\Controllers\CsvController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForeignVocabularyController;
use App\Http\Controllers\HangmanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\WelcomeController;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('welcome');
});
 */
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', [LanguageController::class, 'index'])->name('get.language.index');
Route::post('/home', [LanguageController::class, 'index'])->name('post.language.index');
Route::post('/language/cookie', [LanguageController::class, 'setCookie'])->name('language.setCookie');
Route::get('/language', [LanguageController::class, 'create'])->name('language.create');
Route::post('/language', [LanguageController::class, 'store'])->name('language.store');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit'); 

Route::get('/profile', [UserController::class, 'profile'] )->name('user.profile');
Route::put('/user/{user}', [UserController::class, 'update'] )->name('user.update');

Route::middleware('auth')->group(function(){

    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome.index');
    Route::post('/welcome', [WelcomeController::class, 'index'])->name('welcome.index');

    Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
    Route::get('/vocabulary/{vocabulary}/edit', [VocabularyController::class, 'edit'])->name('vocabulary.edit');
    Route::post('/vocabulary', [VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::put('/vocabulary/{vocabularies}', [VocabularyController::class, 'update'])->name('vocabulary.update');
    Route::delete('/vocabulary/{vocabulary}/warndelete', [VocabularyController::class, 'warnDelete'])->name('vocabulary.warn.delete');
    Route::delete('/vocabulary/{deleteVocabulary}', [VocabularyController::class, 'destroy'])->name('vocabulary.delete');
    Route::get('/vocabulary/cancel', [VocabularyController::class, 'vocabularyCancel'])->name('vocabulary.cancel');

    
    Route::get('/vocabularyautocomplete', [VocabularyController::class, 'autocomplete'])->name('vocabulary.autocomplete');
    /* Route::get('/vocedit/{voc}', [VocabularyController::class, 'vocedit'] )->name('voc.edit'); */



    Route::get('/setmarker', [ForeignVocabularyController::class, 'setMarker'])->name('set.marker');
    Route::get('/foreignautocomplete', [ForeignVocabularyController::class, 'autocomplete'])->name('foreign.autocomplete');

    Route::post('/uploadcsv', [CsvController::class, 'uploadContent'])->name('upload.csv');

    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');

    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/quizdatecheck', [QuizController::class, 'checkDate'])->name('quiz.check.date');
    Route::get('/quizdifflevel', [QuizController::class, 'checkDifficultyLevel'])->name('quiz.check.difflevel');
    Route::get('/quizselectall', [QuizController::class, 'selectAll'])->name('quiz.select.all');
    Route::get('/quizfetchfake', [QuizController::class, 'fetchFake'])->name('quiz.fetch.fake');
    Route::post('/quiz', [QuizController::class, 'filterSelect'])->name('quiz.filter.select');
    
    Route::get('/pair', [PairController::class, 'index'])->name('pair.index');
    Route::get('/pairdatecheck', [PairController::class, 'checkDate'])->name('pair.check.date');
    Route::get('/pairdifflevel', [PairController::class, 'checkDifficultyLevel'])->name('pair.check.difflevel');
    Route::get('/pairselectall', [PairController::class, 'selectAll'])->name('pair.select.all');
    Route::post('/pair', [PairController::class, 'filterSelect'])->name('pair.filter.select');
    
    Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
    Route::get('/learningdatecheck', [LearningController::class, 'checkDate'])->name('learning.check.date');
    Route::get('/learningdifflevel', [LearningController::class, 'checkDifficultyLevel'])->name('learning.check.difflevel');
    Route::get('/learningselectall', [LearningController::class, 'selectAll'])->name('learning.select.all');
    Route::post('/learning', [LearningController::class, 'filterSelect'])->name('learning.filter.select');

    Route::get('/hangman', [HangmanController::class, 'index'])->name('hangman.index');
    Route::get('/hangmandatecheck', [HangmanController::class, 'checkDate'])->name('hangman.check.date');   // Hier darf nichts mehr geändert werden .. ansonsten auch im Javascript ajax
    Route::get('/hangmandifflevel', [HangmanController::class, 'checkDifficultyLevel'])->name('hangman.check.difflevel');
    Route::get('/hangmanselectall', [HangmanController::class, 'selectAll'])->name('hangman.select.all');
    Route::post('/hangman', [HangmanController::class, 'filterSelect'])->name('hangman.filter.select');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

});    






