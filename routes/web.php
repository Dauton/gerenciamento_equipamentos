<?php

use App\Http\Controllers\AutenticacaoControllers\AuthController;
use App\Http\Controllers\ComponentesControllers\AlterarSiteController;
use App\Http\Controllers\CRUDControllers\AvariasController;
use App\Http\Controllers\CRUDControllers\ColaboradoresController;
use App\Http\Controllers\CRUDControllers\DepartamentosController;
use App\Http\Controllers\CRUDControllers\EquipamentosController;
use App\Http\Controllers\CRUDControllers\SenhaController;
use App\Http\Controllers\CRUDControllers\SitesController;
use App\Http\Controllers\CRUDControllers\TurnosController;
use App\Http\Controllers\CRUDControllers\UsuariosController;
use App\Http\Controllers\RelatoriosControllers\RelatorioController;
use App\Http\Controllers\RelatoriosControllers\RelatorioPermanenteController;
use App\Http\Controllers\ViewsControllers\ShowPagesController;
use App\Http\Middleware\CheckPerfil;
use App\Http\Middleware\EstaLogado;
use App\Http\Middleware\NaoEstaLogado;
use Illuminate\Support\Facades\Route;

// O USUÁRIO NÃO ESTÁ LOGADO, BLOQUEIA ACESSO A:
Route::middleware([NaoEstaLogado::class])->group(function () {

    // O PERFIL DO USUÁRIO NÃO É VÁLIDO: BLOQUEIA ACESSO A:
    Route::middleware([CheckPerfil::class])->group(function () {

        // SHOWPAGES ROUTE
        //CREATES
        Route::get('/cadastros', [ShowPagesController::class, 'cadastrosPage'])->name('cadastros');
        Route::get('/usuarios/create', [ShowPagesController::class, 'usuariosPage'])->name('create-usuario');
        Route::get('/sites/create', [ShowPagesController::class, 'sitesPage'])->name('create-site');
        Route::get('/avarias/create', [ShowPagesController::class, 'avariasPage'])->name('create-avaria');
        Route::get('/turnos/create', [ShowPagesController::class, 'turnosPage'])->name('create-turno');
        Route::get('/departamentos/create', [ShowPagesController::class, 'departamentosPage'])->name('create-departamento');
        Route::get('/equipamentos/create', [ShowPagesController::class, 'equipamentosPage'])->name('create-equipamento');
        Route::get('/colaboradores/create', [ShowPagesController::class, 'colaboradoresPage'])->name('create-colaborador');

        //EDITS
        Route::get('/usuarios/edit/{id}', [ShowPagesController::class, 'editUsuarioPage'])->name('edit-usuario');
        Route::get('/sites/edit/{id}', [ShowPagesController::class, 'editSitePage'])->name('edit-site');
        Route::get('/avarias/edit/{id}', [ShowPagesController::class, 'editAvariaPage'])->name('edit-avaria');
        Route::get('/turnos/edit/{id}', [ShowPagesController::class, 'editTurnoPage'])->name('edit-turno');
        Route::get('/departamentos/edit/{id}', [ShowPagesController::class, 'editDepartamentoPage'])->name('edit-departamento');
        Route::get('/equipamentos/edit/{id}', [ShowPagesController::class, 'editEquipamentoPage'])->name('edit-equipamento');
        Route::get('/colaborador/edit/{id}', [ShowPagesController::class, 'editColaboradorPage'])->name('edit-colaborador');

        // ENTREGAS, DEVOLUÇÕES E RELATORIOS
        Route::get('/entregas/entrega-permanente', [ShowPagesController::class, 'entregaEquipamentoPermanentePage'])->name('entrega-permanente');
        Route::get('/entregas/devolve-permanente/{id}', [ShowPagesController::class, 'devolveEquipamentoPermanentePage'])->name('devolve-permanente');
        Route::get('/relatorios/permanentes', [ShowPagesController::class, 'relatoriosPermanentesPage'])->name('relatorios-permanentes');


        // EXECUSÕES ROUTES
        // CREATES
        Route::post('/createUser', [UsuariosController::class, 'createUser'])->name('createUser');
        Route::post('/createSite', [SitesController::class, 'createSite'])->name('createSite');
        Route::post('/createAvaria', [AvariasController::class, 'createAvaria'])->name('createAvaria');
        Route::post('/createTurno', [TurnosController::class, 'createTurno'])->name('createTurno');
        Route::post('/createDepartamento', [DepartamentosController::class, 'createDepartamento'])->name('createDepartamento');
        Route::post('/createEquipamento', [EquipamentosController::class, 'createEquipamento'])->name('createEquipamento');
        Route::post('/createColaborador', [ColaboradoresController::class, 'createColaborador'])->name('createColaborador');

        // EDITS
        Route::post('/editUser/{id}', [UsuariosController::class, 'editUser'])->name('editUser');
        Route::post('/editSite/{id}', [SitesController::class, 'editSite'])->name('editSite');
        Route::post('/editAvaria/{id}', [AvariasController::class, 'editAvaria'])->name('editAvaria');
        Route::post('/editTurno/{id}', [TurnosController::class, 'editTurno'])->name('editTurno');
        Route::post('/editDepartamento/{id}', [DepartamentosController::class, 'editDepartamento'])->name('editDepartamento');
        Route::post('/editEquipamento/{id}', [EquipamentosController::class, 'editEquipamento'])->name('editEquipamento');
        Route::post('/editColaborador/{id}', [ColaboradoresController::class, 'editColaborador'])->name('editColaborador');

        // DELETES
        Route::get('/deleteUsuario/{id}', [UsuariosController::class, 'deleteUsuario'])->name('deleteUsuario');
        Route::get('/deleteSite/{id}', [SitesController::class, 'deleteSite'])->name('deleteSite');
        Route::get('/deleteAvaria/{id}', [AvariasController::class, 'deleteAvaria'])->name('deleteAvaria');
        Route::get('/deleteTurno/{id}', [TurnosController::class, 'deleteTurno'])->name('deleteTurno');
        Route::get('/deleteDepartamento/{id}', [DepartamentosController::class, 'deleteDepartamento'])->name('deleteDepartamento');
        Route::get('/deleteEquipamento/{id}', [EquipamentosController::class, 'deleteEquipamento'])->name('deleteEquipamento');
        Route::get('/deleteColaborador/{id}', [ColaboradoresController::class, 'deleteColaborador'])->name('deleteColaborador');

        // ENTREGAS, DEVOLUÇÕES E BUSCA DE RELATORIOS
        Route::post('/entregaEquipamentoPermanente', [RelatorioPermanenteController::class, 'entregaEquipamentoPermanente'])->name('entregaEquipamentoPermanente');
        Route::post('/devolveEquipamentoPermanente/{id}', [RelatorioPermanenteController::class, 'devolveEquipamentoPermanente'])->name('devolveEquipamentoPermanente');
        Route::post('/buscaRelatorioPermanente', [RelatorioPermanenteController::class, 'buscaRelatorioPermanente'])->name('buscaRelatorioPermanente');
    });

    // SHOWPAGES ROUTES
    Route::get('/entregas/entrega-temporario', [ShowPagesController::class, 'entregaEquipamentoPage'])->name('homepage'); //HOMEPAGE
    Route::get('/entregas/devolve-temporario/{id}', [ShowPagesController::class, 'devolveEquipamentoPage'])->name('devolve-temporario');
    Route::get('/relatorios/temporarias', [ShowPagesController::class, 'relatoriosPage'])->name('relatorios-temporarias');
    Route::get('/senha/edit/{id}', [ShowPagesController::class, 'editPasswordPage'])->name('edit-senha');

    // EXECUÇÕES ROUTES
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/editSenha/{id}', [SenhaController::class, 'editSenha'])->name('editSenha');
    Route::post('/entregaEquipamento', [RelatorioController::class, 'entregaEquipamento'])->name('entregaEquipamento');
    Route::post('/devolveEquipamento/{id}', [RelatorioController::class, 'devolveEquipamento'])->name('devolveEquipamento');
    Route::post('/buscaRelatorio', [RelatorioController::class, 'buscaRelatorio'])->name('buscaRelatorio');
    Route::post('/alterarSite', [AlterarSiteController::class, 'alterarSiteSessao'])->name('alterarSite');
});

// O USUÁRIO ESTÁ LOGADO, BLOQUEIA ACESSO A:
Route::middleware([EstaLogado::class])->group(function () {

    // SHOWPAGES ROUTES
    Route::get('/', [ShowPagesController::class, 'loginPage'])->name('login');

    // EXECUTIONS ROUTES
    Route::post('/submitLogin', [AuthController::class, 'submitLogin'])->name('submitLogin');
});
