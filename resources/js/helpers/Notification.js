class Notification{

    Success(message){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: message,
            timeout: 2000,
            progressBar: false
        }).show();
    }

    Alert(message){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: message,
            timeout: 2000,
            progressBar: false
        }).show();
    }

    Error(message){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: message,
            timeout: 2000,
            progressBar: false
        }).show();
    }

    Warning(message){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: message,
            timeout: 2000,
            progressBar: false
        }).show();
    }


}

export default Notification = new Notification();
