$(document).ready(function() {
    //Регистрация
    registration();
    //Логин
    login();
    //Добавить в избранное
    add_favorites();
});

//Регистрация
function registration() {
    let form_registration = $("#frmLogin");
    form_registration.submit(function(e){
        e.preventDefault();
        let form_register_email = $('#frmLogin input[name ="email"]');
        ValidateEmailAndCreateUser(form_register_email.val())
    });
}
// Логин
function login()
{
    let form_login = $("#frmLogin1");
    form_login.submit(function(e){
        e.preventDefault();
        let error = $("#register_error");
        error.empty();
        error.css('display','none');
        let protocol = location.protocol;
        let domain = location.hostname;
        let formData = new FormData($("#frmLogin1")[0]);
        fetch(`${protocol}//${domain}/login`, {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(data => {
                if(data.error){
                    error.append("<p>"+data.error+"</p>");
                    error.css('display','block');
                    return true;
                }
                window.location.href = `${protocol}//${domain}/contacts`;
            }).catch(err=>console.log(err));
    });
}
//Валидация
function ValidateEmailAndCreateUser(inputText)
{
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let error = $("#register_error");
    error.empty();
    error.css('display','none');

    if(inputText.match(mailformat))
    {
        let protocol = location.protocol;
        let domain = location.hostname;
        const formData = new FormData($("#frmLogin")[0]);
        fetch(`${protocol}//${domain}/register`, {
            method: 'POST',
            body: formData
        })
            .then(r => r.json())
            .then(data => {
                 // console.log(data);
                if(data.error){
                    error.append("<p>"+data.error+"</p>");
                    error.css('display','block');
                    return true;
                }
                window.location.href = `${protocol}//${domain}/contacts`;
            }).catch(err=>console.log(err));
    }
    else
    {
        error.append("<p>Вы неверно указали почту</p>");
        error.css('display','block');
        return false;
    }
}
function add_favorites()
{
    let add = $(".addFavor");
    console.log(add);
    add.submit(function(e){
        let protocol = location.protocol;
        let domain = location.hostname;
        e.preventDefault();
        let form = this;
        const formData = new FormData(this);
        fetch(`${protocol}//${domain}/contacts`, {
            method: 'POST',
            body: formData
        })
            .then(r => r.text())
            .then(data => {
               form.closest('tr').remove();
            }).catch(err=>console.log(err));
    })
}