/* Article FructCode.com */
$( document ).ready(function() {
    $("#prizebtn").click(
        function(){
            sendAjaxForm('prize-form', 'formtext', 'prize.php');
            return false;
        }
    );
});

function sendAjaxForm(ajax_form, formtext, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "html",
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            console.log(result);
            $('#'+formtext).html('<div class="alert alert-success" role="alert">'+result+'</div>');
        },
        error: function(response) { // Данные не отправлены
            $('#'+formtext).html('<div class="alert alert-warning" role="alert">Ошибка. Приз не получен.</div>');
        }
    });
}