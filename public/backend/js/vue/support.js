function showToast(message = '', position = 'top-right'){
    $.toast({
        text : message,
        showHideTransition : 'slide',
        textColor : '#eee',
        allowToastClose : false,
        hideAfter : 5000,
        stack : 5,
        textAlign : 'left',
        position : position
    })
}

function httpReq(url, method, data, callback = false){
    axios({
        method: method,
        url: url,
        data: data
    }).then(function (response) {
        if (typeof callback === 'function'){
            callback(response.data)
        }
    }).catch(function (error) {
            console.log(error);
        });

}
