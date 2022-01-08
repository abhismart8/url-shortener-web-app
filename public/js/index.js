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
                // setTimeout(function(){
                //     window.location.reload();
                // }, 1000);
            }else{
                iziToast.error({
                    message: response.data.message,
                });
            }
        })
        .catch(function (err) {
            console.log(err)
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

document.getElementById("clipboard_btn_id").addEventListener('click', function (e) {
    e.preventDefault();
    let element = document.getElementById('shorten-url');
    element.select();
    element.setSelectionRange(0, element.value.length);
    document.execCommand('copy');
    iziToast.success({
        'timeout' : 1000,
        'transitionIn' : 'fadeIn',
        'transitionOut' : 'fadeOut',
        'progressBar': false,
        'ballon' : true,
        'message' : 'Copied to clipboard'
    })
});