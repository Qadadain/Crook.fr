const incrementLimit = 10;

$(() => {
    $('#next').on('click', (e) => {
        e.preventDefault();
        let limit = $("#next").val();
        $.ajax({
            type: 'GET',
            url: "changeLanguage/" + limit,
            timeout: 3000,
            dataType: 'html',
            success: (data) => {
                $("#languageTable").html(data);
                limit = Number(limit) + incrementLimit;
                $("#next").val(limit);
                if ($('#lengthTable').val() !== 10) {
                    $("#next").css('display', 'none');
                }
                if (limit > 10) {
                    $("#previous").css('display', 'block');
                }
            },
            error : (error) => {
                console.log("Une erreur s'est produite");
            }
        })
    });
    $('#previous').on('click', (e) => {
        e.preventDefault();
        let limit = $("#previous").val();
        let nextValue = $("#next").val();
        $.ajax({
            type: 'GET',
            url: "changeLanguage/" + limit,
            timeout: 3000,
            dataType: 'html',
            success: (data) => {
                console.log(data);
                $("#languageTable").html(data);
                limit = Number(limit) - incrementLimit;
                if ($('#previous').val() - incrementLimit < 0) {
                    $("#previous").val(0);
                } else {
                    $("#previous").val(limit);
                }
                if (limit < incrementLimit) {
                    $("#previous").css('display', 'none');
                    $("#next").css('display', 'unset');
                    $("#next").val(nextValue - incrementLimit);
                } else {
                    $("#previous").css('display', 'unset');
                }
            },
            error : (error) => {
                console.log("Une erreur s'est produite");
            }
        })
    })
})


