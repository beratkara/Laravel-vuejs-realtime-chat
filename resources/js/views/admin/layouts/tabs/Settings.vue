<template>
    <div>
        <div class="px-4 pt-4">
            <h4 class="mb-0">Settings</h4>
        </div>

        <!-- Start Add contact Modal -->
        <div :class="editModal ? 'modal fade show' : 'modal fade'" :style="editModal ? 'display: block;' : ''" id="addContact-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addContact-exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-size-16" id="addContact-exampleModalLabel">Ayarlarımı Güncelle</h5>
                        <button type="button" class="close" @click="changeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form>
                            <div class="form-group mb-4">
                                <label for="addcontactemail-input">Profile Message</label>
                                <input type="text" class="form-control" v-model="profile_message" id="addcontactemail-input" placeholder="Enter Profile Message">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" @click="changeModal" data-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary" @click="editSettings">Güncelle</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add contact Modal -->

        <div class="text-center border-bottom p-4">
            <div class="mb-4 profile-user">
                <img :src="'/images/users/' + user.settings.profile_picture" class="rounded-circle avatar-lg img-thumbnail" alt="">
                <button type="button" @click="chooseFile()" class="btn bg-light avatar-xs p-0 rounded-circle profile-photo-edit">
                    <i class="ri-pencil-fill"></i>
                </button>
                <input type="file" id="file" ref="file" hidden @change="handleFileUpload">
            </div>

            <h5 class="font-size-16 mb-1 text-truncate">{{ user.settings.name }}</h5>
        </div>
        <!-- End profile user -->

        <!-- Start User profile description -->
        <div class="p-4 user-profile-desc" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">

            <div id="profile-setting-accordion" class="custom-accordion">
                <div class="card shadow-none border mb-2">
                    <a href="#profile-setting-personalinfocollapse" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="profile-setting-personalinfocollapse">
                        <div class="card-header" id="profile-setting-personalinfoheading">
                            <h5 class="font-size-14 m-0">
                                Personal Info
                                <i class="mdi mdi-chevron-up float-right accor-plus-icon"></i>
                            </h5>
                        </div>
                    </a>

                    <div id="profile-setting-personalinfocollapse" class="collapse show" aria-labelledby="profile-setting-personalinfoheading" data-parent="#profile-setting-accordion">
                        <div class="card-body">

                            <div class="float-right">
                                <button type="button" class="btn btn-light btn-sm" @click="changeModal"><i class="ri-edit-fill mr-1 align-middle"></i> Edit</button>
                            </div>

                            <div>
                                <p class="text-muted mb-1">{{ $t("profile.name") }}</p>
                                <h5 class="font-size-14">{{ user.settings.name }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">{{ $t("profile.message") }}</p>
                                <h5 class="font-size-14">{{ user.settings.profile_message }}</h5>
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
                <!-- end profile card -->
            </div>
            <!-- end profile-setting-accordion -->
        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 528px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 93px;"></div></div></div>
        <!-- End User profile description -->
    </div>
</template>

<script>
    import ProfileService from "@services/api/ProfileService";

    export default {
        name: "Settings",
        data() {
            return {
                editModal: false,
                profile_message: '',
            }
        },
        computed: {
            user() {
                return this.$auth.user() || {};
            },
        },
        methods: {
            async handleFileUpload(e){
                if (e.target.files)
                {
                    let file = e.target.files[0];
                    let form = new FormData();
                    form.append('file',file);
                    let query = (new ProfileService).store(form);
                    let {data: response} = await query;

                    this.$auth.fetch({});
                }
            },
            chooseFile()
            {
                document.getElementById("file").click()
            },
            changeModal()
            {
                this.editModal = !this.editModal;
            },
            async editSettings()
            {
                let data = {
                    'profile_message': this.profile_message
                };
                let query = (new ProfileService).update(this.user.settings.uuid,data);
                let {data: response} = await query;
                if(response.data)
                {
                    this.editModal = false;
                    this.$auth.fetch({});
                }
            },
        },
    }
</script>

<style scoped>

</style>
