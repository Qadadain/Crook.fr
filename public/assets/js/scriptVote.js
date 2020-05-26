let chevron = $('.chevron');
for (let i = 0; i < chevron.length; i++) {
    chevron[i].addEventListener('click', (e) => {
        let idSheet = chevron[i].getAttribute('data-sheetId');
        let idUser = chevron[i].getAttribute('data-userId');
        let value = chevron[i].getAttribute('data-value');
        let formData = new FormData();
        formData.append('sheetId', idSheet);
        formData.append('userId', idUser);
        formData.append('value', value);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/ajax/ajaxVote',
            timeout: 3000,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (data) => {
                $('#totalVote-'+idSheet).html(data.total);
            }, error: (error) => {
                // TODO redirect to error page;
            }
        })
    })
}