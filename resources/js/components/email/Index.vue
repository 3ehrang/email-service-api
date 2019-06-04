<template>
    <div>
        <div class="form-group">
        </div>

        <div class="panel panel-default">
            <div class="panel-heading mb-3">Email list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>App</th>
                        <th>Status</th>
                        <th>ServiceId</th>
                        <th>Receive At</th>
                        <th>Sent At</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item, index in items">
                        <td>{{ item.id }}</td>
                        <td>{{ item.app }}</td>
                        <td>{{ getStatus(item.status) }}</td>
                        <td>{{ item.serviceId }}</td>
                        <td>{{ item.receive_at }}</td>
                        <td>{{ item.sent_at }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        name: 'EmailIndex',

        data: function () {
            return {
                items: []
            }
        },

        mounted() {

            axios.get('/api/v1/emails')

                .then(response => {
                    this.items = response.data;
                })

                .catch(errors =>  {

                    console.log(errors);
                    alert("Could not load items");
                });

        },

        methods: {

            /**
             * Translate staus to user readable data
             * @param status
             */
            getStatus(status) {

                let value = '';

                switch(status) {
                    case 0:
                        value = 'Received';
                        break;
                    case 1:
                        value = 'Queued';
                        break;
                    case 2:
                        value = 'Sent';
                        break;
                    case 3:
                        value = 'Not Sent';
                        break;
                    default:
                }

                return value;
            }

        }

    }

</script>
