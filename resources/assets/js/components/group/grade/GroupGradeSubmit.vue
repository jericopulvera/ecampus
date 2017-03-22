<template>
<div class="modal is-active" style="z-index: 1000;">
    <div class="modal-background"></div>
    <div class="modal-card">
        <div class="card">
            <header class="card-header" >
                <p class="card-header-title" style="display: flex; justify-content: center;">
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
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Mark</p>
                                <p class="title">{{calculateMark(student.grades)}}</p>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <footer class="card-footer">
                <a class="card-footer-item" @click="submitGrade()">Submit</a>
                <a class="card-footer-item" @click="submitGrade('IC')">Incomplete</a>
                <a class="card-footer-item" @click="submitGrade('D')">Drop</a>
                <a class="card-footer-item" @click="closeModal">Close</a>
            </footer>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['student'],    

        methods: {
            closeModal() {
                this.$parent.$emit('close-submit');
            },
            calculateGrades(grades) {
            return Math.round(((((grades.quiz_one + grades.quiz_two) / 2)*.4)+(grades.exam*.5)+(grades.class_standing*.1))* 100) / 100
          },

          calculateTotalGrade(grades) {
            let prelim = Math.round(((((grades[0].quiz_one + grades[0].quiz_two) / 2)*.4)+(grades[0].exam*.5)+(grades[0].class_standing*.1))* 100) / 100
            let midterm = Math.round(((((grades[1].quiz_one + grades[1].quiz_two) / 2)*.4)+(grades[1].exam*.5)+(grades[1].class_standing*.1))* 100) / 100
            let finals = Math.round(((((grades[2].quiz_one + grades[2].quiz_two) / 2)*.4)+(grades[2].exam*.5)+(grades[2].class_standing*.1))* 100) / 100

            return Math.round((  (prelim*.3)+(midterm*.3)+(finals*.4)  )* 100) / 100
          },

          calculateMark(grades) {
            var grade = this.calculateTotalGrade(grades);

            if (grade >= 96) {
                return 'A+';
            } else if (grade >= 95) {
                return 'A';
            } else if (grade >= 90) {
                return 'A-';
            } else if (grade >= 85) {
                return 'B+';
            } else if (grade >= 80) {
                return 'B';
            } else if (grade >= 74) {
                return 'B-';
            } else if (grade >= 68) {
                return 'C+';
            } else if (grade >= 62) {
                return 'C';
            } else if (grade >= 50) {
                return 'C-';
            } else {
                return 'F';
            }
          },

          submitGrade(incomplete) {
            var self = this;
            swal({
              title: 'Info',
              text: "Submit again to update the final grade",
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Submit'
            }).then(function () {
                self.confirm(incomplete)  
            }).catch(error => {

            })
          },

          confirm(mark) {
            let data = {
                'student_id': this.student.id,
                'prof_id': this.$root.user.id,
                'subject': group.subject,
                'section': group.section,
                'grade': this.calculateTotalGrade(this.student.grades),
                'mark': mark,
            }

            axios.post('/grade', data).then(response => {
                swal('Success', 'Grade has been submitted', 'success');
            }).catch(error => {

            })
          }
        }
    }
</script>
