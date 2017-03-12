<template>
<!-- New Message  -->
<div class="modal is-active" v-if="conversationStore.conversationModal === 'message'" style="white-space: normal; text-align: left;">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <a @click="showConversationList"><i class="fa fa-chevron-left"></i></a>
            <div class="modal-card-title has-text-centered">{{ conversationStore.activeConversation.conversationName }}</div>
            <a @click="closeModal"><i class="fa fa-close"></i></a>
        </header>
        <section class="modal-card-body" ref="list">
   
         
                <nav class="nav" style="position: fixed; z-index: 10;">

                    <div class="nav-center" style="border: none;" v-if="activeUsers.length > 0">
                    <div class="nav-item box">
                    <span class="is-overlay is-paddingless" style="margin-top: -0.9rem; z-index: 0;">Active</span>
                        <a v-for="user in activeUsers" @click="showUserInfo(user.id)" :key="user.id" style="z-index: 1;">
                            <img :src="user.image" >
                        </a>
                     
                    </div>
                     
                  </div>
                </nav>
               
            <br><br><br>
            <div class="chat">

                <li :class="[message.user.id === $root.user.id ? 'self' : 'other']" v-for="message in messages" :key="message.id" >
                    <div class="avatar"><img :src="message.user.image" draggable="false" @click="showUserInfo(message.id)" /></div>

                    <div class="msg">
                        <p>{{message.message}}</p>
                        <time>{{message.readableDate}}</time>
                    </div>
                </li>


            </div>
        </section>
        <footer class="modal-card-foot">
            <input type="text" class="input" maxlength="100" placeholder="Write a message..." v-model="body" @keyup.enter="sendMessage(conversationStore.activeConversation.id)">
        </footer>
    </div>
</div>
</template>

<script>
import {mapState} from 'vuex'
export default {

    data () {
        return {
            body: '',
        }
    },
    mounted () {
        // setInterval(() => {
        //     this.$forceUpdate(); 
        // }, 5000)
    },

    computed: {
        ...mapState({
            conversationStore: state => state.conversationStore
        }),

        messages: function (){
          return _.orderBy(this.conversationStore.activeConversation.latestMessages, ['created_at'], ['asc'])
        },

        activeUsers: function () {
            let state = this.conversationStore;
            for (let i = 0; i < state.conversations.length; i++) {
                if (state.activeUsers[i][0] === undefined) {

                } else {
                    if (state.activeUsers[i][0].conversation_id == state.activeConversation.id) {
                         return state.activeUsers[i];
                    }
                }
            }
        }
        
    },

    watch: {
        messages: function () {
            this.$nextTick(() => {
            const ul = this.$refs.list
            ul.scrollTop = ul.scrollHeight
               this.$el.querySelector('input').focus()
            })
         }
    },

    methods: {
        showConversationList() {
            this.$store.dispatch('showConversationList');
        },

        closeModal() {
            this.$store.dispatch('closeModal');
        },

        showUserInfo(id) {
            alert(id)
        },

        sendMessage(id) {
            if (this.body.trim() !== '') {
                this.$store.dispatch('sendMessage', {id: id, message: this.body});
                this.body = '';
                this.name = '';
            }
        }
    }
}
</script>

<style lang="css" scoped>

    .modal-card {
        height: 844px;
    }
    .media {
        border-bottom: 1px solid #e1e8ed;
    }
    .media:hover {
        background-color: #f5f8fa!important;
        text-decoration: none;
    }

    .chat li {
        padding: 0.5rem;
        overflow: hidden;
        display: flex;
    }

    .avatar:hover {
        cursor: pointer;
    }
    .avatar {
        width: 40px !important;
        height: 40px !important; 
        position: relative;
        display: block;
        z-index: 2;
        border-radius: 100%;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        background-color: rgba(255,255,255,0.9);
    }
     .avatar img {
        width: 40px !important;
        height: 40px !important; 
        border-radius: 100%;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        background-color: rgba(255,255,255,0.9);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .other .msg {
        order: 1;
        border-top-left-radius: 0px;
        box-shadow: -1px 2px 0px #D4D4D4;
    }
    .other:before {
        content: "";
        position: relative;
        top: 0px;
        right: 0px;
        left: 40px;
        width: 0px;
        height: 0px;
        border: 5px solid #fff;
        border-left-color: transparent;
        border-bottom-color: transparent;
    }

    .self {
        justify-content: flex-end;
        align-items: flex-end;
    }
    .self .msg {
        order: 1;
        border-bottom-right-radius: 0px;
        box-shadow: 1px 2px 0px #D4D4D4;
    }
    .self .avatar {
        order: 2;
    }
    .self .avatar:after {
        content: "";
        position: relative;
        display: inline-block;
        bottom: 19px;
        right: 0px;
        width: 0px;
        height: 0px;
        border: 5px solid #fff;
        border-right-color: transparent;
        border-top-color: transparent;
        box-shadow: 0px 2px 0px #D4D4D4;
    }

    .msg {
        background: white;
        min-width: 50px;
        padding: 10px;
        border-radius: 2px;
        box-shadow: 0px 2px 0px rgba(0, 0, 0, 0.07);
    }
    .msg p {
        font-size: 0.8rem;
        margin: 0 0 0.2rem 0;
        color: #777;
    }
    .msg img {
        position: relative;
        display: block;
        width: 450px;
        border-radius: 5px;
        box-shadow: 0px 0px 3px #eee;
        transition: all .4s cubic-bezier(0.565, -0.260, 0.255, 1.410);
        cursor: default;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    @media screen and (max-width: 800px) {
        .msg img {
        width: 300px;
    }
    }
    @media screen and (max-width: 550px) {
        .msg img {
        width: 200px;
    }
    }

    .msg time {
        font-size: 0.7rem;
        color: #ccc;
        margin-top: 3px;
        float: right;
        cursor: default;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    .msg time:before{
        content:"\f017";
        color: #ddd;
        font-family: FontAwesome;
        display: inline-block;
        margin-right: 4px;
    }

    @-webikt-keyframes pulse {
      from { opacity: 0; }
      to { opacity: 0.5; }
    }

    ::-webkit-scrollbar {
        min-width: 12px;
        width: 12px;
        max-width: 12px;
        min-height: 12px;
        height: 12px;
        max-height: 12px;
        background: #e5e5e5;
        box-shadow: inset 0px 50px 0px rgba(82,179,217,0.9), inset 0px -52px 0px #fafafa;
    }

    ::-webkit-scrollbar-thumb {
        background: #bbb;
        border: none;
        border-radius: 100px;
        border: solid 3px #e5e5e5;
        box-shadow: inset 0px 0px 3px #999;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #b0b0b0;
      box-shadow: inset 0px 0px 3px #888;
    }

    ::-webkit-scrollbar-thumb:active {
        background: #aaa;
      box-shadow: inset 0px 0px 3px #7f7f7f;
    }

    ::-webkit-scrollbar-button {
        display: block;
        height: 26px;
    }
</style>
