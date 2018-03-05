id = -1;

function preencherModalEditarAprov(id) {
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
            $('#tabela_modal_editar > tbody').empty();
            $.each(data, function (index, itemData) {
                dataItems += index + ": " + itemData["status"] + "\n";
                if (itemData["status"]=="null"){

                    $('#tabela_modal_editar > tbody:last-child').append("Nenhum resultado");
                }else {
                    var obg = "Sim";
                    if (itemData["bool_obrigatorio"] == 0){
                        obg = "Não";
                    }

                    $('#tabela_modal_editar > tbody:last-child').append("" +
                        "<tr>\n" + "<td>" + "Nome do aluno:" + "</td>\n" +"<td>" + itemData["aluno"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Matrícula:" + "</td>\n" +"<td>" + itemData["matricula"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Curso:" + "</td>\n" +"<td>" + itemData["curso"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Obrigatório:" + "</td>\n" +"<td>" + obg + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Nome fantasia da empresa:" + "</td>\n" +"<td>" + itemData["empresa"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "CNPJ:" + "</td>\n" +"<td>" + itemData["empresa_cnpj"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Telefone:" + "</td>\n" +"<td>" + itemData["empresa_telefone"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "N\º de registro da empresa:" + "</td>\n" +"<td>" + itemData["empresa_nregistro"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Conselho de fiscalização:" + "</td>\n" +"<td>" + itemData["empresa_conselhofiscal"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Professor orientador:" + "</td>\n" +"<td>" + itemData["po"] + "</td>\n"+"</tr>");

                }
            });

        }
    });
}

function preencherModalEditar(id) {
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
            $('#tabela_modal_editar_aprov > tbody').empty();
            $.each(data, function (index, itemData) {
                dataItems += index + ": " + itemData["status"] + "\n";
                if (itemData["status"]=="null"){

                    $('#tabela_modal_editar_aprov > tbody:last-child').append("Nenhum resultado");
                }else {
                    var obg = "Sim";
                    if (itemData["bool_obrigatorio"] == 0){
                        obg = "Não";
                    }

                    $('#tabela_modal_editar_aprov > tbody:last-child').append("" +
                        "<tr>\n" + "<td>" + "Nome do aluno:" + "</td>\n" +"<td>" + itemData["aluno"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Matrícula:" + "</td>\n" +"<td>" + itemData["matricula"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Curso:" + "</td>\n" +"<td>" + itemData["curso"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Obrigatório:" + "</td>\n" +"<td>" + obg + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Nome fantasia da empresa:" + "</td>\n" +"<td>" + itemData["empresa"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "CNPJ:" + "</td>\n" +"<td>" + itemData["empresa_cnpj"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Telefone:" + "</td>\n" +"<td>" + itemData["empresa_telefone"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "N\º de registro da empresa:" + "</td>\n" +"<td>" + itemData["empresa_nregistro"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Conselho de fiscalização:" + "</td>\n" +"<td>" + itemData["empresa_conselhofiscal"] + "</td>\n"+"</tr>"+
                        "<tr>\n" + "<td>" + "Professor orientador:" + "</td>\n" +"<td>" + itemData["po"] + "</td>\n"+"</tr>");

                }
            });

        }
    });
    preencherModalEditarAprov(id);
}

function setarId(rowid) {
    id = document.getElementById(rowid).value;
    console.log("id == "+id);
    preencherModalEditar(id);
}

function preencherDadosApolice() {
    var apolice = document.getElementById("validationCustom01").value;
    var seguradora = document.getElementById("validationCustom02").value;
    console.log("apolice = "+apolice+"   -   seguradora = "+seguradora);
    $.ajax({
        url: "http://localhost/estajui/scripts/controllers/coordenador-extensao/preencher-dados-apolice.php",
        type: "post",
        dataType: "json",
        data: {
            apolice_numero:apolice,
            estagio_id: id,
            apolice_seguradora:seguradora
        },
        statusCode: { 200: function(data) { console.log(""); }},
        success: function(data) {console.log("")}
    });
}