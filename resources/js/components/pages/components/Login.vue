<template>
    <div class="login-container">
        <div class="login-cover-flex">
            <div class="login-cover-item">
                <div class="parent-login-form-cover-flex">
                    <div class="parent-login-form-cover-item">
                        <div class="form-header-cover">
                            <p class="form-header-title">Login</p>
                        </div>
                        <div class="login-form-cover-flex">
                            <div class="login-form-cover-item">
                                <form class="login-form" id="login_form" method="POST" v-on:submit="handleSubmit">
                                    <div class="login-input-cover">
                                        <div class="alert alert-success" v-if="loginData.isLogin">
                                            <span>{{ loginData.msg }}</span>
                                        </div>
                                        <div class="login-input-flex">
                                            <div class="login-input-item">
                                                <label for="email-input" >Email:</label><br />
                                                <input class="login-input" id="email-input" type="text" name="email" v-model="inputFields.email" v-on:change="handleInputChange" placeholder="Email" required />
                                            </div>
                                            <div class="login-input-item">
                                                <label for="password-input">Password:</label><br />
                                                <input class="login-input" id="password-input" type="password" name="password" v-model="inputFields.password" v-on:change="handleInputChange" placeholder="Email" required />
                                            </div>
                                        </div>
                                        <div class="submit-btn-flex">
                                            <div class="submit-btn-item">
                                                <button class="submit-btn btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-footer-cover-flex">
                            <div class="form-footer-cover-item"></div>
                            <div class="form-footer-cover-item">
                                <a href="/auth/register">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data: () => {
        return {
            loginData: {
                msg: '',
                isLogin: '',
            },
            inputFields: {
                email: '',
                password: ''
            }
        }
    },
    mounted: {
        
    },
    methods: {
        handleSubmit: function(e) {
            e.preventDefault();
            fetch('/api/auth/login', {
                method: 'POST',
                body: JSON.stringify(this.inputFields),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(loginRes => loginRes.json())
            .then(loginData => {
                console.log('loginData: ', loginData);
                const { msg, isLogin, token, expires } = loginData;

                this.loginData.msg = msg;
                this.loginData.isLogin = isLogin;

                localStorage.setItem('authToken', token);
                localStorage.setItem('isLogin', isLogin);

                window.location = '/dashboard';
            })
            .catch(() => {
                localStorage.clear();
            })
        },
        handleInputChange: function(e) {
            return this.inputFields[e.target.name] = e.target.value
        }
    },
}
</script>