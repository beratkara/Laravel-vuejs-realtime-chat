<template>
    <div class="layout-wrapper d-lg-flex">
        <SideBar :tab.sync="tabs" @updateTab="setActive" />
        <div class="chat-leftsidebar mr-lg-1">
            <SideNav :tab.sync="tabs"
                     :isChanged.sync="isChanged"
                     :chat-init.sync="updatedChat"
                     @userChat="setUserChat"
                     @newMessage="newMessage"/>
        </div>
        <div :class="chat ? 'user-chat w-100 user-chat-show' : 'user-chat w-100'">
            <RightBar :chat-init.sync="chat"
                      @userChat="setUserChat"
                      @chatUpdated="chatUpdated"
                      v-if="chat !== null" />
        </div>
    </div>
</template>

<script>
    import SideBar from "../components/side-bar";
    import SideNav from "../components/side-nav";
    import RightBar from "../components/right-bar";

    export default {
        name: "UnitLayout",
        components: { SideBar, SideNav, RightBar },
        data() {
            return {
                chat: null,
                updatedChat: null,
                tabs: [
                    {
                        title: "Profile",
                        id : "pills-user",
                        icon : "ri-user-2-line",
                        isActive: false
                    },
                    {
                        title: "Chats",
                        id : "pills-chat",
                        icon : "ri-message-3-line",
                        isActive: false
                    },
                    {
                        title: "Contacts",
                        id : "pills-contacts",
                        icon : "ri-contacts-line",
                        isActive: false
                    },
                    {
                        title: "Settings",
                        id : "pills-settings",
                        icon : "ri-settings-2-line",
                        isActive: false
                    },
                ],
                activeTab: {},
                isChanged: false,
            }
        },
        mounted() {
            this.setActive(this.tabs[0]);
        },
        methods: {
            setActive: function (tab) {
                let self = this;
                tab.isActive = true;
                this.activeTab = tab;
                this.tabs.forEach(function (tab) {
                    if (tab.id !== self.activeTab.id) { tab.isActive = false;}
                });
            },
            setUserChat(value){
                this.chat = value;
            },
            newMessage(value){
                this.isChanged = true;
                this.setActive(this.tabs[1]);
            },
            chatUpdated(value){
                this.updatedChat = value;
            }
        },
    }
</script>

<style scoped>

</style>
