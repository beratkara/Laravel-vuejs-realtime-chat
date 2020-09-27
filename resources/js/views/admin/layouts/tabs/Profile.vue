<template>
    <div>
        <div class="px-4 pt-4">
            <h4 class="mb-0">My Profile</h4>
        </div>

        <div class="text-center p-4 border-bottom">
            <div class="mb-4">
                <img :src="'/images/users/' + user.settings.profile_picture" class="rounded-circle avatar-lg img-thumbnail" alt="">
            </div>

            <h5 class="font-size-16 mb-1 text-truncate">{{ user.settings.name }}</h5>
            <p class="text-muted text-truncate mb-1">
                <template v-if="user.settings.online">
                    <i class="ri-record-circle-fill font-size-10 text-success mr-1 d-inline-block"></i>
                    {{ $t("profile.active") }}
                </template>
                <template v-else>
                    <i class="ri-record-circle-fill font-size-10 text-gray mr-1 d-inline-block"></i>
                    {{ $t("profile.passive") }}
                </template>
            </p>
        </div>
        <!-- End profile user -->

        <!-- Start user-profile-desc -->
        <div class="p-4 user-profile-desc" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">
            <div class="text-muted">
                <p class="mb-4 text-center">{{ user.settings.profile_message }}</p>
            </div>


            <div id="profile-user-accordion-1" class="custom-accordion">
                <div class="card shadow-none border mb-2">
                    <a href="#profile-user-collapseOne" @click="changeAboutCollapse" class="text-dark" data-toggle="collapse" aria-controls="profile-user-collapseOne">
                        <div class="card-header" id="profile-user-headingOne">
                            <h5 class="font-size-14 m-0">
                                <i class="ri-user-2-line mr-2 align-middle d-inline-block"></i> {{ $t("profile.about") }}
                                <i class="mdi mdi-chevron-down float-right accor-plus-icon" v-if="aboutCollapse"></i>
                                <i class="mdi mdi-chevron-right float-right accor-plus-icon" v-else></i>
                            </h5>
                        </div>
                    </a>

                    <div id="profile-user-collapseOne" :class="aboutCollapse ? 'collapse show' : 'collapse'" aria-labelledby="profile-user-headingOne" data-parent="#profile-user-accordion-1">
                        <div class="card-body">

                            <div>
                                <p class="text-muted mb-1">{{ $t("profile.name") }}</p>
                                <h5 class="font-size-14">{{ user.settings.name }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">{{ $t("profile.email") }}</p>
                                <h5 class="font-size-14">{{ user.settings.email }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">{{ $t("profile.date") }}</p>
                                <h5 class="font-size-14">{{ user.settings.date }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">{{ $t("profile.time") }}</p>
                                <h5 class="font-size-14">{{ user.settings.time }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">{{ $t("profile.last_login") }}</p>
                                <h5 class="font-size-14">{{ user.settings.last_login }}</h5>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End About card -->

                <div class="card mb-1 shadow-none border">
                    <a href="#profile-user-collapseTwo" @click="changeFilesCollapse" class="text-dark collapsed" data-toggle="collapse" aria-controls="profile-user-collapseTwo">
                        <div class="card-header" id="profile-user-headingTwo">
                            <h5 class="font-size-14 m-0">
                                <i class="ri-attachment-line mr-2 align-middle d-inline-block"></i> Attached Files
                                <i class="mdi mdi-chevron-down float-right accor-plus-icon" v-if="filesCollapse"></i>
                                <i class="mdi mdi-chevron-right float-right accor-plus-icon" v-else></i>
                            </h5>
                        </div>
                    </a>
                    <div id="profile-user-collapseTwo" :class="filesCollapse ? 'collapse show' : 'collapse'" aria-labelledby="profile-user-headingTwo" data-parent="#profile-user-accordion-1">
                        <div class="card-body">
                            <div class="card p-2 border mb-2">
                                <div class="media align-items-center">
                                    <div class="avatar-sm mr-3">
                                        <div class="avatar-title bg-soft-primary text-primary rounded font-size-20">
                                            <i class="ri-file-text-fill"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="text-left">
                                            <h5 class="font-size-14 mb-1">Admin-A.zip</h5>
                                            <p class="text-muted font-size-13 mb-0">12.5 MB</p>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <ul class="list-inline mb-0 font-size-18">
                                            <li class="list-inline-item">
                                                <a href="#" class="text-muted px-1">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item dropdown">
                                                <a class="dropdown-toggle text-muted px-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                        </div>

                    </div>
                </div>
                <!-- End Attached Files card -->
            </div>
            <!-- end profile-user-accordion -->

        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 517px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 95px;"></div></div></div>
        <!-- end user-profile-desc -->
    </div>
</template>

<script>
    export default {
        name: "Profile",
        data() {
            return {
                aboutCollapse: true,
                filesCollapse: false,
            }
        },
        computed: {
            user() {
                return this.$auth.user() || {};
            },
        },
        methods: {
            changeAboutCollapse: function ()
            {
                this.filesCollapse = this.aboutCollapse;
                this.aboutCollapse = !this.aboutCollapse;
            },
            changeFilesCollapse: function ()
            {
                this.aboutCollapse = this.filesCollapse;
                this.filesCollapse = !this.filesCollapse;
            },
        },
    }
</script>

<style scoped>

</style>
