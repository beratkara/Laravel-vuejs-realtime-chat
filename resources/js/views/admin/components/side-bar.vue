<template>
    <div class="side-menu flex-lg-column mr-lg-1">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/images/logo.svg" alt="" height="30">
                        </span>
            </a>

            <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/images/logo.svg" alt="" height="30">
                        </span>
            </a>
        </div>
        <!-- end navbar-brand-box -->

        <!-- Start side-menu nav -->
        <div class="flex-lg-column my-auto">
            <ul class="nav nav-pills side-menu-nav justify-content-center" role="tablist">

                <template v-for="(item, index) in tab">
                    <li class="nav-item" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" :data-original-title="item.title">
                        <a @click.stop.prevent="setActive(item)" :class="item.isActive ? 'nav-link active' : 'nav-link'" :id="item.id + '-tab'" data-toggle="pill" :href="'#'" role="tab" :aria-selected="item.isActive">
                            <i :class="item.icon"></i>
                        </a>
                    </li>
                </template>

            </ul>
        </div>


        <!-- end side-menu nav -->
        <div class="flex-lg-column d-none d-lg-block">
            <ul class="nav side-menu-nav justify-content-center">
                <li class="nav-item btn-group dropup profile-user-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" @click="changeLocalePopup" aria-expanded="false">
                        <template>
                            <img class :src="'/images/flags/' + currentLocales + '.jpg'" alt="Header Language" height="16" />
                        </template>
                    </a>
                    <div v-bind:class="localePopup ? 'dropdown-menu show' : 'dropdown-menu'"  :x-placement="localePopup ? 'top-start' : ''" v-bind:style="localePopup ? 'position: absolute; transform: translate3d(0px, -70px, 0px); top: 0px; left: 0px; will-change: transform;' : ''">
                        <template v-for="(item, index) in availableLocales">
                            <div class="dropdown-item notify-item" style="cursor: pointer" @click="setLanguage(item)">
                                <img :src="'/images/flags/' + item + '.jpg'" alt="user-image" class="mr-1" height="12" />
                                <span class="align-middle">{{ $t("common." + item) }}</span>
                            </div>
                        </template>
                    </div>
                </li>
            </ul>
        </div>

        <!-- end side-menu nav -->
        <div class="flex-lg-column d-none d-lg-block">
            <ul class="nav side-menu-nav justify-content-center">
                <li class="nav-item btn-group dropup profile-user-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" @click="changeUserPopup" aria-expanded="false">
                        <img :src="'/images/users/' + user.settings.profile_picture" alt="" class="profile-user rounded-circle">
                    </a>
                    <div v-bind:class="userPopup ? 'dropdown-menu show' : 'dropdown-menu'"  :x-placement="userPopup ? 'top-start' : ''" v-bind:style="userPopup ? 'position: absolute; transform: translate3d(0px, -50px, 0px); top: 0px; left: 0px; will-change: transform;' : ''">
                        <a class="dropdown-item" @click="logout" href="#">Log out <i class="ri-logout-circle-r-line float-right text-muted"></i></a>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            userPopup: false,
            localePopup: false,
            currentLocales: null,
            availableLocales: null,
        }
    },
    props: {
        tab: {
            type: Array,
            default: []
        }
    },
    computed: {
        user() {
            return this.$auth.user() || {};
        },
    },
    methods: {
        setActive: function (tab)
        {
            this.$emit('updateTab', tab)
        },
        changeUserPopup: function ()
        {
            this.userPopup = !this.userPopup;
        },
        changeLocalePopup: function ()
        {
            this.localePopup = !this.localePopup;
        },
        setLanguage(lang) {
            this.$i18n.locale = lang;
            this.currentLocales = this.$i18n.locale;
            this.localePopup = false;
        },
        logout() {
            this.$auth.logout({
                success: function () {
                },
            })
        },
    },
    created() {
        this.currentLocales = this.$i18n.locale;
        this.availableLocales = this.$i18n.availableLocales;
    }
};
</script>
