let notifications = document.querySelector('.notifications');
    let success = document.getElementById('success');
    let error = document.getElementById('error');
    
    function createToast(type, icon, title, text){
        let newToast = document.createElement('div');
        newToast.innerHTML = `
            <div class="toast ${type}">
                <span class="material-symbols-outlined">${icon}</span>
                <div class="content">
                    <div class="title">${title}</div>
                    <span>${text}</span>
                </div>
                <i class="fa-solid fa-xmark" onclick="(this.parentElement).remove()"></i>
            </div>`;
        notifications.appendChild(newToast);
        newToast.timeOut = setTimeout(
            ()=>newToast.remove(), 5000
        )
    }
    success.onclick = function(){
        let type = 'success';
        let icon = 'check_circle';
        let title = 'Success';
        let text = 'This is a success toast.';
        createToast(type, icon, title, text);
    }
    error.onclick = function(){
        let type = 'error';
        let icon = 'warning';
        let title = 'Error';
        let text = 'This is a error toast.';
        createToast(type, icon, title, text);
    }
   