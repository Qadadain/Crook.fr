let trashSheet = $('.trash-sheet');
for (let i = 0; i < trashSheet.length; i++) {
    trashSheet[i].addEventListener('click', (e) => {
        let id = trashSheet[i].getAttribute('data-id');
        let message = 'Voulez vous vraiment supprimer ce sheet ?'
        if (window.confirm(message)) {
            let formData = new FormData();
            formData.append('id', id);
            $.ajax({
                type: 'POST',
                data: formData,
                url: '/admin/ajaxDeleteSheet',
                timeout: 3000,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: (data) => {
                    let divSuccess = $('#success-delete');
                    divSuccess.addClass('alert alert-success');
                    divSuccess.html(data);
                    trashSheet[i].parentElement.parentElement.remove();
                }, error: (error) => {
                    let divError = $('#success-delete');
                    divError.addClass('alert alert-warning');
                    divError.html(error);
                }
            })
        }
    })
}
