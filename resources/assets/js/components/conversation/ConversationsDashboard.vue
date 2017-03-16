<template>
    <div class="container">
        <div class="row">
            <div class="columns">
                <div class="column is-5">
                    <conversation-form></conversation-form>
                    <conversations></conversations>
                </div>
                <div class="column is-7">
                    <conversation :id="id"></conversation>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'id': {
                default: null
            }
        }
    }
</script>
