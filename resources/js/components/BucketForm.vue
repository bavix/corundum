<template>
    <!-- Modal -->
    <div class="modal fade" id="bucketFormModal" tabindex="-1" role="dialog" aria-labelledby="bucketFormModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bucketFormModalLabel">Bucket Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div v-if="alert" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong v-text="alert.statusText"></strong>
                    <span v-text="alert.statusMessage"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="reset">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="bucket-name" class="col-form-label">Name:</label>
                        <input type="text" v-model="name" class="form-control" id="bucket-name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" @click.prevent="send">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../api'

    export default {
        data() {
            return {
                alert: null,
                name: null
            }
        },
        props: {
            bucket: {
                id: Number,
                name: String,
            }
        },
        methods: {
            reset() {
                this.alert = null
            },
            send() {
                this.reset();

                api.post('bucket.store', {name: this.name})
                    .then(res => res.data)
                    .then(res => {
                        // todo: тут нужен vuex
                        location.reload();
                    })
                    .catch(res => this.alert = res.response)
            }
        }
    }
</script>
