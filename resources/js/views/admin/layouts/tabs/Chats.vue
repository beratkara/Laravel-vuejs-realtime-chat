<template>
    <div>
        <div class="px-4 pt-4">
            <h4 class="mb-4">Chats</h4>
            <div class="search-box chat-search-box">
                <div class="input-group mb-3 bg-light  input-group-lg rounded-lg">
                    <div class="input-group-prepend">
                        <button class="btn btn-link text-muted pr-1 text-decoration-none" type="button">
                            <i class="ri-search-line search-icon font-size-18"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-light" v-model="search" placeholder="Search messages or users">
                </div>
            </div> <!-- Search Box-->
        </div> <!-- .p-4 -->

        <!-- Start chat-message-list -->
        <div class="px-2">
            <h5 class="mb-3 px-3 font-size-16">Recent</h5>

            <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">

                <ul class="list-unstyled chat-list chat-user-list">
                    <template v-for="(item, index) in items.data">
                        <li class="unread">

                            <a href="#" @click="setUserChat(item)">
                                <div class="media">

                                    <div class="chat-user-img online align-self-center mr-3">
                                        <img :src="'/images/users/' + getRemoteUser(item).profile_picture" class="rounded-circle avatar-xs" alt="">
                                        <span class="user-status"></span>
                                    </div>

                                    <div class="media-body overflow-hidden">
                                        <h5 class="text-truncate font-size-15 mb-1">{{ getRemoteUser(item).name }}</h5>
                                        <p class="chat-user-message text-truncate mb-0">{{ getLastMessage(item).message }}</p>
                                    </div>
                                    <div class="font-size-11">{{ getLastMessage(item).ago }}</div>
                                </div>
                            </a>
                        </li>
                    </template>

                </ul>
            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 890px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 65px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>

        </div>
        <!-- End chat-message-list -->
    </div>
</template>

<script>
    import RoomService from "@services/api/RoomService";

    export default {
        name: "Chats",
        props: {
            isChanged: {
                type: Boolean,
                default: false,
            },
            chatInit: {
                type: Object,
                default: {}
            }
        },
        watch: {
            chatInit: {
                immediate: true,
                handler (val, oldVal) {
                    if(val)
                    {
                        this.items.data = this.items.data.map(item => {
                            if (item.name === val.name)
                                return val;
                            else
                                return item;
                        });
                    }
                }
            },
            search: function(val) {
                if (!this.awaitingSearch) {
                    setTimeout(() => {
                        this.list({});
                        this.awaitingSearch = false;
                    }, 1000);
                }
                this.awaitingSearch = true;
            },
            isChanged: function (val) {
                if (val)
                {
                    this.list({});
                }
            }
        },
        data() {
            return {
                page: 1,
                perPage: 10,
                pageOptions: [10, 25, 50, 100],

                search: null,
                awaitingSearch: false,

                orderBy: "name",
                sortedBy: "desc",
                sortDesc : true,

                loading: true,

                items: {
                    data: [],
                    meta: {
                        current_page: 1,
                        per_page: 10,
                        total: 0,
                    }
                },
            }
        },
        computed: {
            user() {
                let user = this.$auth.user() || {};
                this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
                return user;
            },
        },
        methods: {
            setUserChat(user){
                this.$emit('userChat',user);
            },
            async list({page = 1, perPage = 10, orderBy = 'id', sortedBy = 'desc'}) {
                this.loading = true;
                let query = (new RoomService())
                    .paginate(page, perPage)
                    .filter(this.search)
                    .sort(orderBy, sortedBy)
                    .all();

                let {data: items} = await query;

                this.items = items;
                this.loading = false;
            },
            pageChange() {
                this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
            },
            sortChanged(sort) {
                this.perPage = sort.perPage;
                this.orderBy = sort.sortBy;
                this.sortedBy = (sort.sortDesc ? 'desc' : 'asc');
                this.sortDesc = sort.sortDesc;
                this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
            },
            getRemoteUser(item){
                return item.users.filter(item => (item.uuid !== this.$auth.user().settings.uuid))[0];
            },
            getLastMessage(item){
                return item.messages.slice(-1)[0];
            }
        },
        mounted() {
            this.list({page: this.page,perPage: this.perPage, orderBy: this.orderBy, sortedBy: this.sortedBy});
        },
    }
</script>

<style scoped>

</style>
