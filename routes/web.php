<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\RelatorioPermanenteController;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ShowPagesController;
use App\Http\Controllers\UpdateController;
use App\Http\Middleware\CheckPerfil;
use App\Http\Middleware\EstaLogado;
use App\Http\Middleware\NaoEstaLogado;
use Illuminate\Support\Facades\Route;

// O USUÁRIO NÃO ESTÁ LOGADO, BLOQUEIA ACESSO A:
Route::middleware([NaoEstaLogado::class])->group(function() {

    // O PERFIL DO USUÁRIO NÃO É VÁLIDO: BLOQUEIA O ACESSO A:
    Route::middleware([CheckPerfil::class])->group(function() {

        // SHOWPAGES ROUTE
        Route::get('/cadastros', [ShowPagesController::class, 'cadastrosPage'])->name('cadastros');
        Route::get('/usuarios', [ShowPagesController::class, 'usuariosPage'])->name('usuarios');
        Route::get('/sites', [ShowPagesController::class, 'sitesPage'])->name('sites');
        Route::get('/avarias', [ShowPagesController::class, 'avariasPage'])->name('avarias');
        Route::get('/turnos', [ShowPagesController::class, 'turnosPage'])->name('turnos');
        Route::get('/departamentos', [ShowPagesController::class, 'departamentosPage'])->name('departamentos');
        Route::get('/equipamentos', [ShowPagesController::class, 'equipamentosPage'])->name('equipamentos');
        Route::get('/colaboradores', [ShowPagesController::class, 'colaboradoresPage'])->name('colaboradores');

        Route::get('/update-usuario/{id}', [ShowPagesController::class, 'updateUsuarioPage'])->name('update-usuario');
        Route::get('/update-site/{id}', [ShowPagesController::class, 'updateSitePage'])->name('update-site');
        Route::get('/update-avaria/{id}', [ShowPagesController::class, 'updateAvariaPage'])->name('update-avaria');
        Route::get('/update-turno/{id}', [ShowPagesController::class, 'updateTurnoPage'])->name('update-turno');
        Route::get('/update-departamento/{id}', [ShowPagesController::class, 'updateDepartamentoPage'])->name('update-departamento');
        Route::get('/update-equipamento/{id}', [ShowPagesController::class, 'updateEquipamentoPage'])->name('update-equipamento');
        Route::get('/update-colaborador/{id}', [ShowPagesController::class, 'updateColaboradorPage'])->name('update-colaborador');

        Route::get('/entrega-permanente', [ShowPagesController::class, 'entregaEquipamentoPermanentePage'])->name('entrega-permanente');
        Route::get('/devolve-permanente/{id}', [ShowPagesController::class, 'devolveEquipamentoPermanentePage'])->name('devolve-permanente');
        Route::get('/relatorios-permanentes', [ShowPagesController::class, 'relatoriosPermanentesPage'])->name('relatorios-permanentes');

        // EXECUSÕES ROUTES
        Route::post('/createUser', [CreateController::class, 'createUser'])->name('createUser');
        Route::post('/createSite', [CreateController::class, 'createSite'])->name('createSite');
        Route::post('/createAvaria', [CreateController::class, 'createAvaria'])->name('createAvaria');
        Route::post('/createTurno', [CreateController::class, 'createTurno'])->name('createTurno');
        Route::post('/createDepartamento', [CreateController::class, 'createDepartamento'])->name('createDepartamento');
        Route::post('/createEquipamento', [CreateController::class, 'createEquipamento'])->name('createEquipamento');
        Route::post('/createColaborador', [CreateController::class, 'createColaborador'])->name('createColaborador');

        Route::post('/updateUser/{id}', [UpdateController::class, 'updateUser'])->name('updateUser');
        Route::post('/updateSite/{id}', [UpdateController::class, 'updateSite'])->name('updateSite');
        Route::post('/updateAvaria/{id}', [UpdateController::class, 'updateAvaria'])->name('updateAvaria');
        Route::post('/updateTurno/{id}', [UpdateController::class, 'updateTurno'])->name('updateTurno');
        Route::post('/updateDepartamento/{id}', [UpdateController::class, 'updateDepartamento'])->name('updateDepartamento');
        Route::post('/updateEquipamento/{id}', [UpdateController::class, 'updateEquipamento'])->name('updateEquipamento');
        Route::post('/updateColaborador/{id}', [UpdateController::class, 'updateColaborador'])->name('updateColaborador');

        Route::get('/deleteUsuario/{id}', [DeleteController::class, 'deleteUsuario'])->name('deleteUsuario');
        Route::get('/deleteSite/{id}', [DeleteController::class, 'deleteSite'])->name('deleteSite');
        Route::get('/deleteAvaria/{id}', [DeleteController::class, 'deleteAvaria'])->name('deleteAvaria');
        Route::get('/deleteTurno/{id}', [DeleteController::class, 'deleteTurno'])->name('deleteTurno');
        Route::get('/deleteDepartamento/{id}', [DeleteController::class, 'deleteDepartamento'])->name('deleteDepartamento');
        Route::get('/deleteEquipamento/{id}', [DeleteController::class, 'deleteEquipamento'])->name('deleteEquipamento');
        Route::get('/deleteColaborador/{id}', [DeleteController::class, 'deleteColaborador'])->name('deleteColaborador');

        Route::post('/entregaEquipamentoPermanente', [RelatorioPermanenteController::class, 'entregaEquipamentoPermanente'])->name('entregaEquipamentoPermanente');
        Route::post('/devolveEquipamentoPermanente/{id}', [RelatorioPermanenteController::class, 'devolveEquipamentoPermanente'])->name('devolveEquipamentoPermanente');
        Route::post('/buscaRelatorioPermanente', [RelatorioPermanenteController::class, 'buscaRelatorioPermanente'])->name('buscaRelatorioPermanente');
    });

    // SHOWPAGES ROUTES
    Route::get('/homepage', [ShowPagesController::class, 'homepagePage'])->name('homepage');
    Route::get('/update-senha/{id}', [ShowPagesController::class, 'updatePasswordPage'])->name('update-senha');
    Route::get('/devolve-equipamento/{id}', [ShowPagesController::class, 'devolveEquipamentoPage'])->name('devolve-equipamento');
    Route::get('/relatorios', [ShowPagesController::class, 'relatoriosPage'])->name('relatorios');

    // EXECUÇÕES ROUTES
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/updateSenha/{id}', [SenhaController::class, 'updateSenha'])->name('updateSenha');
    Route::post('/entregaEquipamento', [RelatorioController::class, 'entregaEquipamento'])->name('entregaEquipamento');
    Route::post('/devolveEquipamento/{id}', [RelatorioController::class, 'devolveEquipamento'])->name('devolveEquipamento');
    Route::post('/buscaRelatorio', [RelatorioController::class, 'buscaRelatorio'])->name('buscaRelatorio');

});

// O USUÁRIO ESTÁ LOGADO, BLOQUEIA ACESSO A:
Route::middleware([EstaLogado::class])->group(function() {

    // SHOWPAGES ROUTES
    Route::get('/', [ShowPagesController::class, 'loginPage'])->name('login');

    // EXECUTIONS ROUTES
    Route::post('/submitLogin', [AuthController::class, 'submitLogin'])->name('submitLogin');

});
