<template>
    <div>
        <div class="panel-heading"><h4>Create</h4></div>
        <div class="my-3">
           <router-link to="/" class="btn btn-success btn-outline-secondary" role="button">Back</router-link>
        </div>
        <form enctype="multipart/form-data" method="post" @submit.prevent="onSubmit">

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" v-model="form.subject" name="subject" id="subject" class="form-control">
            </div>

            <div class="form-group">
                <label for="to">To</label>
                <input type="text" v-model="form.to" name="to" id="to" class="form-control">
            </div>

            <div class="form-group">
                <label for="toName">To Name</label>
                <input type="text" v-model="form.toName" name="toName" id="toName" class="form-control">
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
                <textarea v-model="form.content" name="content" class="form-control" id="content" rows="3"></textarea>
            </div>

            <input type="hidden" name="app_id" v-model="form.app_id">

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
</template>

<script>

    export default {

        name: 'EmailCreate',

        data() {
            return {

                form:
                    {
                        subject: '',
                        to: '',
                        toName: '',
                        from: '',
                        fromName: '',
                        contentType: 'text/html',
                        content: '',
                        app_id: 'webInterface'
                    },
            }
        },

        methods: {

            onSubmit() {

                let formData = new FormData();
                for (let field in this.form) {
                    formData.append(field, this.form[field]);
                }

                axios.post('/api/emailservice/v1/emails', formData, { headers: { 'Content-Type': 'multipart/form-data'}})

                    .then(data => {

                        this.$router.push({path: '/'});
                    })

                    .catch(error => {
                        console.log(error);
                    });
            },

        },

    }

</script>
