<template>
  <article class="media">
    <figure class="media-left">
      <p class="image is-64x64">
        <img :src="$root.user.image">
      </p>
    </figure>
    <div class="media-content">
      <p class="control">
        <textarea ref="textarea" class="textarea" :class="{'is-disabled': loading}" placeholder="Add a comment..." v-model="body"></textarea>
      </p>
      <p class="control">
        <button class="button" :class="{'is-loading': loading}" @click="comment">Post comment</button>
      </p>
    </div>
  </article>
</template>

<script>
  import eventHub from '../../../event'

  export default {
    props: ['id'],

    mounted () {
      eventHub.$on('clear', this.clear)
      eventHub.$on('reply-focus'+this.id, this.focus)
    },

    data () {
      return {
        body: '',
        loading: false,
      }
    },

    methods: {
      focus() {
        this.$refs.textarea.focus()
      },

      clear() {
        this.loading = false
        this.body = ''
      },

      comment() {
        if (this.body.trim() != '') {
          this.loading = true;
          axios.post('/webapi/group/comment/'+this.id, {body: this.body})
            .then(response => {
                this.$emit('load-post')
            })
            .catch(error => {
              alert('something went wrong please reload the page')
            })
        }
      }
    }
  }
</script>
