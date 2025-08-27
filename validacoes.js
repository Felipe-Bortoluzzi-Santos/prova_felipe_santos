function validarFuncionario() {
    let nome = document.getElementById("nome_funcionario").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;

    if (nome.length < 3) {
        alert("O nome do funcionário deve ter pelo menos 3 caracteres.");
        return false;
    }

    let regexTelefone = /^[0-9]{10,11}$/;
    if (!regexTelefone.test(telefone)) {
        alert("Digite um telefone válido (10 ou 11 dígitos).");
        return false;
    }

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    return true;
}
function mascara(o,f){
    objeto=o
    funcao=f
    setTimeout("executaMascara()",1)
}
function telefone(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/^(\d\d)(\d)/g,"($1) $2")
    variavel=variavel.replace(/(\d{4})(\d)/,"$1-$2")
    return variavel
}
function descricao(variavel){
    variavel=variavel.replace(/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/)
    return variavel;    
}
function letra(variavel){
    variavel=variavel.replace(/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/)
    return variavel;    
}