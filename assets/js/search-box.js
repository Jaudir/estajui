$(document)
    .ready(function () {
        $('#search-btn')
            .click(function () {
                var cnpj = $('#search').val();
                if (!cnpj) {
                    alert("Insira um cnpj para efetuar a busca!");
                } else {

                    $.ajax({

                        type: "POST",
                        url: "http://localhost/estajui/scripts/controllers/aluno/ajax-busca-empresa.php",
                        data: {
                            search: cnpj
                        },
                        dataType: "json",

                        error: function (jqXHR, textStatus, errorThrown, data) {

                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);

                        },
                        statusCode: {
                            200: function (data) {
                                if(data['erro']){
                                    alert("Empresa Não cadastrada");
                                }else {
                                $("[name='nome_fantasia'").val(data['nome_fantasia']);
                                $("[name='cnpj'").val(data['cnpj']);
                                $("[name='razao_social'").val(data['razao_social']);
                                $("[name='telefone'").val(data['telefone']);
                                $("[name='fax'").val(data['fax']);
                                $("[name='numero_registro'").val(data['numero_registro']);
                                $("[name='conselho_fiscal'").val(data['conselho_fiscal']);
                                $("[name='numero'").val(data['numero']);
                                $("[name='logradouro'").val(data['logradouro']);
                                $("[name='bairro'").val(data['bairro']);
                                $("[name='sala'").val(data['sala']);
                                $("[name='cep'").val(data['cep']);
                                $("[name='cidade'").val(data['cidade']);
                                $("[name='nome_responsavel'").val(data['nome_responsavel']);
                                $("[name='telefone_responsavel'").val(data['telefone_responsavel']);
                                $("[name='email'").val(data['email']);
                                $("[name='cargo_ocupado'").val(data['cargo_ocupado']);
                                $("[name='uf'").val(data['uf']);
                                }
                            }
                        }
                    });
                }
            });
    });