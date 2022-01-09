const addUrl = (postUrl, url) => {
    if(url != ''){
        axios.post(postUrl, {
            url: url
        })
        .then(function (response) {
            if(response.data.status == 'success'){
                iziToast.success({
                    message: response.data.message,
                });
                let url = window.shortenUrl.replace('xxxx',response.data.data.slug);
                $('.shorten-url-div').find('input').val(url)
                $('.shorten-url-div').find('input').attr('title', url);
                $('.shorten-url-div').next('span').find('a').attr('href', url);
                $('.shorten-url-div').removeClass('hide');
            }else{
                iziToast.error({
                    message: response.data.message,
                });
            }
        })
        .catch(function (err) {
            console.log(err);
        })
    }else{
        let message = '';
        if(url == ''){
            message += 'Please enter url first.';
        }
        iziToast.error({
            message: message,
        });
    }
}

const deleteUrl = (deleteUrl) => {
    axios.delete(deleteUrl)
    .then(function (response) {
        if(response.data.status == 'success'){
            iziToast.success({
                message: response.data.message,
            });
            setTimeout(() => {
                window.location.reload();
            }, 1000)
        }else{
            iziToast.error({
                message: response.data.message,
            });
        }
    })
    .catch(function (err) {
        console.log(err);
    })
}

const updateUrl = (updateUrl, url) => {
    axios.put(updateUrl, {
        url: url
    })
    .then(function (response) {
        if(response.data.status == 'success'){
            iziToast.success({
                message: response.data.message,
            });
            setTimeout(() => {
                window.location.reload();
            }, 1000)
        }else{
            iziToast.error({
                message: response.data.message,
            });
        }
    })
    .catch(function (err) {
        console.log(err);
    })
}

document.getElementById("copy-shorten-link").addEventListener('click', function (e) {
    e.preventDefault();
    copyClipboard(document.getElementById('shorten-url'));
});

document.getElementById("copy-access-token").addEventListener('click', function (e) {
    e.preventDefault();
    copyClipboard(document.getElementById('personal-access-token'));
});

$('.update-url-btn').on('click', function(){
    $('#updateLinkModal').find('input#link').val($(this).attr('data-url'));
    $('#updateLinkModal').find('input#link').attr('data-id', $(this).parent('td').parent('tr').attr('data-id'));
    $('#updateLinkModal').modal('show');
})