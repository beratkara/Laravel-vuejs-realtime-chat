<template>
    <div>
        <div class="p-4">
            <div class="user-chat-nav float-right">
                <div data-toggle="tooltip" @click="changeAddContact" data-placement="bottom" title="" data-original-title="Add Contact">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-link text-decoration-none text-muted font-size-18 py-0" data-toggle="modal" data-target="#addContact-exampleModal">
                        <i class="ri-user-add-line"></i>
                    </button>
                </div>
            </div>
            <h4 class="mb-4">Contacts</h4>

            <!-- Start Add contact Modal -->
            <div :class="contactModal ? 'modal fade show' : 'modal fade'" :style="contactModal ? 'display: block;' : ''" id="addContact-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addContact-exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-size-16" id="addContact-exampleModalLabel">Add Contact</h5>
                            <button type="button" class="close" @click="changeAddContact" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form>
                                <div class="form-group mb-4">
                                    <label for="addcontactemail-input">Email</label>
                                    <input type="email" class="form-control" v-model="email" id="addcontactemail-input" placeholder="Enter Email">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" @click="changeAddContact" data-dismiss="modal">Kapat</button>
                            <button type="button" class="btn btn-primary" @click="addContacts">İletişim Listeme Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add contact Modal -->

            <!-- Start Add chat Modal -->
            <div :class="chatModal ? 'modal fade show' : 'modal fade'" :style="chatModal ? 'display: block;' : ''" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-size-16">Mesaj Gönder</h5>
                            <button type="button" class="close" @click="changeAddChat" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form>
                                <div class="form-group mb-4">
                                    <label for="user">Kullanıcı</label>
                                    <input type="text" id="user" class="form-control" v-model="chatUser.name" disabled readonly>
                                </div>
                                <div class="form-group">
                                    <label for="chat-message">Mesaj</label>
                                    <textarea class="form-control" id="chat-message" v-model="message" rows="3" placeholder="Enter Message"></textarea>
                                    <div v-if="$v.message.$error" class="alert alert-danger fade show">
                                        <span v-if="!$v.message.required">{{ $t('validations.required') }}</span>
                                        <span v-if="!$v.message.minLength">{{ $t('validations.minLength', [$v.message.$params.minLength.min]) }}</span>
                                        <span v-if="!$v.message.maxLength">{{ $t('validations.maxLength', [$v.message.$params.maxLength.max]) }}</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" @click="changeAddChat" data-dismiss="modal">Kapat</button>
                            <button type="button" class="btn btn-primary" @click="addChat">Gönder</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Add chat Modal -->

            <div class="search-box chat-search-box">
                <div class="input-group bg-light  input-group-lg rounded-lg">
                    <div class="input-group-prepend">
                        <button class="btn btn-link text-decoration-none text-muted pr-1" type="button">
                            <i class="ri-search-line search-icon font-size-18"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-light " placeholder="Search users.." v-model="search">
                </div>
            </div>
            <!-- End search-box -->
        </div>
        <!-- end p-4 -->

        <!-- Start contact lists -->
        <div class="p-4 chat-message-list chat-group-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">

            <div>
                <ul class="list-unstyled contact-list">
                    <template>
                        <li v-for="(item, index) in contacts">
                            <div class="media align-items-center">
                                <div class="media-body" @click="addChatModal(item)">
                                    <h5 class="font-size-14 m-0">{{ item.name }}</h5>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
            <!-- end contact list A -->


        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1584px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 82px;"></div></div></div>
        <!-- end contact lists -->
    </div>
</template>

<script>
    import UserService from "@services/api/UserService";
    import RoomService from "@services/api/RoomService";
    import {maxLength, minLength, required} from "vuelidate/lib/validators";

    export default {
        name: "Contacts",
        data() {
            return {
                contacts: {},
                contactModal: false,
                chatModal: false,
                email: null,
                chatUser: {},
                message: null,

                search: null,
            }
        },
        validations: {
            message: {
                required, minLength: minLength(1), maxLength: maxLength(250)
            },
        },
        methods: {
            async getContacts()
            {
                let query = (new UserService).all();
                let {data: response} = await query;
                this.contacts = response.data;
            },
            changeAddContact()
            {
                this.contactModal = !this.contactModal;
            },
            changeAddChat()
            {
                this.chatModal = !this.chatModal;
                if(!this.chatModal)
                    this.chatUser = {};
            },
            async addContacts()
            {
                let data = {
                    'email': this.email
                };
                let query = (new UserService).store(data);
                let {data: response} = await query;
                if(response.data)
                {
                    this.contactModal = false;
                    await this.getContacts();
                }
            },
            addChatModal(user)
            {
                this.chatModal = true;
                this.chatUser = user;
            },
            async addChat()
            {
                this.$v.$touch();
                if(!this.$v.$invalid)
                {
                    let data = {
                        'message': this.message,
                        'user': this.chatUser.uuid,
                    };
                    let {data: response} = await (new RoomService).store(data);
                    if (response)
                    {
                        this.chatModal = false;
                        this.chatUser = {};
                        this.$emit('newMessage', true);
                    }
                }
            },
        },
        mounted() {
            this.getContacts();
        }
    }
</script>

<style scoped>

</style>
