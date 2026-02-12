<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\RatingscaleController;
use App\Http\Controllers\InstructionConstroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsPrintEvalController;
use App\Http\Controllers\ReportsPrintSumEvalresultController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/dashboard', [DashboardController::class,'index'])->name('index.dashboard');

    Route::prefix('/schedule')->group(function () {
        Route::get('/eval/view', [CalendarController::class,'index'])->name('index.calendar');
        Route::get('/eval/fetch/calendar', [CalendarController::class, 'show'])->name('calendar.show');
        Route::get('/eval/fetch/table', [CalendarController::class, 'fetch'])->name('calendar.fetch');
        Route::post('/eval/add/calendar', [CalendarController::class, 'create'])->name('calendar.create');
    });

    Route::prefix('/faculty')->group(function () {
        Route::get('/list/view', [FacultyController::class,'index'])->name('index.faculty');
        Route::get('/list/view/search', [FacultyController::class,'facultyFilter'])->name('facultyFilter');
        Route::get('/list/search/ajax', [FacultyController::class, 'getfacultylistRead'])->name('getfacultylistRead');
        Route::post('/list/search/view/upload/image', [FacultyController::class, 'facultyUploadImage'])->name('facultyUploadImage');
        Route::post('/list/search/view/update/rank', [FacultyController::class, 'facultyrankUpdate'])->name('facultyrankUpdate');
    });

    Route::prefix('/conf')->group(function () {
        Route::get('/ratingscale/view', [RatingscaleController::class,'index'])->name('ratingscale.index');
        Route::get('/ratingscale/fetch/ajax', [RatingscaleController::class,'show'])->name('ratingscale.show');
        Route::post('/ratingscale/insert', [RatingscaleController::class,'create'])->name('ratingscale.create');
        Route::post('/ratingscale/update', [RatingscaleController::class,'update'])->name('ratingscale.update');
        Route::post('/ratingscale/delete{id}', [RatingscaleController::class,'destroy'])->name('ratingscale.delete');

        Route::get('/instruction/view', [InstructionConstroller::class,'index'])->name('instruction.index');

        Route::get('/category/view', [CategoryController::class,'index'])->name('category.index');
        Route::get('/category/fetch/ajax', [CategoryController::class,'show'])->name('category.show');
        Route::post('/category/insert', [CategoryController::class,'create'])->name('category.create');
        Route::post('/category/update', [CategoryController::class,'update'])->name('category.update');
        Route::post('/category/delete{id}', [CategoryController::class,'destroy'])->name('category.delete');

        Route::get('/question/view', [QuestionController::class,'index'])->name('question.index');
        Route::get('/question/fetch/ajaxaaa', [QuestionController::class,'show'])->name('question.show');
        Route::post('/question/insert', [QuestionController::class,'create'])->name('question.create');
        Route::post('/question/update', [QuestionController::class,'update'])->name('question.update');
        Route::post('/question/delete{id}', [QuestionController::class,'destroy'])->name('question.delete');

        Route::get('/semester/view', [SemesterController::class,'index'])->name('semester.index');
        Route::get('/semester/fetch/ajaxaaa', [SemesterController::class,'show'])->name('semester.show');
        Route::post('/semester/insert', [SemesterController::class,'create'])->name('semester.create');
        Route::post('/semester/update', [SemesterController::class,'update'])->name('semester.update');
        Route::post('/semester/delete{id}', [SemesterController::class,'destroy'])->name('semester.delete');

        Route::get('/settings/view', [SettingController::class,'index'])->name('setting.index');
        Route::post('/settings/view/update/statuseval', [SettingController::class,'toggleEval'])->name('toggleEval');
    });

    Route::prefix('/studaccount')->group(function () {
        Route::get('/admin/kiosk/user/view', [StudentAccountController::class, 'index'])->name('studaccount.index');
        Route::get('/admin/kiosk/user/view/result', [StudentAccountController::class, 'store'])->name('studaccountsearch.store');
        Route::get('/student/{id}', [StudentAccountController::class, 'getStudentById'])->name('getStudentById');
        Route::get('/admin/kiosk/user/view/ajax', [StudentAccountController::class, 'show'])->name('adminkiosk.show');
        Route::post('/admin/kiosk/user/view/add', [StudentAccountController::class, 'create'])->name('adminkiosk.create');
        Route::post('/admin/kiosk/user/view/update', [StudentAccountController::class, 'update'])->name('adminkiosk.update');
    });

    Route::prefix('/users')->group(function () {
        Route::get('/list/view', [UserController::class, 'index'])->name('user.index');
        Route::get('/list/fetch/ajaxuser', [UserController::class, 'getUserRead'])->name('getUserRead');
        Route::post('/list/fetch/insert', [UserController::class,'create'])->name('user.create');
        Route::post('/list/fetch/update', [UserController::class,'update'])->name('user.update');
        Route::post('/list/fetch/pass/user/update', [UserController::class,'passUpdate'])->name('passUpdate');
        Route::post('/list/fetch/pass/user/updateStatusnow', [UserController::class,'userUpdateStatus'])->name('userUpdateStatus');
        Route::post('/list/fetch/delete{id}', [UserController::class,'destroy'])->name('user.delete');
    });

    Route::prefix('/reports')->group(function () {
        Route::get('/view/qce/printsearch', [ReportsPrintEvalController::class, 'index'])->name('printeval.index');
        Route::get('/view/search/result', [ReportsPrintEvalController::class, 'subprint_searchresultStore'])->name('subprint_searchresultStore');
        Route::get('/view/search/result/eval/submission/ajax', [ReportsPrintEvalController::class, 'getevalsubratelistRead'])->name('getevalsubratelistRead');
        Route::get('/view/search/result/eval/submission/printedajax', [ReportsPrintEvalController::class, 'getevalsubrateprintedlistRead'])->name('getevalsubrateprintedlistRead');
        Route::get('/info/getcourseyrsec/ajax', [ReportsPrintEvalController::class, 'getCoursesyearsec'])->name('getCoursesyearsec');
        Route::get('/info/getevalpdf/print/evaluation', [ReportsPrintEvalController::class, 'exportPrintEvalPDF'])->name('exportPrintEvalPDF');
        Route::post('/info/getevalpdf/print/evaluation/update-statprint', [ReportsPrintEvalController::class, 'updateStatprint'])->name('updateStatprint');

        Route::get('/eval/result/summary', [ReportsPrintSumEvalresultController::class, 'index'])->name('summaryevalresult.index');
        Route::get('/eval/result/srch/summary/resultlist', [ReportsPrintSumEvalresultController::class, 'summaryEvalFilter'])->name('summaryEvalFilter');
        Route::get('/eval/result/srch/getfaclty/ajax', [ReportsPrintSumEvalresultController::class, 'getFacultycamp'])->name('getFacultycamp');
        Route::get('/eval/result/srch/summary/resultlist/view/Summary/pdfeval', [ReportsPrintSumEvalresultController::class, 'gensummaryevalPDF'])->name('gensummaryevalPDF');
        Route::get('/eval/result/srch/summary/resultlist/view/Comments/pdfeval', [ReportsPrintSumEvalresultController::class, 'gencommentsevalPDF'])->name('gencommentsevalPDF');
        Route::get('/eval/result/srch/summary/resultlist/view/Points/pdfeval', [ReportsPrintSumEvalresultController::class, 'genpointsevalPDF'])->name('genpointsevalPDF');
        Route::get('/eval/result/srch/summary/resultlist/view/Sheet/pdfeval', [ReportsPrintSumEvalresultController::class, 'gensumsheetevalPDF'])->name('gensumsheetevalPDF');
        Route::get('/eval/result/srch/summary/resultlist/view/Sheet/pdfevaldecimal', [ReportsPrintSumEvalresultController::class, 'gensumsheetevalPDFdecimal'])->name('gensumsheetevalPDFdecimal');
    });