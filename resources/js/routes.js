import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from "nprogress";

Vue.use(VueRouter);

const GuestLayout = () => import('./views/guest/layouts/GuestLayout');
const GuestLogin = () => import('./views/guest/layouts/GuestLogin');
const GuestForbidden = () => import('./views/guest/layouts/GuestForbidden');
const GuestRegister = () => import('./views/guest/layouts/GuestRegister');

const UnitLayout = () => import('./views/admin/layouts/UnitLayout');
const AdminIndex = () => import('./views/admin/pages/dashboard/Index');

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'green',
    routes: [

        {
            path: '',
            component: GuestLayout,
            meta: {
                auth: false
            },
            redirect: '/login',
            children: [
                {
                    path:'/login',
                    name:'login',
                    component: GuestLogin
                },
                {
                    path:'/forbidden',
                    name:'forbidden',
                    component: GuestForbidden
                },
                {
                    path:'/register',
                    name:'register',
                    component: GuestRegister
                },
            ]
        },

        {
            path: '',
            component: UnitLayout,
            meta: {
                auth: true
            },
            children: [
                {
                    path:'dashboard',
                    name:'admin.dashboard',
                    component: AdminIndex,
                },

            ]
        },

        {
            path: '*',
            redirect: '/dashboard',
            meta: {
                auth: true
            },
        },

    ],
});

router.beforeResolve((to, from, next) => {
    if (to.path) {
        NProgress.start();
    }
    next();
});

router.afterEach((to, from) => {
    NProgress.done();
});

export default router;
