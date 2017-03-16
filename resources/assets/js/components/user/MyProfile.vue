<template>
    <div class="container profile" v-cloak>
      <div class="section profile-heading">
        <div class="columns">
          <div class="column is-2">
            <div class="image is-128x128 avatar">
              <img :src="user.image">
            </div>
          </div>
          <div class="column is-4 name">
            <p class="control" :class="{'is-loading': loading}">
              <input class="input" :class="{'is-disabled': loading}" v-if="edit.name" v-model="name" @keydown.enter="updateName">
              <span class="title is-bold" @click="editName" title="Double click to edit" v-else>{{ name }} <small> @{{ user.username }} </small></span>
            </p>
            <p>
              <span class="subtitle">{{ user.usn }}</span><br>
            </p>        
          </div>
          <div class="column is-2 followers has-text-centered">
            <p class="stat-val">{{user.followerCount}}</p>
            <p class="stat-key">followers</p>
          </div>
          <div class="column is-2 following has-text-centered">
            <p class="stat-val">{{user.followCount}}</p>
            <p class="stat-key">following</p>
          </div>
          <div class="column is-2 likes has-text-centered">
            <p class="stat-val">{{user.postCount}}</p>
            <p class="stat-key">posts</p>
          </div>
        </div>
      </div>
      <div class="profile-options">
        <div class="tabs is-fullwidth">
          <ul>
            <li class="link" :class="[tab === 2 ? 'is-active' : '']"><a @click="tab = 2"><span class="icon"><i class="fa fa-th"></i></span> <span>My Posts</span></a></li></li>
          </ul>
        </div>
      </div>

      <div class="spacer"></div>
        <my-feed v-cloak v-show="tab === 2"></my-feed>
    </div>

</template>

<script>
    import {Errors} from '../../classes/Errors';

    export default {
        mounted () {
            this.user = user;
            this.name = user.name;
        },

        data () {
            return {
                user: {},
                name: '',
                tab: 2,
                delay: 700,
                clicks: 0,
                timer: null,
                loading: false,
                errors: new Errors(),
                edit: {
                    name: false,
                }
            }
        },

        methods: {
            editName: function(event) {
                this.clicks++ 
                if(this.clicks === 1) {
                   this.timer = setTimeout(() => {
                     this.clicks = 0
                   }, this.delay);
                 } else{

                    Vue.nextTick(() => { 
                        this.edit.name = true;
                    })
                    
                    clearTimeout(this.timer);  
                    this.clicks = 0;
                 }     
            },

            updateName() {
                if (this.name === this.user.name) {
                    return this.edit.name = false;
                }
                if(this.name.trim() != '') {
                    this.loading = true;
                    axios.post('/profile/update-name', {name: this.name}).then((response) => {
                        this.name = response.data;
                        this.loading = false;
                        this.edit.name = false;
                    }).catch(error => {
                        if(error != undefined){ this.errors.record(error.response.data); } 
                        this.loading = false;
                    });
                }
            }
        }
    }
</script>
