<template>
        <div class="d-lg-flex">

            <!-- start chat conversation section -->
            <div class="w-100">
                <div class="p-3 p-lg-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-8">
                            <div class="media align-items-center">
                                <div class="d-block d-lg-none mr-2">
                                    <a href="javascript: void(0);" @click="closeChat" class="user-chat-remove text-muted font-size-16 p-2"><i class="ri-arrow-left-s-line"></i></a>
                                </div>
                                <div class="mr-3">
                                    <img :src="'/images/users/' + getRemoteUser(chat).profile_picture" class="rounded-circle avatar-xs" alt="">
                                </div>
                                <div class="media-body overflow-hidden">
                                    <h5 class="font-size-16 mb-0 text-truncate"><a href="#" class="text-reset user-profile-show">{{ getRemoteUser(chat).name }}</a>
                                        <template v-if="getRemoteUser(chat).online">
                                            <i class="ri-record-circle-fill font-size-10 text-success d-inline-block ml-1"></i>
                                        </template>
                                        <template v-else>
                                            <i class="ri-record-circle-fill font-size-10 text-gray d-inline-block ml-1"></i>
                                        </template>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-4">
                            <ul class="list-inline user-chat-nav text-right mb-0">

                                <li class="list-inline-item">
                                    <div class="dropdown">
                                        <button class="btn nav-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-search-line"></i>
                                        </button>
                                        <div class="dropdown-menu p-0 dropdown-menu-right dropdown-menu-md">
                                            <div class="search-box p-2">
                                                <input type="text" class="form-control bg-light border-0" placeholder="Search..">
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-inline-item d-none d-lg-inline-block">
                                    <button type="button" class="btn nav-btn user-profile-show">
                                        <i class="ri-user-2-line"></i>
                                    </button>
                                </li>

                                <li class="list-inline-item">
                                    <div class="dropdown">
                                        <button class="btn nav-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-block d-lg-none user-profile-show" href="#">View profile <i class="ri-user-2-line float-right text-muted"></i></a>
                                            <a class="dropdown-item" href="#">Archive <i class="ri-archive-line float-right text-muted"></i></a>
                                            <a class="dropdown-item" href="#">Muted <i class="ri-volume-mute-line float-right text-muted"></i></a>
                                            <a class="dropdown-item" href="#">Delete <i class="ri-delete-bin-line float-right text-muted"></i></a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end chat user head -->

                <!-- start chat conversation -->
                <div class="chat-conversation p-3 p-lg-4" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">
                    <ul class="list-unstyled mb-0" id="chat-list">

                        <template v-for="(item, index) in getMessages">
                            <li :class="item.type === 'current' ? 'right' : ''">
                                <div class="conversation-list">
                                    <div class="chat-avatar">
                                        <img :src="'/images/users/'+item.profile_picture" alt="">
                                    </div>

                                    <div class="user-chat-content">
                                        <div class="ctext-wrap">
                                            <div class="ctext-wrap-content">
                                                <p class="mb-0">
                                                    {{ item.message }}
                                                </p>
                                                <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">{{ item.updated_at }}</span></p>
                                            </div>
                                        </div>
                                        <div class="conversation-name">{{ item.name }}</div>
                                    </div>
                                </div>
                            </li>
                        </template>

                    </ul>
                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1150px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 90px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                <!-- end chat conversation end -->

                <!-- start chat input section -->
                <div class="p-3 p-lg-4 border-top mb-0">
                    <div class="row no-gutters">
                        <div class="col">
                            <div>
                                <form @submit.prevent="setMessage">
                                        <input
                                            type="text"
                                            v-model="message"
                                            class="form-control form-control-lg bg-light border-light"
                                            placeholder="Enter Message..."
                                        >
                                    <div v-if="$v.message.$error" class="alert alert-danger fade show">
                                        <span v-if="!$v.message.required">{{ $t('validations.required') }}</span>
                                        <span v-if="!$v.message.minLength">{{ $t('validations.minLength', [$v.message.$params.minLength.min]) }}</span>
                                        <span v-if="!$v.message.maxLength">{{ $t('validations.maxLength', [$v.message.$params.maxLength.max]) }}</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="chat-input-links ml-md-2">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <button type="button" class="btn btn-link text-decoration-none font-size-16 btn-lg waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Emoji">
                                            <i class="ri-emotion-happy-line"></i>
                                        </button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button type="button" class="btn btn-link text-decoration-none font-size-16 btn-lg waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Attached File">
                                            <i class="ri-attachment-line"></i>
                                        </button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button type="submit" class="btn btn-primary font-size-16 btn-lg chat-send waves-effect waves-light">
                                            <i class="ri-send-plane-2-fill"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end chat input section -->
            </div>
            <!-- end chat conversation section -->
        </div>
</template>

<script>
    import RoomService from "@services/api/RoomService";
    import {maxLength, minLength, required} from "vuelidate/lib/validators";

    export default {
        components: {},
        data() {
            return {
                message: '',
                chat: {},
            }
        },
        props: {
            chatInit: {
                type: Object,
                default: {}
            }
        },
        watch: {
            chatInit: {
                immediate: true,
                handler (val, oldVal) {
                    this.chat = val;
                }
            }
        },
        validations: {
            message: {
                required, minLength: minLength(1), maxLength: maxLength(250)
            },
        },
        computed: {
            getMessages()
            {
                let messages = this.chat.messages.map(item => {
                    item['name'] = item.user[0].name;
                    item['profile_picture'] = item.user[0].profile_picture;
                    if (item.user[0].uuid !== this.$auth.user().settings.uuid)
                        item['type'] = 'remote';
                    else
                        item['type'] = 'current';

                    return item;
                });
                this.$nextTick(() => this.scrollToEnd());
                return messages;
            },
        },
        methods: {
            closeChat: function ()
            {
                this.$emit('userChat', false);
            },
            scrollToEnd: function () {
                const el = this.$el.getElementsByClassName('simplebar-placeholder')[0];

                if (el) {
                    el.scrollIntoView();
                }
            },
            async setMessage(){
                this.$v.$touch();
                if(!this.$v.$invalid)
                {
                    let data = {
                        'message': this.message
                    };
                    let query = (new RoomService).messageStore(this.chat.uuid, data);
                    let {data: items} = await query;
                }
            },
            getRemoteUser(item){
                return item.users.filter(item => (item.uuid !== this.$auth.user().settings.uuid))[0];
            },
            getUser(item){
                return item.users.filter(item => (item.uuid === this.$auth.user().settings.uuid))[0];
            },
        },
        mounted() {
            this.$echo.channel('messages').listen('ChatEvent', (e) => {
                e.message.forEach(item => {
                    if (item.uuid === this.chat.uuid)
                        this.chat = item;
                });

                this.$emit('chatUpdated', e.message[0]);
            });
        }
    };
</script>
