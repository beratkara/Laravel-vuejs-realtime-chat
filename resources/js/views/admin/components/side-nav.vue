<template>

    <div class="tab-content">
        <template v-for="(item, index) in tab">
            <div :class="item.isActive ? 'tab-pane active' : 'tab-pane'" :id="item.id" role="tabpanel" :aria-labelledby="item.id + '-tab'">
                <Profile v-if="item.title === 'Profile'"></Profile>
                <Chats v-if="item.title === 'Chats'" :isChanged.sync="isChanged" :chat-init.sync="updateChat" @userChat="setUserChat"></Chats>
                <Contacts v-if="item.title === 'Contacts'" @newMessage="newMessage"></Contacts>
                <Settings v-if="item.title === 'Settings'"></Settings>
            </div>
        </template>
    </div>

</template>


<script>
    import Profile from "../layouts/tabs/Profile";
    import Chats from "../layouts/tabs/Chats";
    import Contacts from "../layouts/tabs/Contacts";
    import Settings from "../layouts/tabs/Settings";

    export default {
        components: {Profile, Chats, Contacts, Settings},
        props: {
            tab: {
                type: Array,
                default: []
            },
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
                handler(val, oldVal) {
                    if (val)
                        this.updateChat = val;
                    else
                        this.updateChat = null;
                }
            },
        },
        mounted: function () {

        },
        methods: {
            setUserChat(value){
                this.$emit('userChat',value);
            },
            newMessage(value){
                this.$emit('newMessage',value);
            },
        },
        data: function () {
            return {
                updateChat: null,
            }
        },
        computed: {

        }
    };
</script>
