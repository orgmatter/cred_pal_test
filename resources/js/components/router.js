import Vue from 'vue';
import VueRouter from 'vue-router';
import { Routes as ROUTES } from './routes';
import AuthResolver from './pages/components/AuthResolver';
import PageNotFound from './pages/components/PageNotFound';

Vue.use(VueRouter);

const routes = [
    {path: ROUTES.index, component: AuthResolver},
    {path: ROUTES.auth.login, component: AuthResolver},
    {path: ROUTES.auth.register, component: AuthResolver},
    {path: ROUTES.auth.refRegister, exact: true, component: AuthResolver},
    {path: ROUTES.dashboard, component: AuthResolver},
    {path: '*', component: PageNotFound}
]

export const router = new VueRouter({
    routes: routes,
    mode: 'history'
});