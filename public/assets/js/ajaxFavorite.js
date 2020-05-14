let hearthFavorite = $('.hearth-favorite');
for (let i = 0; i < hearthFavorite.length; i++) {
    hearthFavorite[i].addEventListener('click', (e) => {
        let idSheet = hearthFavorite[i].getAttribute('data-sheetId');
        let idUser = hearthFavorite[i].getAttribute('data-userId');
        let formData = new FormData();
        formData.append('sheetId', idSheet);
        formData.append('userId', idUser);
        $.ajax({
            type: 'POST',
            data: formData,
            url: '/ajax/ajaxAddFavorite',
            timeout: 3000,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (data) => {
                if (data) {
                    hearthFavorite[i].classList.remove('far')
                    hearthFavorite[i].classList.add('fas');
                } else {
                    hearthFavorite[i].classList.remove('fas')
                    hearthFavorite[i].classList.add('far');
                }
            }, error: (error) => {
                // TODO redirect to error page;
            }
        })
    })
}
