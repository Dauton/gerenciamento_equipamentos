$(document).ready(function () {

    // BIBLIOTECA Select2
    $('.select2').select2(
        {
            language: "pt-BR"
        }
    );

    // BIBLIOTECA DataTables
    $('.DataTableExcel').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<img src="/assets/img/logo-excel.png" alt="Excel" style="height:20px;">',
                titleAttr: 'Exportar para Excel'
            }
        ],
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "Nenhum registro encontrado",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });

    // BIBLIOTECA DataTables SEM BOTÃO Excel
    $('.DataTable').DataTable({
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "Nenhum registro encontrado",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    });


    // MENU LATERAL
    // AO CLICAR NO BOTÃO HAMBURGUER O MENU LATERAL SERÁ EXIBIDO, JUNTO COM O FUNDO ESCURO...
    var btnMenu = false;
    $("#btn-menu, #back-menu").click(function () {
        if (!btnMenu) {
            $(".menu-lateral").css({
                "left": "0",
                "transition": "left ease-in-out .2s"
            });

            $("#back-menu").fadeIn(200);
            $("#btn-menu").css({ "color": "#f1f1f1" });

            btnMenu = true;

            // AO CLICAR NO BOTÃO DE FECHAR OU NO FUNDO ESCURO ATRÁS DO MENU, O MENU LATERAL SRÁ FECHADO...
        } else {
            $(".menu-lateral, #btn-menu").removeAttr('style').css({ "transition": "left ease-in-out .2s" });
            $("#back-menu").fadeOut(200);
            btnMenu = false;
        }
    });

    // MENU DROPDOWN
    // 01
    $('.menu-active-drop-01').click(function() {
        $('.menu-dropdown-01').slideToggle(200);
        $('.menu-dropdown-02').slideUp(200);
    });

    // 02
    $('.menu-active-drop-02').click(function() {
        $('.menu-dropdown-02').slideToggle(200);
        $('.menu-dropdown-01').slideUp(200);
    });


    // CAIXA DE CONFIRMAÇÃO DE AÇÃO
    $('.float-button-red').click(function () {
        $('.container-alert-confirmacao').fadeIn(100).css({ 'display': 'flex' })
    });
    $('.btn-cancelar-confirmacao').click(function () {
        $('.container-alert-confirmacao').fadeOut(100).css({ 'display': none });
    });

    // AO SELECIONAR O COLABORADOR, AUTOMATICAMENTE OS CAMPOS DEPARTAMENTO E TURNO É PREENCHIDO
    $('#colaborador').select2();

    $('#colaborador').on('change', function () {
        const departamento = $(this).find(':selected').data('departamento') || '';
        $('#departamento').val(departamento);

        const turno = $(this).find(':selected').data('turno') || '';
        $('#turno').val(turno);
    });

    const initialDepartamento = $('#colaborador').find(':selected').data('departamento') || '';
    $('#departamento').val(initialDepartamento);

    const initialTurno = $('#colaborador').find(':selected').data('turno') || '';
    $('#turno').val(initialTurno);

    // MENSAGEM DE ALERTA SOME APÓS 5 SEGUNDOS
    setTimeout(() => {
        let p = document.getElementById("alert-result");
        p.style.opacity = "0";

        setTimeout(() => {
            p.style.display = "none";
        }, 3000);
    }, 5000);

});




// document.getElementById("loginAmazon").addEventListener("input", convert);

// function convert() {
//     var loginAmazon = document.getElementById("loginAmazon").value;

//     if (!loginAmazon || Number(loginAmazon) < 0) {
//         document.getElementById("loginAmazonConvertido").value = "000,00000000000000000000000";
//         return;
//     }

//     var abatrackHexa = Number(loginAmazon).toString(16);
//     if (abatrackHexa.length == 5) {
//         abatrackHexa = "0" + abatrackHexa;
//     }
//     var abaLength = abatrackHexa.length;
//     var abatrackLast4 = abatrackHexa.substring(abaLength - 4);
//     var abatrackRest = abatrackHexa.substring(abaLength - 6, abaLength - 4);
//     var numberOfZeros = 0;
//     for (var i = 0; i < abatrackLast4.length; i++) {
//         if (abatrackLast4.charAt(i) == '0'  ) {
//             numberOfZeros++;
//         } else {
//             break;
//         }
//     }
//     var wiegandEnd = parseInt(abatrackLast4, 16);
//     if (wiegandEnd.toString().length < 5 && numberOfZeros == 0) {
//         numberOfZeros += 5 - wiegandEnd.toString().length;
//     }
//     var wiegandBegin = parseInt(abatrackRest, 16);
//     var wiegandEndZeros = "";
//     for (var i = 0; i < numberOfZeros; i++) {
//         wiegandEndZeros += "0";
//     }
//     var wiegandString = wiegandBegin.toString().padStart(3, '0') + "," + wiegandEndZeros + wiegandEnd.toString().padStart(5, '0');

//     var facilityCode = wiegandString.slice(0, 3);
//     var digitsAfterComma = wiegandString.slice(4);

//     var facilityCodeHex = parseInt(facilityCode).toString(16).toUpperCase();
//     var digitsAfterCommaHex = parseInt(digitsAfterComma).toString(16).toUpperCase();

//     var hexaString = facilityCodeHex.padStart(4, '0') + digitsAfterCommaHex.padStart(4, '0');
//     var decimalString = parseInt(hexaString, 16).toString().padStart(10, '0');

//     // Exibir no input convertido
//     var finalResult = wiegandString + decimalString;
//     document.getElementById("loginAmazonConvertido").value = finalResult;
// }
