<template>
    
    <div class="container">
        <div class="columns is-vcentered">
            
            <div v-if="form == 4" class="column is-4 is-offset-4">
                <h1 class="title has-text-centered">
                    Forgot Password
                </h1>

                    <form @submit.prevent="reset()">
                        
                        <div class="box">
                        <div class="notification is-success" v-show="resetPassword.success">
                            <a class="delete" @click.prevent="resetPassword.success = false"></a>
                            Reset password link has been sent. <br> to your email address.
                        </div>
                            <label class="label">Email</label>
                           <p class="control">
                               <input class="input" type="text" placeholder="Enter email" v-model="resetPassword.email">
                           </p>
                           <br>
                            <p class="control">
                                <button class="button is-info" :class="{'is-loading' : loadingButton, 'is-disabled': facebookButton}" style="width: 100%;">Reset Password</button>
                            </p>
                        </div>
                    </form>
             
                <p class="has-text-centered">
                    <a @click="switchForm(2)" :class="[loadingButton ? 'is-disabled' : '', facebookButton ? 'is-disabled' : '']">Register an Account</a> 
                </p>
            </div><!-- LOGIN -->

            <!-- LOGIN -->
            <div v-if="form == 1" class="column is-4 is-offset-4">
                <h1 class="title has-text-centered">
                    AMAFV-ECAMPUS
                </h1>

                    <form @submit.prevent="login()">
                        <div class="box">
                            <div class="notification is-danger" v-show="loginError">
                                <a class="delete" @click.prevent="loginError = false"></a>
                                User credentials does not match our record
                            </div>
                            <label class="label">Student / Employee Number</label>
                            <p class="control">
                                <input class="input" type="text" ref="usn" placeholder="student/employee number" v-model="loginForm.usn">
                            </p>
                            <label class="label">Password</label>
                            <p class="control">
                                <input class="input" type="password" placeholder="●●●●●●●" v-model="loginForm.pass">
                            </p>
                            <br>
                            <p class="control">
                                <button class="button is-info" :class="{'is-loading' : loadingButton, 'is-disabled': facebookButton}" style="width: 100%;">Login</button>
                            </p>
                        </div>
                    </form>
             
                <!-- <p class="has-text-centered">
                    <a @click="switchForm(2)" :class="[loadingButton ? 'is-disabled' : '', facebookButton ? 'is-disabled' : '']">Register an Account</a>
                </p> -->
            </div><!-- LOGIN -->

          <!--   REGISTER
          <div v-if="form == 2" class="column is-4 is-offset-4">
              <h1 class="title has-text-centered">
                  AMAFV-ECAMPUS
              </h1>
              <h1 class="subtitle has-text-centered">
                  First time login. Please fill up the form.
              </h1>
              <form @submit.prevent="registerUser()" @keydown="errors.clear($event.target.name)">
                  <div class="box">
          
                      <div class="control">
                          <label class="label">Student number</label>
                          <input class="input" name="usn" type="text" placeholder="Enter student number"
                              v-model="register.usn"
                              >
                          <div class="help is-danger"
                              v-if="errors.has('usn')"
                              v-text="errors.get('usn')"
                              ></div>
                      </div>
                      
                      <div class="control">
                          <label class="label">Username</label>
                          <input class="input" name="username" type="text" placeholder="Enter username"
                              v-model="register.username"
                              >
                          <div class="help is-danger"
                              v-if="errors.has('username')"
                              v-text="errors.get('username')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Name</label>
                          <input class="input" name="name" type="text" placeholder="Enter name"
                              v-model="register.name"
                              >
                          <div class="help is-danger"
                              v-if="errors.has('name')"
                              v-text="errors.get('name')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Email</label>
                          <input class="input" name="email" type="email" placeholder="Enter email"
                              v-model="register.email"
                              >
                          <div class="help is-danger"
                              v-if="errors.has('email')"
                              v-text="errors.get('email')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Course</label>
                          <span class="select" style="width: 100%;" >
                              <select style="width: 100%;" v-model="register.course">
                                  <option>Information Technology</option>
                                  <option>Computer Science</option>
                                  <option>Computer Engineering</option>
                              </select>
                          </span>
                      </div>
          
                      <hr>
          
                      <div class="control">
                          <label class="label">Activation Key</label>
                          <input class="input" name="key" type="text" placeholder="Enter activation key"  v-model="register.key">
                          <div class="help is-danger"
                              v-if="errors.has('key')"
                              v-text="errors.get('key')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Password</label>
                          <input class="input" name="password" type="password" placeholder="●●●●●●●"  v-model="register.password">
                          <div class="help is-danger"
                              v-if="errors.has('password')"
                              v-text="errors.get('password')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Confirm Password</label>
                          <input class="input" name="password" type="password" placeholder="●●●●●●●" v-model="register.password_confirmation">
                      </div>
          
                      <hr>
          
                      <div class="control">
                          <button class="button is-info"
                              :class="{'is-loading' : loadingButton}"
                              :disabled="errors.any()"
                              style="width: 100%;">Register</button>
                      </div>
          
                  </div>
              </form>
              <p class="has-text-centered">
                  <a @click="switchForm(1)" :class="[loadingButton ? 'is-disabled' : '',]">Login</a>
              </p>
          </div>REGISTER
          
          LOGIN WITH FACEBOOK
          <div v-if="form == 3" class="column is-4 is-offset-4">
              <h1 class="title has-text-centered">
                  AMAFV-ECAMPUS
              </h1>
              <h1 class="subtitle has-text-centered">
                  First time login. Please fill up the form.
              </h1>
              <form @submit.prevent="loginFacebook()" @keydown="errors.clear($event.target.name)">
                  <div class="box">
          
                      <div class="control">
                          <label class="label">USN</label>
                          <input class="input" type="number" ref="usn" placeholder="USN" v-model="facebook.usn">
                          <div class="help is-danger"
                              v-if="errors.has('usn')"
                              v-text="errors.get('usn')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Username</label>
                          <input class="input" type="text" ref="username" placeholder="Username" v-model="facebook.username">
                          <div class="help is-danger"
                              v-if="errors.has('username')"
                              v-text="errors.get('username')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Activation key</label>
                          <input class="input" type="text" placeholder="Activation key" v-model="facebook.key">
                          <div class="help is-danger"
                              v-if="errors.has('key')"
                              v-text="errors.get('key')"
                              ></div>
                      </div>
          
                      <div class="control">
                          <label class="label">Course</label>
                          <span class="select" style="width: 100%;" >
                              <select style="width: 100%;" v-model="register.course">
                                  <option>Information Technology</option>
                                  <option>Computer Science</option>
                                  <option>Computer Engineering</option>
                              </select>
                          </span>
                      </div>
          
                      <div class="control">
                          <button class="button is-info"
                              :class="{'is-loading' : loadingButton, 'is-disabled': facebookButton}"
                              style="width:100%;"
                              >Submit
                          </button>
                      </div>
                      <hr>
                      <button class="button is-default"
                          :class="{'is-disabled' : loadingButton}"
                          style="width:100%;"
                          @click.prevent="switchForm(1)">Cancel</button>
                  </div>
              </form>
          </div> LOGIN WITH FACEBOOK -->

        </div>
    </div>
  
    
</template>

<script>
import {Errors} from '../../classes/Errors';

export default {
    mounted () {
        if (facebook != 0) { this.form = 3; this.facebook.id = facebook; }
    },

    data () {
        return {
            form: 1,
            facebookButton: false,
            loadingButton: false,
            loginError: false,
            loginForm: {
                usn: '',
                pass: '',
            },
            register: {
                usn: '',
                name: '',
                email: '',
                course: 'Information Technology',
                key: '',
                password: '',
                password_confirmation: '',
            },
            facebook: {
                username: '',
                usn: '',
                key: '',
                course: 'Information Technology',
                id: null,
            },
            resetPassword: {
                email: '',
                success: false,
            },
            errors: new Errors()
        }
    },

    methods: {
        reset() {
            this.resetPassword.success = true;
            this.resetPassword.email = '';
        },

        switchForm(id){
            this.errors.reset();
            this.form = id;
        },

        login() {
            let data = this.loginForm;
            this.loadingButton = true;
            axios.post('/login', this.loginForm)
                .then(response => {
                     if (response.data == 0) { window.location.href = "/"; }
                     else { this.loginError = true; this.loadingButton = false; this.$refs.usn.focus(); data.pass = ''; }
                     
                });
                   
        },

        loginFacebook() {
            this.loadingButton = true;
            axios.post('/create', this.facebook)
                .then(response => {
                     if (response.data == 0) { window.location.href = "/"; }
                     else { swal('Oops!', 'Student number with the activation key does not exist', 'error')
                            this.loadingButton = false; this.$refs.usn.focus(); this.facebook.pass = ''; }
                })
                .catch(error => {
                    if(error != undefined){ this.errors.record(error.response.data); } 
                    this.loadingButton = false;
                });
        },

        registerUser() {
            this.loadingButton = true;
            axios.post('/register', this.register)
                .then(response => {
                    if(response.data == 0) {
                        swal('Oops!', 'Student number with the activation key does not exist', 'error')
                        this.register.key = '';
                        this.loadingButton = false; }
                    if(response.data == 1) { window.location.href = "/"; }
                })
                .catch(error => {
                    if(error != undefined){ this.errors.record(error.response.data); } 
                    this.loadingButton = false;
                    this.register.password = '';
                    this.register.password_confirmation = '';
                });
        }
    }
}

</script>

<style>
    #fb-btn {
        width: 100%;
        background-color: #45619d;
    }
</style>
