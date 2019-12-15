/* Article FructCode.com */
$( document ).ready(function() {
    $("#prizebtn").click(
        function(){
            sendAjaxForm('prize-form', 'prize.php');
            return false;
        }
    );
});

function sendAjaxForm(ajax_form, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "html",
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#ajax_form').append('<div class="alert alert-warning" role="alert">'+result+'</div>');
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').append('Ошибка. Приз не получен.');
        }
    });
}