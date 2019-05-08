import VueRouter from 'vue-router'

// Pages
import Register from './components/Register'
import Login from './components/Login'
import UserProfileContainer from './containers/UserProfileContainer'
import AdminContainer from './containers/AdminContainer'
import MapContainer from './Containers/MapContainer'

// Routes
const routes = [
    {
        path: '/',
        redirect: '/map',
        name: 'homeToMap',
        component: MapContainer,
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
        path: '/map',
        name: 'map',
        component: MapContainer,
        meta: {
            auth: true
        }
    },
    // USER ROUTES
    {
        path: '/user',
        name: 'user',
        component: UserProfileContainer,
        meta: {
            auth: true
        }
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin',
        component: AdminContainer,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
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