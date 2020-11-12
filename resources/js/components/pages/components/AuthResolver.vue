<template>
    <div class="pages-container">
        <Login v-if="isView === '/'" />
        <Login v-if="isView === '/auth/login'" />
        <Register v-if="isView === '/auth/register'" />
        <Register v-if="isView === 'ref_code'" />
        <Dashboard v-if="isView === '/dashboard'" />
    </div>
</template>

<script>

import { Auth } from '../../../auth-support/resolve-auth';
import { Routes as ROUTES } from '../../routes';
import Login from './Login';
import Register from './Register';
import Dashboard from './Dashboard/Index';

export default {
    name: "AuthResolver",
    components: {
        Login,
        Register,
        Dashboard
    },
    data: function() {
        return {
            isView: '', 
        }
    },

    mounted: function() {
        this.authMiddleware();
    },
    methods: {
        authMiddleware: function() {
            if((this.$route.path == ROUTES.dashboard) && (Auth.check())) {
                return this.isView = this.$route.path;

            }else if((this.$route.path == ROUTES.dashboard) && (!Auth.check())) {
                window.location = '/auth/login';

            }else if((this.$route.path == '/auth/login') && (Auth.check())) {
                window.location = '/dashboard';

            }else if((this.$route.path == '/auth/login') && (!Auth.check())) {
                return this.isView = this.$route.path;

            }else if((this.$route.path == '/auth/register') && (Auth.check())) {
                window.location = '/dashboard';

            }else if((this.$route.path == '/auth/register') && (!Auth.check())) {
                return this.isView = this.$route.path;

            }else if(((this.$route.path.includes('/auth/register')) && (this.$route.params.ref_code !== '')) && (Auth.check())) {
                window.location = '/dashboard';

            }else if(((this.$route.path.includes('/auth/register')) && (this.$route.params.ref_code !== '')) && (!Auth.check())) {
                return this.isView = 'ref_code';

            }else if((this.$route.path == ROUTES.index) && (Auth.check())) {
                window.location = '/dashboard';

            }else if((this.$route.path == ROUTES.index) && (!Auth.check())) {
                window.location = '/auth/login';
            }
        }
    }
}
</script>