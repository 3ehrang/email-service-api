<template>

    <div>
        <div class="invalid-feedback" v-for="message in messages">
            {{ message }}
        </div>
    </div>

</template>

<script>

    export default {

        name: 'field-errors',

        props: ['messages'],

    }

</script>

<style scoped>

    .form-control.is-invalid ~ div .invalid-feedback, .custom-control-input.is-invalid ~ div .invalid-feedback {
        display: block;
    }

</style>
