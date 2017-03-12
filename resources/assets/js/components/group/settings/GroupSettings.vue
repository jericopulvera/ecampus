<template>
<div class="container">
	<form method="POST" action="/groups/create" class="box" v-if="$root.user.id === groupStore.admin.id">

		<label class="label">ROOM</label>
		<p class="control">
		  <input class="input" placeholder="Enter room name" name="room" type="text" v-model="form.room" @keydown="errors.clear($event.target.name)">
			
			<span class="help is-danger"
				v-if="errors.has('room')"
				v-text="errors.get('room')">
			</span>
		</p>
		
		<label class="label">SCHEDULE</label>
		<p class="control">			
			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="1">
			    Monday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="2">
			    Tuesday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="3">
			    Wednesday
			</label>
			
			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="4">
			    Thursday
			</label>
		
			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="5">
			    Friday
			</label>

			<label class="checkbox is">
			    <input type="checkbox" v-model="form.schedule" value="6">
			    Saturday
			</label>
			<span class="help is-danger"
				v-if="errors.has('schedule')"
				v-text="errors.get('schedule')">
			</span>
		
		</p>
		
		<label class="label">START TIME</label>
		<p class="control">
		  <span class="select">
		    <select v-model="form.start">
		      	<option value="7:00">7:00 AM</option>
		      	<option value="7:30">7:30 AM</option>
		       
		      	<option value="8:00">8:00 AM</option>
		      	<option value="8:30">8:30 AM</option>
		       
		      	<option value="9:00">9:00 AM</option>
		      	<option value="9:30">9:30 AM</option>
		       
		      	<option value="10:00">10:00 AM</option>
		      	<option value="10:30">10:30 AM</option>
		       
		      	<option value="11:00">11:00 AM</option>
		      	<option value="11:30">11:30 AM</option>
		       
		      	<option value="12:00">12:00 PM</option>
		      	<option value="12:30">12:30 PM</option>
		       
		      	<option value="13:00">1:00 PM</option>
		      	<option value="13:30">1:30 PM</option>
		       
		      	<option value="14:00">2:00 PM</option>
		      	<option value="14:30">2:30 PM</option>
		       
		      	<option value="15:00">3:00 PM</option>
		      	<option value="15:30">3:30 PM</option>
		       
		      	<option value="16:00">4:00 PM</option>
		      	<option value="16:30">4:30 PM</option>
		       
		      	<option value="17:00">5:00 PM</option>
		      	<option value="17:30">5:30 PM</option>
		       
		      	<option value="18:00">6:00 PM</option>
		      	<option value="18:30">6:30 PM</option>
		       
		      	<option value="19:00">7:00 PM</option>
		      	<option value="19:30">7:30 PM</option>
		       
		      	<option value="20:00">8:00 PM</option>
		    </select>
		  </span>
		  <span class="help is-danger" v-show="timeError">Start time must be less than End time.</span>	
		</p>

		<label class="label">END TIME</label>
		<p class="control">
		  <span class="select">
		    <select v-model="form.end">
		      	<option value="8:00">8:00 AM</option>
		      	<option value="8:30">8:30 AM</option>
		       
		      	<option value="9:00">9:00 AM</option>
		      	<option value="9:30">9:30 AM</option>
		       
		      	<option value="10:00">10:00 AM</option>
		      	<option value="10:30">10:30 AM</option>
		       
		      	<option value="11:00">11:00 AM</option>
		      	<option value="11:30">11:30 AM</option>
		       
		      	<option value="12:00">12:00 PM</option>
		      	<option value="12:30">12:30 PM</option>
		       
		      	<option value="13:00">1:00 PM</option>
		      	<option value="13:30">1:30 PM</option>
		       
		      	<option value="14:00">2:00 PM</option>
		      	<option value="14:30">2:30 PM</option>
		       
		      	<option value="15:00">3:00 PM</option>
		      	<option value="15:30">3:30 PM</option>
		       
		      	<option value="16:00">4:00 PM</option>
		      	<option value="16:30">4:30 PM</option>
		       
		      	<option value="17:00">5:00 PM</option>
		      	<option value="17:30">5:30 PM</option>
		       
		      	<option value="18:00">6:00 PM</option>
		      	<option value="18:30">6:30 PM</option>
		       
		      	<option value="19:00">7:00 PM</option>
		      	<option value="19:30">7:30 PM</option>
		       
		      	<option value="20:00">8:00 PM</option>
		    </select>
		  </span>

		</p>
	
			<p class="control">
				<button class="button is-primary is-fullwidth" @click.prevent="updateSettings">Submit</button>
			</p>
	</form>
	
	<button type="button" class="button is-danger is-fullwidth" v-if="groupStore.admin.id == $root.user.id" @click="leaveClass()" >Destroy Class Group</button>
	<button type="button" class="button is-danger is-fullwidth" v-else @click="leaveClass()">Leave Class Group</button>
</div>

</div>
    
</template>

<script>
	import {mapState} from 'vuex';
	import {Errors} from '../../../classes/Errors';
	export default {
		data () {
			return {
				form: {
			         room: null,
			         schedule: [],
			         start: null,
			         end: null,
			      },
			  timeError: false,
			  errors: new Errors()
			}
		},
		mounted () {
			this.form.room = group.room
			this.form.schedule = group.dow
			this.form.start = group.start
			this.form.end = group.end
		},
		computed: {
			...mapState({
				groupStore: state => state.groupStore
			})
		},
		methods: {
			leaveClass () {				
				var confirm = window.confirm('Are you sure you want to leave the group?')

				if (confirm) {
					axios.post('/group/leave-class/'+group.slug+'/'+this.$root.user.usn).then((response) => {
						alert('You have successfully left the group')
						window.location.href = '/';
					})
				}
			},

			updateSettings () {
				if (this.form.start > this.form.end) { return this.timeError = true; }
				 axios.post('/group/settings/'+group.slug, this.form)
				     .then(response => {
				     	this.timeError = false;
				         if (response.data == 1) {
				         	this.errors = new Errors();
				             noty({ text: 'You have successfully changed group settings.', type: 'sucess'});
				         } 
				     })
				     .catch(error => {
				         if(error != undefined){ this.errors.record(error.response.data); } 
				         this.loadingButton = false;
				     });
				}
			}
		
	}
</script>