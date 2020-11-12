export const Auth = {

    check: () => {
        if(localStorage.getItem('authToken') && (localStorage.getItem('isLogin') === 'true')) {
            return true;
        }else {
            return false;
        }
    },
    user: () => {
        if(check()) {
            var user = JSON.parse(localStorage.getItem('users'));
            return user;
        }else {
            return false;
        }
    }
}