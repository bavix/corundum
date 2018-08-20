<template>
    <table v-show="items.length > 0" class="table table-striped table-bordered">
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
    import api from '../api'

    export default {
        props: {
            items: Array
        },
        computed: {
            buckets() {
                return this.items
            }
        },
        methods: {
            appends(buckets) {
                for (const bucket of buckets) {
                    if (!this.exists(bucket.id)) {
                        this.items.push(bucket);
                    }
                }
            },
            exists(id) {
                for (const item of this.items) {
                    if (item.id === id) {
                        return true;
                    }
                }

                return false;
            },
            edit(key) {
                console.log('edit', this.items[key]);
            },
            remove(key) {
                console.log('remove', this.items[key]);
            },
        },
        async mounted() {
            await api.get('bucket.index')
                .then(res => res.data)
                .then(this.appends);
        }
    }
</script>
