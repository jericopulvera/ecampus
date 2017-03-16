<template>
<nav class="nav has-shadow is-fixed">
	<div class="container">
		<div class="nav-left">
			<a href="/" class="nav-item is-tab" :class="$root.path == '/' ? 'is-active' : ''"><i class="fa fa-home"></i> &nbsp; Home</a>
			<notification-tab :class="$root.path == 'notifications' ? 'is-active' : ''"></notification-tab>
			<message-tab  :class="activeConversationClass"></message-tab>
		</div>
		<div class="nav-center">
			<a class="nav-item" href="/">
				<img class="is-paddingless is-marginless"src="/dist/img/logo.PNG" style="width: 21px; height: 21px;">
			</a>
		</div>
		
    <!-- MOBILE TABLET TOGGLE -->
    <span class="nav-toggle" @click="showMobileOptions">
        <span></span>
        <span></span>
        <span></span>
    </span>
    
    <div class="nav-menu is-hidden-desktop" :class="{ 'is-active': mobileExpand }">
        <span class="nav-item">
            <a class="button" @click="toggleForm">
                <span class="icon">
                    <i class="fa fa-pencil-square-o"></i>
                </span>
                <span>New Post</span>
            </a>
        </span>
        <a class="nav-item" :href="'/admin/dashboard'" v-if="$root.user.privilege == 'Dean'">Admin Panel</a>
        <a class="nav-item" :href="'/'+$root.user.usn"> My Profile </a>
        <a class="nav-item" :href="'/schedule/'+$root.user.usn" v-if="$root.user.privilege != 'Student'"> My Schedule </a>
        <a class="nav-item" href="/calendar"> School Calendar </a>
        <a class="nav-item" href="/groups"> Groups </a>
        <a class="nav-item" @click="logout()"> Log out </a>
    </div>

    <div class="nav-right nav-menu">
        <search-tab></search-tab>
        
        <span class="nav-item">
            <a class="button" @click="toggleForm">
                <span class="icon">
                    <i class="fa fa-pencil-square-o"></i>
                </span>
                <span>New Post</span>
            </a>
        </span>

        <click-outside :handler="handleClickOutside">
        <!-- DESKTOP OPTIONS TOGGLE -->
        <div class="nav-toggle is-flex-desktop is-hidden-touch" :class="{ 'is-active': expand }" @click="showOptions" >
            <span></span>
            <span></span>
            <span></span>
            <div class="dropdown-content" v-show="expand">
                <a :href="'/admin/dashboard'" v-if="$root.user.privilege == 'Dean'">Admin Panel</a>
                <a :href="'/'+$root.user.usn"> My Profile </a>
                <a :href="'/schedule/'+$root.user.usn" v-if="$root.user.privilege != 'Student'"> My Schedule </a>
                <a href="/calendar"> School Calendar </a>
                <a href="/groups"> Groups </a>
                <hr class="is-paddingless is-marginless">
                <a @click="logout()"> Log out </a>
            </div>
        </div>
        </click-outside>
    </div>
    
    <!-- NEW POST MODAL -->
    <div class="modal" :class="{ 'is-active': form }" style="z-index: 101;">
        <div class="modal-background"></div>
        <div class="modal-content">
            <nav class="panel">
                <div class="panel-heading">
                    New Post
                </div>
                <div class="panel-block" style="background-color: whitesmoke;">
                    <div class="control">
                        <p class="control">
                            <textarea class="textarea" maxlength="2000" placeholder="Write something..." v-model="body"></textarea>
                        </p>
                        <div class="has-text-centered">
                            <a class="button is-info is-fullwidth"
                                :class="{'is-loading' : loading, 'is-disabled': loading}"
                            @click="createPost()">SUBMIT</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <button class="modal-close" @click="toggleForm"></button>
    </div>
	</div>
</nav>
</template>

<style scoped>
	.dropdown-content {
	    position: absolute;
	    right: 0.4rem;
	    top: 3.5rem;
	    width: 200px;
	    z-index: 1;
	    min-width: 200px;
	    background-color: #ffffff;
	    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	}
	.dropdown-content a {
	   padding: 12px 16px;
	   display: flex;
	}

	.dropdown-content a:hover {
		background-color: #66757f;
		color: white;
	}
</style>

<script>
    import ClickOutside from 'onclick-outside'
	import {mapState} from 'vuex'
	import eventHub from '../../event'

	export default {
        components: {
            ClickOutside
        },

		mounted () {
			eventHub.$on('close-dropdown', this.closeDropdown)
		},

		data () {
			return {
				expand: false,
                mobileExpand: false,
				form: false,			
				body: '',
				loading: false,
			}
		},

		computed: {

            activeConversationClass() {
                if (this.$root.route == 'conversations') {
                    return 'is-active';
                } else if (this.$root.route == 'conversation') {
                    return 'is-active';
                }
            }
		    
		},

		methods: {
             handleClickOutside(e) {
                 this.closeDropdown();
            },

			closeDropdown() {
				this.expand = false;
			},

			toggleForm() {
				this.form = !this.form;
			},

			showOptions() {
				this.expand = !this.expand;
			},

            showMobileOptions() {
                this.mobileExpand = !this.mobileExpand;
            },

			logout() {
				axios.post('/logout').then(response => {
					window.location.href="/"
				});
			},

			createPost () { 
			        if(this.body.trim() != '') {
			            this.loading = true;
			            axios.post('/posts',{ body: this.body}).then((response) => {
			              if(response.data % 1 === 0) {
			                  this.loading = false;
			                  swal({
			                    title: response.data + ' seconds left',
			                    type: 'error',
			                    text: 'before you can post again.',
			                    timer: response.data * 1000
			                  })
			              } else {
			                Vue.nextTick(() =>{ 
			                	this.loading = false;
			                	eventHub.$emit('add-post', response.data);
			                	this.form = false;
			                	this.body = ''; 
			                });
			              }      
			            })
			        }       
			},
		}
	}
</script>
