<template>
    <div>
        <div class="panel-heading"><h4>Create</h4></div>
        <div class="my-3">
           <router-link to="/" class="btn btn-success btn-outline-secondary" role="button">Back</router-link>
        </div>
        <form enctype="multipart/form-data" method="post" @submit.prevent="onSubmit">

            <div class="form-group">
                <label for="subject">Subject</label>
                <input
                    type="text"
                    v-model="form.subject"
                    :class="form.errors.has('subject') ? 'is-invalid' : ''"
                    name="subject"
                    id="subject"
                    class="form-control"
                >
                <field-errors v-if="form.errors.has('subject')" v-bind:messages="form.errors.get('subject')" ></field-errors>
            </div>

            <div class="form-group">
                <label for="to">To</label>
                <input
                    type="text"
                    v-model="form.to"
                    :class="form.errors.has('to') ? 'is-invalid' : ''"
                    name="to"
                    id="to"
                    class="form-control"
                >
                <field-errors v-if="form.errors.has('to')" v-bind:messages="form.errors.get('to')" ></field-errors>
            </div>

            <div class="form-group">
                <label for="toName">To Name</label>
                <input
                    type="text"
                    v-model="form.toName"
                    :class="form.errors.has('toName') ? 'is-invalid' : ''"
                    name="toName"
                    id="toName"
                    class="form-control"
                >
                <field-errors v-if="form.errors.has('toName')" v-bind:messages="form.errors.get('toName')" ></field-errors>
            </div>

            <div class="form-group">
                <label for="contentType">Content Type</label>
                <select v-model="form.contentType" id="contentType" class="custom-select col-md-4">
                    <option value="text/html">Text/Html</option>
                    <option value="text/string">Text/String</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea
                    v-model="form.content"
                    :class="form.errors.has('content') ? 'is-invalid' : ''"
                    name="content"
                    class="form-control"
                    id="content"
                    rows="3"
                >
                </textarea>
                <field-errors v-if="form.errors.has('content')" v-bind:messages="form.errors.get('content')" ></field-errors>
            </div>

            <input type="hidden" name="app_id" v-model="form.app_id">

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</template>

<script>

    import Form from '../../core/Form';
    import FieldErrors from '../../core/form/FieldErrors';

    export default {

        name: 'EmailCreate',

        data() {
            return {

                form: new Form(
                    {
                        subject: '',
                        to: '',
                        toName: '',
                        from: '',
                        fromName: '',
                        contentType: 'text/html',
                        content: '',
                        app_id: 'webInterface'
                    }
                ),
            }
        },

        methods: {

            onSubmit() {

                this.form.submit('post', '/api/emailservice/v1/emails')

                    .then(data => {

                        this.$router.push({path: '/'});
                    })

                    .catch(errors => console.log(errors));

            },

        },

        components: {

            FieldErrors,
        }

    }

</script>
