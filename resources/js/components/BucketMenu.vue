<template>
    <table v-show="buckets.length > 0" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(bucket, key) in buckets" :key="key">
                <th scope="row">{{ bucket.id }}</th>
                <td>{{ bucket.name }}</td>
                <td>
                    <a href="#" v-on:click="remove(key)">d</a>
                    <a href="#" v-on:click="edit(key)">e</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    import { mapGetters, mapState } from 'vuex'
    import store from '../store'

    export default {
        store,
        computed: {
            ...mapGetters('bucket', {
                buckets: 'all'
            })
        }
    }
</script>
