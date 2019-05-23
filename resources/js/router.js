import VueRouter from 'vue-router'

// Pages
import Register from './components/Register'
import Login from './components/Login'
import UserProfile from './components/UserProfile'
import Admin from './components/Admin'
import Map from './components/Map'
import AppContainer from './containers/AppContainer'

// Routes
const routes = [
    {
        path: '/',
        component: AppContainer,
        children: [
            {
                path: 'map',
                name: 'appMap',
                component: Map
            },
            {
                path: 'user',
                name: 'appUser',
                component: UserProfile
            },
            {
                path: 'admin',
                name: 'appAdmin',
                component: Admin,
                meta: {
                    auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
                }
            },
            {
                path: '',
                name: 'appDefault',
                redirect: 'map'
            }
        ],
        meta: {
            auth: true
        }
    },
    {
        path: '/',
        redirect: '/login',
        name: 'homeToLogin',
        component: Login,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '*',
        redirect: '/',
    }
];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router