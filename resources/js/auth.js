import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'dashboard_session',
    tokenStore: ['localStorage'],
    authRedirect: {name: 'login'},
    registerData: {url: "auth/register", method: 'POST', redirect: '/login'},
    loginData: {url: "auth/login", method: 'POST', redirect: '/dashboard', fetchUser: true},
    logoutData: {url: "auth/logout", method: 'POST', redirect: '/login', makeRequest: true},
    fetchData: {url: "auth/settings", method: 'GET', enabled: true},
    refreshData: {url: "auth/refresh", method: 'GET', enabled: true, interval: 30},
    rolesKey: 'permissions',
    parseUserData: (data) => {
        data['settings'] = data.data;
        data['roles'] = data.data.has_role_permissions.map((roles) => roles.slug);
        data['permissions'] = data.data.has_role_permissions.map(
            (items) => items.permissions.map(
                (permissions) => permissions.slug
            )
        ).values().next().value;
        return data;
    }
};
export default config

/*
rolesKey:            'roles',
    rememberKey:         'auth_remember',
    staySignedInKey:     'auth_stay_signed_in',
    tokenDefaultKey:     'auth_token_default',
    tokenImpersonateKey: 'auth_token_impersonate',
    stores:              ['storage', 'cookie'],

    cookie: {
        Path:     '/',
        Domain:   null,
        Secure:   true,
        Expires:  12096e5,
        SameSite: 'None',
    },

    // Redirects

    authRedirect:       {path: '/login'},
    forbiddenRedirect:  {path: '/403'},
    notFoundRedirect:   {path: '/404'},

    // Http

    registerData:       {url: 'auth/register',      method: 'POST', redirect: '/login',                  autoLogin: false           },
    loginData:          {url: 'auth/login',         method: 'POST', redirect: '/',      fetchUser: true, staySignedIn: true         },
    logoutData:         {url: 'auth/logout',        method: 'POST', redirect: '/',                       makeRequest: false         },
    fetchData:          {url: 'auth/user',          method: 'GET',                                       enabled: true              },
    refreshData:        {url: 'auth/refresh',       method: 'GET',                                       enabled: true, interval: 30},
    impersonateData:    {url: 'auth/impersonate',   method: 'POST', redirect: '/',      fetchUser: true                             },
    unimpersonateData:  {url: 'auth/unimpersonate', method: 'POST', redirect: '/admin', fetchUser: true, makeRequest: false         },
    oauth2Data:         {url: 'auth/social',        method: 'POST', redirect: '/',      fetchUser:true                              },

    // External

    getUrl: _getUrl,
    getCookieDomain: _getCookieDomain,
    parseUserData: _parseUserData
 */
