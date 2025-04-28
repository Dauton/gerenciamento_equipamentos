<?php

namespace App\Http\Controllers;

use App\Models\Avaria;
use App\Models\Colaborador;
use App\Models\Departamento;
use App\Models\Equipamento;
use App\Models\Site;
use App\Models\Turno;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InputValidationsController extends Controller
{

    // LOGIN VALIDATIONS
    public static function validationsLogin(Request $request)
    {
        $request->validate(
            [
                'usuario' => 'required',
                'senha' => 'required'
            ],
            [
                'usuario.required' => 'O usuário deve ser informado.',
                'senha.required' => 'A senha deve ser informada.'
            ]
        );
    }

    // VALIDATIONS ENTREGA DE EQUIPAMENTO
    public static function validationsEntregaEquipamento(Request $request)
    {
        $request->validate(
            [
                'equipamento' => ['required'],
                'colaborador' => ['required'],
                'departamento' => ['required'],
                'turno' => ['required'],
            ],
            [
                'equipamento.required' => 'O equipamento a ser entregue deve ser informado.',
                'colaborador' => 'O dado do colaborador deve ser informado.',
                'departamento' => 'O departamento deve ser informado.',
                'turno' => 'O turno deve ser informado.'
            ]
        );
    }

    // VALIDATIONS DEVOLUÇÃO DE EQUIPAMENTO
    public static function validationsDevolveEquipamento(Request $request)
    {
        $request->validate(
            [
                'ha_avaria' => ['required'],
            ],
            [
                'ha_avaria' => 'Deve ser informado se houve não avaria no equipamento.',
            ]
        );
        if ($request->input('ha_avaria') === 'SIM') {
            $request->validate(
                [
                    'avaria' => ['required'],
                    'foto_avaria' => ['required', 'extensions:png,jpg,jpeg']
                ],
                [
                    'avaria' => 'A descrição da avaria deve ser informada.',
                    'foto_avaria' => 'A foto da avaria deve ser anexada.',
                    'foto_avaria.extensions' => 'O formato de imagem anxado é inválido ou não permitido.'
                ]
            );
        }
    }

    public static function validationsEntregaEquipamentoPermanente(Request $request)
    {
        self::validationsEntregaEquipamento($request);

        $request->validate(
            [
                'termo_responsabilidade' => ['extensions:pdf,docx']
            ],
            [
                'termo_responsabilidade.extensions' => 'O formato do termo de responsabilidae deve ser .pdf ou .docx'
            ]
        );
    }


    //_________________________________________________________________________________________________________


    // CREATES VALIDATIONS

    // CREATE USER VALIDATIONS
    public static function validationsCreateUser(Request $request)
    {
        $request->validate(
            [
                'nome' => ['required'],
                'usuario' => ['required', 'unique:usuarios,usuario'],
                'email' => ['required', 'email'],
                'site' => ['required'],
                'perfil' => ['required'],
                'senha' => ['required', 'min: 12', 'regex: /[a-z]/', 'regex: /[A-Z]/', 'regex: /[0-9]/', 'regex: /[!@#$%^&*(),.?":{}|<>]/'],
                'repete_senha' => ['required', 'same:senha']
            ],
            [
                'nome.required' => 'O nome deve ser informado.',
                'usuario.required' => 'O usuário deve ser informado.',
                'usuario.unique' => 'O usuário informado já está cadastrado.',
                'email.required' => 'O e-mail deve ser informado.',
                'email.email' => 'O e-mail informado não é válido.',
                'site.required' => 'O site deve ser informado.',
                'perfil.required' => 'O perfil deve ser informado.',
                'senha.required' => 'A senha deve ser informada.',
                'senha.min' => 'A senha deve possuir pelo menos :min caracteres',
                'senha.regex' => 'A senha deve possuir pelo menos uma letra maiúscula, uma letra minuscula, um número e um caractere especial.',
                'repete_senha.required' => 'A senha deve ser confirmada.',
                'repete_senha.same' => 'A senhas não conferem.'
            ]

        );
    }


    // CREATE SITE VALIDATIONS
    public static function validationsSite(Request $request)
    {
        $request->validate(
            [
                'descricao' => ['required', 'unique:sites,descricao']
            ],
            [
                'descricao.required' => 'A descrição deve ser informada.',
                'descricao.unique' => 'O site informado já está cadastrado.'
            ]
        );
    }

    // CREATE AVARIA VALIDATIONS
    public static function validationsAvaria(Request $request)
    {
        $request->validate(
            [
                'avaria' => ['required', 'unique:avarias,avaria'],
                'tipo_avaria' => ['required']
            ],
            [
                'avaria.required' => 'A descrição da avaria deve ser informada.',
                'avaria.unique' => 'A avaria informada já está cadastrada.',
                'tipo_avaria.required' => 'O tipo da avaria deve ser informado.'
            ]
        );
    }

    // CREATE TURNO VALIDATIONS
    public static function validationsTurno(Request $request)
    {
        $request->validate(
            [
                'turno' => ['required', 'unique:turnos,turno']
            ],
            [
                'turno.required' => 'A descrição do turno deve ser informada.',
                'turno.unique' => 'O turno informado já está cadastrado.'
            ]
        );
    }

    // CREATE DEPARTAMENTO VALIDATIONS
    public static function validationsDepartamento(Request $request)
    {
        $request->validate(
            [
                'departamento' => ['required', 'unique:departamentos,departamento'],
            ],
            [
                'departamento.required' => 'A descrição do departamento deve ser informada.',
                'departamento.unique' => 'O departamento informado já está cadastrado.'
            ]
        );
    }

    // CREATE EQUIPAMENTO VALIDATIONS
    public static function validationsEquipamento(Request $request)
    {
        $request->validate(
            [
                'marca' => ['required'],
                'modelo' => ['required'],
                'serial' => ['required'],
                'patrimonio' => ['required', 'unique:equipamentos,patrimonio'],
                'site_equipamento' => ['required'],
                'status' => ['required']
            ],
            [
                'marca.required' => 'A marca deve ser informada.',
                'modelo.required' => 'O modelo deve ser informado.',
                'serial.required' => 'O serial deve ser informado.',
                'patrimonio.required' => 'O patrimonio deve ser informado.',
                'patrimonio.unique' => 'O patrimônio informado já está cadastrado.',
                'site_equipamento.required' => 'O site do equipamento deve ser informado.',
                'status.required' => 'O status deve ser informado.',
            ]
        );
    }

    // CREATE COLABORADOR VALIDATIONS
    public static function validationsColaborador(Request $request)
    {
        $request->validate(
            [
                'nome_colaborador' => ['required'],
                'matricula_colaborador' => ['required', 'unique:colaboradores,matricula_colaborador'],
                'site_colaborador' => ['required'],
                'desativar_em' => ['required', 'date']
            ],
            [
                'nome_colaborador.required' => 'O nome do colaborador deve ser informado.',
                'matricula_colaborador.required' => 'A matrícula do colaborador deve ser informada.',
                'matricula_colaborador.unique' => 'A matrícula informada já está cadastrada.',
                'site_colaborador.required' => 'O site do colaborador deve ser informado.',
                'desativar_em.required' => 'A data de desativação deve ser informada.',
                'desativar_em.date' => 'A data informada não é válida.'
            ]
        );
    }

    //_________________________________________________________________________________________________________


    // UPDATES VALIDATIONS

    // UPDATE PASSWORD VALIDATIONS
    public static function validationsUpdateSenha(Request $request)
    {
        $request->validate(
            [
                'senha' => ['required', 'min: 12', 'regex: /[a-z]/', 'regex: /[A-Z]/', 'regex: /[0-9]/', 'regex: /[!@#$%^&*(),.?":{}|<>]/'],
                'repete_senha' => ['required', 'same:senha']
            ],
            [
                'senha.required' => 'A senha deve ser informada.',
                'senha.min' => 'A senha deve possuir pelo menos :min caracteres',
                'senha.regex' => 'A senha deve possuir pelo menos uma letra maiúscula, uma letra minuscula, um número e um caractere especial.',
                'repete_senha.required' => 'A senha deve ser confirmada.',
                'repete_senha.same' => 'A senhas não conferem.'
            ]
        );
    }

    // UPDATE USER VALIDATIONS
    public static function validationsUpdateUser(Request $request, $id)
    {

        $usuarioAtual = Usuario::where('id', $id)->first();

        $request->validate(
            [
                'nome' => ['required'],
                'usuario' => ['required'],
                'email' => ['required', 'email'],
                'site' => ['required'],
                'perfil' => ['required']
            ],
            [
                'nome.required' => 'O nome deve ser informado.',
                'usuario.required' => 'O usuário deve ser informado.',
                'email.required' => 'O e-mail deve ser informado.',
                'email.email' => 'O e-mail informado não é válido.',
                'site.required' => 'O site deve ser informado.',
                'perfil.required' => 'O perfil deve ser informado.'
            ]

        );

        if ($request->input('usuario') != $usuarioAtual->usuario) {
            $request->validate(
                [
                    'usuario' => ['unique:usuarios,usuario']
                ],
                [
                    'usuario.unique' => 'O usuário informado já está cadastrado.'
                ]
            );
        }
    }

    // UPDATE SITE VALIDATIONS
    public static function validationsUpdateSite(Request $request, $id)
    {
        $siteAtual = Site::where('id', $id)->first();

        $request->validate(
            [
                'descricao' => ['required']
            ],
            [
                'descricao.required' => 'A descrição deve ser informada.',
            ]
        );
        if ($request->input('descricao') != $siteAtual->descricao) {
            $request->validate(
                [
                    'descricao' => ['unique:sites,descricao']
                ],
                [
                    'descricao.unique' => 'O site informado já está cadastrado.'
                ]
            );
        }
    }

    // UPDATE AVARIA VALIDATIONS
    public static function validationsUpdateAvaria(Request $request, $id)
    {
        $avariaAtual = Avaria::where('id', $id)->first();

        $request->validate(
            [
                'avaria' => ['required'],
                'tipo_avaria' => ['required']
            ],
            [
                'avaria.required' => 'A descrição da avaria deve ser informada.',
                'tipo_avaria.required' => 'O tipo da avaria deve ser informado.'
            ]
        );

        if ($request->input('avaria') != $avariaAtual->avaria) {
            $request->validate(
                [
                    'avaria' => ['unique:avarias,avaria']
                ],
                [
                    'avaria.unique' => 'A avaria informada já está cadastrada.'
                ]
            );
        }
    }

    // UPDATE TURNO VALIDATIONS
    public static function validationsUpdateTurno(Request $request, $id)
    {
        $turnoAtual = Turno::where('id', $id)->first();

        $request->validate(
            [
                'turno' => ['required']
            ],
            [
                'turno.required' => 'A descrição do turno deve ser informada.',
            ]
        );

        if ($request->input('turno') != $turnoAtual->turno) {
            $request->validate(
                [
                    'turno' => ['unique:turnos,turno']
                ],
                [
                    'turno.unique' => 'O turno informado já está cadastrado.'
                ]
            );
        }
    }

    // UPDATE DEPARTAMENTO VALIDATIONS
    public static function validationsUpdateDepartamento(Request $request, $id)
    {
        $departamentoAtual = Departamento::where('id', $id)->first();

        $request->validate(
            [
                'departamento' => ['required'],
            ],
            [
                'departamento.required' => 'A descrição do departamento deve ser informada.',
            ]
        );

        if ($request->input('departamento') != $departamentoAtual->departamento) {
            $request->validate(
                [
                    'departamento' => ['unique:departamentos,departamento']
                ],
                [
                    'departamento.unique' => 'O departamento informado já está cadastrado.'
                ]
            );
        }
    }

    // UPDATE EQUIPAMENTO VALIDATIONS
    public static function validationsUpdateEquipamento(Request $request, $id)
    {
        $equipamentoAtual = Equipamento::where('id', $id)->first();

        $request->validate(
            [
                'marca' => ['required'],
                'modelo' => ['required'],
                'serial' => ['required'],
                'patrimonio' => ['required'],
                'site_equipamento' => ['required'],
                'status' => ['required']
            ],
            [
                'marca.required' => 'A marca deve ser informada.',
                'modelo.required' => 'O modelo deve ser informado.',
                'serial.required' => 'O serial deve ser informado.',
                'patrimonio.required' => 'O patrimonio deve ser informado.',
                'site_equipamento.required' => 'O site do equipamento deve ser informado.',
                'status.required' => 'O status deve ser informado.',
            ]
        );

        if ($request->input('serial') != $equipamentoAtual->patrimonio) {
            $request->validate(
                [
                    'patrimonio' => ['unique:equipamentos,patrimonio']
                ],
                [
                    'patrimonio.unique' => 'O patriônio informado já está cadastrado.'
                ]
            );
        }
    }

    // UPDATE COLABORADOR VALIDATIONS
    public static function validationsUpdateColaborador(Request $request, $id)
    {
        $colaboradorAtual = Colaborador::where('id', $id)->first();

        $request->validate(
            [
                'nome_colaborador' => ['required'],
                'matricula_colaborador' => ['required'],
                'site_colaborador' => ['required'],
                'desativar_em' => ['required', 'date']
            ],
            [
                'nome_colaborador.required' => 'O nome do colaborador deve ser informado.',
                'matricula_colaborador.required' => 'A matrícula do colaborador deve ser informada.',
                'site_colaborador.required' => 'O site do colaborador deve ser informado.',
                'desativar_em' => 'A data de desativação deve ser informada.'
            ]
        );

        if ($request->input('matricula_colaborador') != $colaboradorAtual->matricula_colaborador) {
            $request->validate(
                [
                    'matricula_colaborador' => ['unique:colaboradores,matricula_colaborador']
                ],
                [
                    'matricula_colaborador.unique' => 'A matrícula informada já está cadastrada.'
                ]
            );
        }
    }
}
