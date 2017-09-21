var URL_BASE = 'http://sisodontoonline.com/';

$('.datetimepicker').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    },
    format: 'DD/MM/YYYY H:m:s',
    locale: 'pt-BR'
 });

$('.datepicker').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    },
    format: 'DD/MM/YYYY',
    locale: 'pt-BR'
 });

$('.timepicker').datetimepicker({
    icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
    },
    format: 'H:m:s',
    locale: 'pt-BR'
 });

 $(document).ready(function() {
    $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        responsive: true,
        language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
        }

    });

    $("#datatables_filter").css('float','right');
    $("#datatables_paginate").css('float','right');
    $(".icon_table").css({marginLeft: "50%", marginRight:"50%", cursor:"pointer"});

    $("#cnpj").mask("00.000.000/0000-00");
    $('#telefone').mask('(00) 00000-0000');
    $('#telefone_residencial').mask('(00) 0000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#rg').mask('00.000.000-0');
    $('#cep').mask('00000-000');
    $('#cro').mask('00000000');

    $('#inscricao_estadual').mask('00000000');
    $('#relatorio_inscricao_estadual').mask('00000000');
    $('#agencia').mask('0000-0');
    $('#conta_corrente').mask('00.000-0');
    $('#data_hora').mask('00-00-0000 00:00:00');

    $('#data_hora').mask('00-00-0000 00:00:00');
    $('#relatorio_cnpj').mask('00.000.000/0000-00');

    $('#valor_reembolso').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#capital_social').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#relatorio_capital_social').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#preco').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#relatorio_valor').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#relatorio_protese_valor').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});
    $('#relatorio_med_preco').maskMoney({symbol:'R$ ', showSymbol:true, thousands:'.', decimal:',', symbolStay: true});

    setup_form();

    $("#tipo_usuario").change(function() {
        setup_form();
    });

    $(document).on('dp.change', '#horario_atendimento_inicio, #horario_atendimento_fim', function() {
        checar_horario();
    });

    $("#dias").change(function() {
        checar_horario();
    });
});

 function checar_horario(){
    var dias = $("#dias").val();
    var horario_inicio = $("#horario_atendimento_inicio").val();
    var horario_fim = $("#horario_atendimento_fim").val();
    var request = $.ajax({
      url: URL_BASE+"checar-horario",
      method: "POST",
      data: { dias : dias, horario_atendimento_inicio : horario_inicio, horario_atendimento_fim: horario_fim}
    });
     
    request.done(function(msg) {
        msg = eval(msg);
        if(msg[0].qtd == 1){
            $("#horario-erro").empty();
            $("#horario-erro").css('color','red');
            $("#horario-erro").append('Dias/Horário indisponível');
            $("#btn").prop('disabled','disabled');
        } else {
            $("#horario-erro").empty();
            $("#horario-erro").css('color','green');
            $("#horario-erro").append('Dias/Horário disponível');
            $("#btn").removeAttr('disabled');
        }
    });
 }

$("#usuario_id").ready(function() {
    var tipo = $("#usuario_tipo").val();
    if (tipo == 3) {
        var id = $("#usuario_id").val();
        verificar_dentista_agendado(id);
    }
});
    
 function verificar_dentista_agendado(id){
    var request = $.ajax({
      url: URL_BASE+"checar-dentista",
      method: "POST",
      data: { id : id}
    });

    request.done(function(msg) {
        msg = eval(msg);
        if (msg[0].qtd >= 1) {
            $("#tipo_usuario").prop('disabled','true');
            $("#dias").prop('disabled','true');
            $("#horario_atendimento_inicio").prop('disabled','true');
            $("#horario_atendimento_fim").prop('disabled','true');
            $("#warning").css('display','block');
        }
    });
 }



 function delete_data(id, tipo = 0){
    if (tipo !=0 && (tipo == 3 || tipo == 4)) {
        if (tipo == 3) {
            var url = 'checar-dentista';
        } else if (tipo == 4) {
            var url = 'checar-paciente';
        }
        var request = $.ajax({
          url: URL_BASE+""+url,
          method: "POST",
          data: { id : id}
        });

        request.done(function(msg) {
            msg = eval(msg);
            if (msg[0].qtd >= 1) {
                $("#modal-body-view").empty();
                $("#modal-body-view").append("<p class=\"alert-danger\" style=\"border-radius:5px; padding:5px;\">Este usuário não pode ser deletado! Seus dados estão relacionados a uma agenda.</p>");
                $("#delete_url").prop('disabled', true);
            } else {
                $("#modal-body-view").empty();
                $("#modal-body-view").append("<p>Você está prestes a deletar um usuário.</p>");
                $("#delete_url").prop('disabled', false);
            }
        });
    }

    $("#id").val(id);
 }

 function setup_form(){
    var tipo_usuario = $("#tipo_usuario").val();
    if (tipo_usuario == '4') {
        $("#form_cliente_secretaria").show();
        $("#form_dentista").hide();
        $("#convenios").show();
        $("#fk_convenios").attr('required', true);
        $("#cro").attr('required', false);
        $("#dias").attr('required', false);
        $("#horario_atendimento_inicio").attr('required', false);
        $("#horario_atendimento_fim").attr('required', false);
    } else if (tipo_usuario == '2') {
        $("#form_cliente_secretaria").show();
        $("#form_dentista").hide();
        $("#cro").attr('required', false);
        $("#dias").attr('required', false);
        $("#horario_atendimento_inicio").attr('required', false);
        $("#horario_atendimento_fim").attr('required', false);
        $("#fk_convenios").attr('required', false);
        $("#convenios").hide();
    } else if (tipo_usuario == '3') {
        $("#form_dentista").show();
        $("#form_cliente_secretaria").show();
        $("#nascimento").attr('required',true);
        $("#sexo").attr('required',true);
        $("#rg").attr('required',true);
        $("#telefone_residencial").attr('required',true);
        $("#rua").attr('required',true);
        $("#bairro").attr('required',true);
        $("#numero").attr('required',true);
        $("#cidade").attr('required',true);
        $("#cep").attr('required',true);
        $("#fk_estados").attr('required',true);
        $("#cro").attr('required', true);
        $("#dias").attr('required', true);
        $("#horario_atendimento_inicio").attr('required', true);
        $("#horario_atendimento_fim").attr('required', true);
        $("#fk_convenios").attr('required', false);
        $("#convenios").hide();
    } else {
        $("#form_dentista").hide();
        $("#form_cliente_secretaria").hide();
        $("#cro").attr('required', false);
        $("#dias").attr('required', false);
        $("#horario_atendimento_inicio").attr('required', false);
        $("#horario_atendimento_fim").attr('required', false);
        $("#nascimento").attr('required',false);
        $("#sexo").attr('required',false);
        $("#rg").attr('required',false);
        $("#telefone_residencial").attr('required',false);
        $("#rua").attr('required',false);
        $("#bairro").attr('required',false);
        $("#numero").attr('required',false);
        $("#cidade").attr('required',false);
        $("#cep").attr('required',false);
        $("#fk_estados").attr('required',false);
        $("#fk_convenios").attr('required', false);
    }
 }
    
$("#id_dentistas").change(function() {
    var dias = $("#id_dentistas").val();
    var daysOfWeekDisabled = $("#id_dentistas option:selected").data("dia");
     
    $('#data_hora').datetimepicker({});

    $('#data_hora').data('DateTimePicker').destroy();
    
    $('#data_hora').datetimepicker({
        daysOfWeekDisabled: daysOfWeekDisabled,
        // enabledHours: [9, 10],
        format: 'DD/MM/YYYY H:m:s',
        locale: 'pt-BR'
    });
});

$(document).on('dp.change', '#data_hora', function() {
    checar_agenda();
});

$("#data_hora, #id_pacientes, #id_dentistas").change(function() {
    checar_agenda();
});

function checar_agenda(){
    var data_hora = $("#data_hora").val();
    var id_dentistas = $("#id_dentistas").val();
    var id_pacientes = $("#id_pacientes").val();
    var request = $.ajax({
      url: URL_BASE+"checar-agenda",
      method: "POST",
      data: { data_hora : data_hora, id_dentistas : id_dentistas, id_pacientes : id_pacientes }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            if(msg[0].qtd == 1){
                $("#agenda_data_hora").empty();
                $("#agenda_data_hora").css('color','red');
                $("#agenda_data_hora").append('Já existe uma agenda marcada neste dia.');
                $("#btn").prop('disabled','disabled');
            } else {
                $("#agenda_data_hora").empty();
                $("#agenda_data_hora").css('color','green');
                $("#agenda_data_hora").append('Dia disponível');
                $("#btn").removeAttr('disabled');
            }
        }   
    });
}

$("#tabela_agenda_dentistas, #linha_separadora").css('display','none');

$("#id_dentistas").change(function() {
    $("#tbody").empty();
    var id_dentistas = $("#id_dentistas").val();
    var request = $.ajax({
      url: URL_BASE+"listar-agenda-de-dentistas",
      method: "POST",
      data: { id_dentistas : id_dentistas }
    });

    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            msg.forEach(function(agenda){
                var data_hora= moment(agenda.data_hora).format('DD-MM-YYYY H:m');
                var linha = '<tr>';
                linha += '<td>'+agenda.id+'</td>';
                linha += '<td>'+get_nome(agenda.id_dentistas)+'</td>';
                linha += '<td>'+get_nome(agenda.id_pacientes)+'</td>';
                linha += '<td>'+agenda.tratamentos.nome+'</td>';
                linha += '<td>'+data_hora+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
        $("#tabela_agenda_dentistas, #linha_separadora").css('display','block');
        }   
    });
    
});

function get_nome(nome){
    var n;
    $.ajax({
      url: URL_BASE+"agenda-get-nome",
      method: "POST",
      async: false,
      data: { nome : nome },
      success: function(data) {
        n = data; 
      }
    });
    return n;
}

function get_data(data_hora){
    var n;
    $.ajax({
      url: URL_BASE+"agenda-get-data",
      method: "POST",
      async: false,
      data: { data_hora : data_hora },
      success: function(data_hora) {
        n = data_hora; 
      }
    });
    return n;
}

function get_tratamento(tratamento){
    var n;
    $.ajax({
      url: URL_BASE+"agenda-get-tratamento",
      method: "POST",
      async: false,
      data: { tratamento : tratamento },
      success: function(tratamento) {
        n = tratamento; 
      }
    });
    return n;
}


// request relatorio agenda
$(document).on('dp.change', '#relatorio_data_hora_inicial,#relatorio_data_hora_final', function() {
    relatorio_agenda();
});

$("#relatorio_id_dentistas,#relatorio_id_pacientes,#relatorio_fk_tratamentos").change(function() {
    relatorio_agenda();
});

function relatorio_agenda(){
    $("#tbody").empty();
    var data_hora_inicial = $("#relatorio_data_hora_inicial").val();
    var data_hora_final = $("#relatorio_data_hora_final").val();
    var id_dentistas    = $("#relatorio_id_dentistas").val();
    var id_pacientes    = $("#relatorio_id_pacientes").val();
    var id_tratamentos  = $("#relatorio_fk_tratamentos").val();

    var request = $.ajax({
      url: URL_BASE+"r-agenda",
      method: "POST",
      data: {   data_hora_inicial : data_hora_inicial, 
                data_hora_final : data_hora_final, 
                id_dentistas : id_dentistas, 
                id_pacientes : id_pacientes, 
                fk_tratamentos : id_tratamentos 
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            msg.forEach(function(agenda){
                var data_hora= moment(agenda.data_hora).format('DD-MM-YYYY H:m');
                var linha = '<tr>';
                linha += '<td>'+agenda.id+'</td>';
                linha += '<td>'+get_nome(agenda.id_dentistas)+'</td>';
                linha += '<td>'+get_nome(agenda.id_pacientes)+'</td>';
                linha += '<td>'+get_tratamento(agenda.fk_tratamentos)+'</td>';
                linha += '<td>'+data_hora+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
        }
    });
}

// request relatorio fornecedor
$("#relatorio_nome,#relatorio_capital_social,#relatorio_inscricao_estadual,#relatorio_linha_produto,#relatorio_tipo_empresa,#relatorio_ramo_negocio,#relatorio_natureza_juridica").change(function() {
    relatorio_fornecedor();
});

function relatorio_fornecedor(){
    $("#tbody").empty();
    var nome                    = $("#relatorio_nome").val();
    var capital_social          = $("#relatorio_capital_social").val();
    var inscricao_estadual      = $("#relatorio_inscricao_estadual").val();
    var linha_produto           = $("#relatorio_linha_produto").val();
    var tipo_empresa            = $("#relatorio_tipo_empresa").val();
    var ramo_negocio            = $("#relatorio_ramo_negocio").val();
    var natureza_juridica       = $("#relatorio_natureza_juridica").val();

    var request = $.ajax({
      url: URL_BASE+"r-fornecedor",
      method: "POST",
      data: {   nome : nome, 
                capital_social : capital_social, 
                inscricao_estadual : inscricao_estadual, 
                linha_produto : linha_produto, 
                fk_tipoempresas : tipo_empresa, 
                fk_ramodenegocios : ramo_negocio,
                fk_naturezajuridica : natureza_juridica 
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            msg.forEach(function(fornecedor){
                var linha = '<tr>';
                linha += '<td>'+fornecedor.id+'</td>';
                linha += '<td>'+fornecedor.nome+'</td>';
                linha += '<td>'+fornecedor.capital_social+'</td>';
                linha += '<td>'+fornecedor.inscricao_estadual+'</td>';
                linha += '<td>'+fornecedor.linha_produto+'</td>';
                linha += '<td>'+fornecedor.tipoempresas.nome+'</td>';
                linha += '<td>'+fornecedor.ramodenegocios.nome+'</td>';
                linha += '<td>'+fornecedor.naturezajuridica.nome+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
        }
    });
}

// request relatorio convenios
$("#relatorio_cnpj, #relatorio_razao_social, #relatorio_nome_fantasia").change(function() {
    relatorio_convenio();
});

function relatorio_convenio(){
    $("#tbody").empty();
    var cnpj            = $("#relatorio_cnpj").val();
    var razao_social    = $("#relatorio_razao_social").val();
    var nome            = $("#relatorio_nome_fantasia").val();

    var request = $.ajax({
      url: URL_BASE+"r-convenio",
      method: "POST",
      data: {   nome_fantasia : nome, 
                cnpj : cnpj, 
                razao_social : razao_social
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            msg.forEach(function(conveio){
                var linha = '<tr>';
                linha += '<td>'+conveio.id+'</td>';
                linha += '<td>'+conveio.cnpj+'</td>';
                linha += '<td>'+conveio.razao_social+'</td>';
                linha += '<td>'+conveio.nome_fantasia+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
        }
    });
}

// request relatorio tratamentos
$("#relatorio_tratamento_nome, #relatorio_valor").change(function() {
    relatorio_tratamentos();
});

function relatorio_tratamentos(){
    $("#tbody").empty();
    var nome     = $("#relatorio_tratamento_nome").val();
    var preco    = $("#relatorio_valor").val();

    var request = $.ajax({
      url: URL_BASE+"r-tratamento",
      method: "POST",
      data: {   nome : nome, 
                preco : preco
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            var total = 0;
            msg.forEach(function(tratamento){
                total += parseInt(tratamento.preco.replace(",", "."));
                var linha = '<tr>';
                linha += '<td>'+tratamento.id+'</td>';
                linha += '<td>'+tratamento.nome+'</td>';
                linha += '<td>'+tratamento.descricao+'</td>';
                linha += '<td>R$ '+tratamento.preco+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
            linha = '<tr><td></td><td></td><td></td><td>Total: R$'+total+',00</td></tr>'
            $("#tbody").append(linha);
        }
    });
}


// request relatorio produto protese
$("#relatorio_protese_nome, #relatorio_protese_tipo, #relatorio_protese_valor").change(function() {
    relatorio_protese();
});

function relatorio_protese(){
    $("#tbody").empty();
    var nome    = $("#relatorio_protese_nome").val();
    var tipo    = $("#relatorio_protese_tipo").val();
    var preco   = $("#relatorio_protese_valor").val();

    var request = $.ajax({
      url: URL_BASE+"r-produto-protese",
      method: "POST",
      data: {   nome : nome, 
                tipo : tipo, 
                preco : preco
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            var total = 0;
            msg.forEach(function(tratamento){
                total += parseFloat(tratamento.preco.replace(",", "."));
                var linha = '<tr>';
                linha += '<td>'+tratamento.id+'</td>';
                linha += '<td>'+tratamento.nome+'</td>';
                linha += '<td>'+tratamento.tipo+'</td>';
                linha += '<td>R$ '+tratamento.preco+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
            linha = '<tr><td></td><td></td><td></td><td>Total: R$'+total+'</td></tr>'
            $("#tbody").append(linha);
        }
    });
}

// request relatorio produto medicamento
$("#relatorio_med_nome,#relatorio_med_tarja,#relatorio_med_forma,#relatorio_med_preco ").change(function() {
    relatorio_medicamento();
});

function relatorio_medicamento(){
    $("#tbody").empty();
    var nome    = $("#relatorio_med_nome").val();
    var tarja    = $("#relatorio_med_tarja").val();
    var forma   = $("#relatorio_med_forma").val();
    var preco   = $("#relatorio_med_preco").val();

    var request = $.ajax({
      url: URL_BASE+"r-produto-medicamento",
      method: "POST",
      data: {   nome : nome, 
                tarja : tarja, 
                forma : forma, 
                preco : preco
            }
    });
     
    request.done(function(msg) {
        if (msg == 0) {
        } else {
            msg = eval(msg);
            var total = 0;
            msg.forEach(function(protese){
                total += parseFloat(protese.preco.replace(",", "."));
                var linha = '<tr>';
                linha += '<td>'+protese.id+'</td>';
                linha += '<td>'+protese.nome+'</td>';
                linha += '<td>'+protese.cor_tarja+'</td>';
                linha += '<td>'+protese.forma+'</td>';
                linha += '<td>R$ '+protese.preco+'</td>';
                linha += '</tr>';
                $("#tbody").append(linha);
            })
            linha = '<tr><td></td><td></td><td></td><td></td><td>Total: R$'+total+'</td></tr>'
            $("#tbody").append(linha);
        }
    });
}

$("#relatorio-pdf").click(function() {
    var doc = new jsPDF();
    var width = doc.internal.pageSize.width;    
    var height = doc.internal.pageSize.height;
    
    moment.locale('pt-BR');
    
    var logo = "data:image/png;base64,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pbJRvgOWbft7e/c17ST9wPsEadGmeOYU/2c8xiTyIs1eviU96vyvlFJKKaWeU5fa581072Uv+daU6yCXsGF9G82+a/r31F+19nm1P6w51JrJbM16jdL/fW0jv/NH3/xLayGsm/TzayjLOepH/OMxu7+U3uh6ltcsrVG/Ju5szWlW5r+K/bLc+yNf1jzynPbCM7nOnm0k9145Zw2XezkmsHezJrzbOsuZ64l1j/Vm1pr6ulKF9zrWvUwrbVfH9BmQV16jHqfEeiX3SZe97qUyn6Pul2xvo/7PWhu2Zj++azT2V7zcxy3oI6zzrQk/Vi/sl2Ne/7ch9yEQexl1zLXKtFWm2fMa2bf/E0Gc0f2R/0dlPkd9/j/F/xl/9v6QduKcvRmO+DP/yVgTfmq9+pyXewL4elSn9EG3T17P8sqw0T4T97M/c515j8p8rrbwf99HKZ9QpjwvMdYxfjKW0Z7Xhp9SL8IYN/iPABvTvhBzbfd/H3Nyj/KY//l/IvMo9fvd/7Myn6tj/s+5HTv0fpJ1LfXxKX2Dv4jLPLZV+DG7Zxi25P0652HGcOJi57Q1e534M/coj5WDf2vxIW0nbcqe2cj/ozKf8y7IflvWKX1H3866Yo/RWEXcTK/n1/3Z+8GacMKW6pVh1IO5pPs35/LRNxjP9+dGefUw2kDfi0wbEz/znpW597VLaGm9QD2+9L9SSimllFJKKaWUUkpdTTsRERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERkTvkH4eXjmrZO46cAAABU21rQlT6zsr+AH+lhQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAeJzt1uFpg2AUhlEHcREHcRAXcRAHcREHsbyBC7emIf+KCeeBQ5tP++tNbM5TkiRJkiRJkiRJkiRJkiRJkiRJH9FxHOe+70/nOcu1d/e/uk/3b13XcxzHc5qmx8/sGP0s99S9dRbLsjxexzAMf76HdO+yY5V9s2F2rc37PbV/1Te//o3uX7bre1Y565/lep19+8bZv7pe0/3Lc77vX//X53l+2j/X7P99Zdt67tfv27b9+sz3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bmRvd3M8L3htcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTQtMDItMDVUMjM6MzM6NTZaPC94bXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhtcDpNb2RpZnlEYXRlPjIwMTQtMDItMDVUMjM6Mzk6MTlaPC94bXA6TW9kaWZ5RGF0ZT4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyI+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8P3hwYWNrZXQgZW5kPSJ3Ij8+a0KPtwAAECJJREFUeJzt3bGrHcd+B/CvjEFOeSVw8SoXBsmQQlWKgGxwkbQJseC6fcU7WAbXKQyS4BWpUhikx6Z4VcACOZC/wGALXLwmLgS2wIUrFwZZpa1KKebKlmTp3nPu+c3Z3bOfDwgEupoz9+zu7HdnZmfOPH78OAAA1Hll7AoAAOwbAQsAoJiABQBQTMACACgmYAEAFBOwAACKCVgAAMUELACAYgIW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";
    var data = moment().format('LLLL');
    var title = $('#title').text();

    doc.setFontSize(10);
    doc.text('Relatório de '+data,115,13);
    
    doc.setFontSize(20);
    doc.text(title,5,25);
    
    doc.setFontSize(10);
    doc.addImage(logo, 'PNG', 5, 5, 25, 15);

    var columns = [];
    var rows = [];

    $("#relatorio-table tr").each(function() {
        var arrayOfThisRow = [];
        var tableData = $(this).find('td');
        if (tableData.length > 0) {
            tableData.each(function() { arrayOfThisRow.push($(this).text()); });
            rows.push(arrayOfThisRow);
        }
    });

    $("#relatorio-table tr").each(function(){
        var arrayOfThisRow = [];
        var tableData = $(this).find('th');
        if (tableData.length > 0) {
            tableData.each(function() { arrayOfThisRow.push($(this).text()); });
            columns.push(arrayOfThisRow);
        }
    });

    doc.autoTable(columns[0], rows, {
        theme: 'grid',
        headerStyles: {fillColor: 0},
        margin: {top: 30, left: 5, right: 7}
    });

    doc.text('Equipe Sis Odonto Desenvolvimento - © 2017', 5, height-5);

    doc.save(title+'.pdf');
});