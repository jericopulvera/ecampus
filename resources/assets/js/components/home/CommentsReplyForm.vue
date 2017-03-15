<template>
    <article class="media">
      <figure class="media-left">
        <p class="image is-64x64">
          <img :src="$root.user.image">
        </p>
      </figure>
      <div class="media-content">
        <p class="control">
          <textarea class="textarea" placeholder="Add a comment..." ref="comment"></textarea>
        </p>
        <p class="control">
          <button class="button">Post comment</button>
        </p>
      </div>
    </article> 
</template>

<script>
    export default {
        mounted () {
            this.listen();
        },

        methods: {
            listen() {
                this.$on('focus', this.focus());
            },

            focus() {
                this.$refs.comment.focus(); 
            }
        }
    }
</script>