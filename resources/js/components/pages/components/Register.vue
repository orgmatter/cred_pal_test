<template>
    <div class="register-container">
        <div class="register-cover-flex">
            <div class="register-cover-item">
                <div class="parent-register-form-cover-flex">
                    <div class="parent-register-form-cover-item">
                        <div class="form-header-cover">
                            <p class="form-header-title">Register</p>
                        </div>
                        <div class="register-form-cover-flex">
                            <div class="register-form-cover-item">
                                <form class="register-form" id="register_form" method="POST" v-on:submit="handleSubmit">
                                    <div class="register-input-cover">
                                        <div class="alert alert-success" v-if="registerData.response.isRegister">
                                            <span>{{ registerData.response.msg }} You may <a href="/auth/login">Login</a> now</span>
                                        </div>
                                        <div class="register-input-flex">
                                            <div class="register-input-item">
                                                <label for="firstname-input" >Firstname:</label><br />
                                                <input class="register-input" id="firstname-input" type="text" name="firstname" v-model="registerData.inputFields.firstname" v-on:change="handleInputChange" placeholder="Firstname" required />
                                            </div>
                                            <div class="register-input-item">
                                                <label for="lastname-input" >Lastname:</label><br />
                                                <input class="register-input" id="lastname-input" type="text" name="lastname" v-model="registerData.inputFields.lastname" v-on:change="handleInputChange" placeholder="Lastname" required />
                                            </div>
                                            <div class="register-input-item">
                                                <label for="email-input" >Email:</label><br />
                                                <input class="register-input" id="email-input" type="text" name="email" v-model="registerData.inputFields.email" v-on:change="handleInputChange" placeholder="Email" required />
                                            </div>
                                            <div class="register-input-item">
                                                <label for="password-input">Password:</label><br />
                                                <input class="register-input" id="password-input" type="password" name="password" v-model="registerData.inputFields.password" v-on:change="handleInputChange" placeholder="Password" required />
                                            </div>
                                        </div>
                                        <div class="submit-btn-flex">
                                            <div class="submit-btn-item">
                                                <button class="submit-btn btn btn-primary" type="submit">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-footer-cover-flex">
                            <div class="form-footer-cover-item"></div>
                            <div class="form-footer-cover-item">
                                <a href="/auth/login">Login</a>
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
    name: "Register",
    data: function() {
        return {
            registerData: {
                response: {
                    isRegister: '',
                    msg: ''
                },
                inputFields: {
                    firstname: '',
                    lastname: '',
                    email: '',
                    password: ''
                }
            }
        }
    },
    mounted: function() {

    },
    methods: {
        handleSubmit: function(e) {
            e.preventDefault();
            var refCode = this.$route.params.ref_code;
            var empty = '';
            var url = refCode !== empty ? `/api/auth/register/${refCode}` : `/api/auth/register`;

            fetch(url, {
                method: 'POST',
                body: JSON.stringify(this.registerData.inputFields),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(registerRes => registerRes.json())
            .then(regData => {
                const { msg, isRegister } = regData;
                this.registerData.response.msg = msg;
                this.registerData.response.isRegister = isRegister;
            })
        },
        handleInputChange: function(e) {
            e.preventDefault();

            this.registerData.inputFields[e.target.name] = e.target.value;
        }
    },
}
</script>