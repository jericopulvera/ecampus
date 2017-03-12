<template>
    <div class="content">
        <div class="card" v-for="student in groupStore.students" style="margin: 20px 0;" v-if="groupStore.students.length > 0">
            <header class="card-header has-text-centered">
                <p class="card-header-title">
                    <a :href="'/'+student.usn" target="_blank"> {{student.name.toUpperCase()}} | {{student.usn}} | {{student.course}} </a>
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <nav class="level">
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Prelim Total</p>
                                <p class="title">{{calculateGrades(student.grades[0])}}</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Midterm Total</p>
                                <p class="title">{{calculateGrades(student.grades[1])}}</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Finals Total</p>
                                <p class="title">{{calculateGrades(student.grades[2])}}</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Total Grade</p>
                                <p class="title">{{calculateTotalGrade(student.grades)}}</p>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <footer class="card-footer">
                <a class="card-footer-item" @click="editGrade(student.id, 'prelim')">Prelim</a>
                <a class="card-footer-item" @click="editGrade(student.id, 'midterm')">Midterm</a>
                <a class="card-footer-item" @click="editGrade(student.id, 'finals')">Finals</a>
                <a class="card-footer-item" @click="show = true;">Submit</a>
            </footer>
        <group-grade-submit :student="student" v-if="show"></group-grade-submit>
    </div>

    <article class="message is-info  has-text-centered" v-else>
        <div class="message-header">
            <div class="title">Info</div>
        </div>
        <div class="message-body">
            No Students
        </div>
    </article>


    </div>
</template>

<script>
    import {mapState} from 'vuex';

	export default {
		data () {
			return {
				show: false,
			}
		},

        mounted () {
            this.$on('close-submit', this.closeSubmit);
        },

		computed: {
		    ...mapState({
		        groupStore: state => state.groupStore
		    })
		},

		methods: {
          closeSubmit() {
            this.show = false
          },

		  editGrade(id,term) {
		    this.$store.dispatch('editGrade', { id: id, term: term});
		  },

		  calculateGrades(grades) {
		  	return Math.round(((((grades.quiz_one + grades.quiz_two) / 2)*.4)+(grades.exam*.5)+(grades.class_standing*.1))* 100) / 100
		  },

		  calculateTotalGrade(grades) {
	  		let prelim = Math.round(((((grades[0].quiz_one + grades[0].quiz_two) / 2)*.4)+(grades[0].exam*.5)+(grades[0].class_standing*.1))* 100) / 100
	  		let midterm = Math.round(((((grades[1].quiz_one + grades[1].quiz_two) / 2)*.4)+(grades[1].exam*.5)+(grades[1].class_standing*.1))* 100) / 100
	  		let finals = Math.round(((((grades[2].quiz_one + grades[2].quiz_two) / 2)*.4)+(grades[2].exam*.5)+(grades[2].class_standing*.1))* 100) / 100

		  	return Math.round((  (prelim*.3)+(midterm*.3)+(finals*.4)  )* 100) / 100
		  }
		}  
	}
</script>

<style scoped>
	.card-header-title {
		align-items: center;
		justify-content: center;
	}
</style>
