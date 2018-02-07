
$(document).ready(function() {
    $.mask.definitions['~'] = "[+-]";
    /*$("#data").mask("99/99/9999",{placeholder:"mm/dd/yyyy",completed:function(){alert("completed!");}});*/
    $("#telefone").mask("(99) 9999-9999");
    $("#tel-resp").mask("(99) 9999-9999");
    $("#celular").mask("(99) 9999-9999");
    $("#cpf").mask("999.999.999-99");
    $("#cep").mask("99999-999");
    $("#siape").mask("9999999");
    $("#cnpj").mask("99.999.999/9999-99");
    /*$("#product").mask("a*-999-a999", { placeholder: " " });
    $("#eyescript").mask("~9.99 ~9.99 999");
    $("#po").mask("PO: aaa-999-***");
    $("#pct").mask("99%");
    $("#phoneAutoclearFalse").mask("(999) 999-9999", { autoclear: false, completed:function(){alert("completed autoclear!");} });
    $("#phoneExtAutoclearFalse").mask("(999) 999-9999? x99999", { autoclear: false });
    */$("input").blur(function() {
        $("#info").html("Unmasked value: " + $(this).mask());
    }).dblclick(function() {
        $(this).unmask();
    });
});