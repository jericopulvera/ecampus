<template>
    <div class="container profile" v-cloak>
      <div class="section profile-heading">
        <div class="columns">
          <div class="column is-2">
            <div class="control">
                
               <a href="#" @click="openFile" v-if="originalImage">
                 <div class="image is-128x128 avatar" title="click to upload new image">
                   <img :src="baseImage">
                 </div>
              </a>
               
                 <div class="image is-128x128 avatar" title="click to upload new image" v-if="! originalImage">
                    <a href="#" @click="openFile" v-if="! originalImage">
                      <img :src="image">
                   </a>
                   <a href="" class="button is-info" v-if="!originalImage" style="width: 100%;" @click.prevent="upload">Upload</a>
                 </div>
            

              
            </div>
    
        

         <input type="file" ref="file" @change="onFileChange" style="display: none;">
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
            this.assignData()
            this.listen()
        },

        data () {
            return {
                originalImage: true,
                baseImage: null,
                image: {},
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
            assignData() {
                this.user = user;
                this.name = user.name;
                this.baseImage = user.image;
            },

            listen() {
                if (window.localStorage.getItem('upload-success')) {
                    noty({ 
                        text: 'Your Avatar has been changed successfully.', 
                        type: 'success',
                        timeout: 2000,
                    });
                    window.localStorage.removeItem('upload-success')
                }
            },

            upload() {
                axios.post('/webapi/upload', {image: this.image}).then(response => {
                    window.localStorage.setItem('upload-success', 1);
                    window.location.reload();
                })
            },

            openFile() {
                this.$refs.file.click();
            },

            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                     if (!files.length)
                       return;
                     this.createImage(files[0]);
            },

            createImage(file) {
                  this.image = new Image();
                  var reader = new FileReader();
                  var vm = this;

                  reader.onload = (e) => {
                    vm.image = e.target.result;
                  };
                  this.originalImage = false
                  reader.readAsDataURL(file);
            },

            editName(event) {
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
