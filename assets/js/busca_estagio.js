function preencherModal(id) {
    $.ajax({
        url: "http://localhost/estajui/scripts/controllers/generico/ver-estagio.php",
        type: "post",
        dataType: "json",
        data:{
            estagio_id:id
        },
        success: function(data) {
            var dataItems = "";
            console.log("sucesso!");
            $('#tabela_modal > tbody').empty();
            $.each(data, function (index, itemData) {
                dataItems += index + ": " + itemData["status"] + "\n";
                if (itemData["status"]=="null"){

                    $('#tabela_modal > tbody:last-child').append("Nenhum resultado");
                }else {
                    $('#tabela_modal > tbody:last-child').append("" +
                        "<tr>\n" + "<td>" + "Status:" + "</td>\n" +"<td>" + itemData["status"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "N\º da apólice seguradora:" + "</td>\n" +"<td>" + itemData["apolice_numero"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Nome da seguradora:" + "</td>\n" +"<td>" + itemData["apolice_seguradora"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Supervisor:" + "</td>\n" +"<td>" + itemData["supervisor"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Habilitação profissional:" + "</td>\n" +"<td>" + itemData["supervisor_habilitacao"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Cargo:" + "</td>\n" +"<td>" + itemData["supervisor_cargo"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Professor orientador:" + "</td>\n" +"<td>" + itemData["po"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Formação profissional:" + "</td>\n" +"<td>" + itemData["po_formacao"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Data prevista para ínicio do estágio:" + "</td>\n" +"<td>" + itemData["data_inicio"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Data prevista para término do estágio:" + "</td>\n" +"<td>" + itemData["data_fim"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Jornada:" + "</td>\n" +"<td>Das " + itemData["hora_inicio1"] +" às "+itemData["hora_fim1"]+" e das "+itemData["hora_inicio2"]+" às "+itemData["hora_fim2"]+" totalizando "+itemData["total_horas"]+"</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Principais atividdes a serem desenvolvidas:" + "</td>\n" +"<td>" + itemData["atividades"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Nome fantasia da empresa:" + "</td>\n" +"<td>" + itemData["empresa"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "CNPJ:" + "</td>\n" +"<td>" + itemData["empresa_cnpj"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Telefone:" + "</td>\n" +"<td>" + itemData["empresa_telefone"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "FAX:" + "</td>\n" +"<td>" + itemData["empresa_fax"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Logradouro:" + "</td>\n" +"<td>" + itemData["empresa_logradouro"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Número:" + "</td>\n" +"<td>" + itemData["empresa_numero"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Bairro:" + "</td>\n" +"<td>" + itemData["empresa_bairro"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Cidade:" + "</td>\n" +"<td>" + itemData["empresa_cidade"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Estado:" + "</td>\n" +"<td>" + itemData["empresa_uf"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "CEP:" + "</td>\n" +"<td>" + itemData["empresa_cep"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "N\º de registro da empresa:" + "</td>\n" +"<td>" + itemData["empresa_nregistro"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Conselho de fiscalização:" + "</td>\n" +"<td>" + itemData["empresa_conselhofiscal"] + "</td>\n"+"</tr>");
                }
            });

        }
    });
}


$(document).ready(function(){
    $('#filtrar').click(function(){
        $.ajax({
            url: "http://localhost/estajui/scripts/controllers/generico/listar-estagios.php",
            type: "post",
            dataType:"json",
            data:{
                empresa: $('#inputEmpresa').val(),
                status: $('#inputStatus').val(),
                curso: $('#inputCurso').val(),
                responsavel: $('#inputResponsavel').val(),
                aluno: $('#inputAluno').val(),
                po: $('#inputPo').val(),
                data_ini: $('#inputDataInicio').val(),
                data_fim: $('#inputDataFim').val()
            },
            success: function(data) {
                var dataItems = "";
                $('#tabela > tbody').empty();
                $.each(data, function (index, itemData) {
                    dataItems += index + ": " + itemData["aluno"] + "\n";
                    if (itemData["aluno"]=="null"){

                        $('#tabela > tbody:last-child').append("Nenhum resultado");
                    }else {
                        $('#tabela > tbody:last-child').append("<tr>\n" +
                            "                    <td>" + itemData["aluno"] + "</td>\n" +
                            "                    <td>" + itemData["status"] + "</td>\n" +
                            "                    <td>" + itemData["data_ini"] + "</td>\n" +
                            "                    <td>" + itemData["data_fim"] + "</td>\n" +
                            "                    <td>" + itemData["po"] + "</td>\n" +
                            "                    <td>" + itemData["empresa"] + "</td>\n" +
                            "                    <td>" + itemData["curso"] + "</td>\n" +
                            "                    <td class=\"center\"><a href=\"\" data-toggle=\"modal\" data-target=\"#ver-estagio\" id=\"ver"+itemData["id"]+"\"> <i class=\"fa fa-eye\"></i> </a></td>\n" +
                            "                  </tr>");
                        document.getElementById("ver"+itemData["id"]).onclick = function() {
                            preencherModal(itemData["id"]);

                        };
                    }
                });

            }
        });
    });
});