const incrementLimit = 10;

$(function () {
    $('#next').on('click', (e) => {
        e.preventDefault();
        let limit = $("#next").val();
        $.ajax({
            type: 'GET',
            url: "changeLanguage/" + limit,
            timeout: 3000,
            dataType: 'html',
            success:function (data) {
                $("#test").html(data);
                limit = Number(limit) + incrementLimit;
                $("#next").val(limit);
            },
            error : (error) => {
                console.log("Une erreur c'est produite");
            }
        })
    })
})
