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
            <tr v-for="(item, key) in items" :key="key">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.name }}</td>
                <td>
                    <a href="#" v-on:click="remove(key)">d</a>
                    <a href="#" v-on:click="edit(key)">e</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: {
            items: Array
        },
        methods: {
            edit(key) {
                console.log('edit', this.items[key]);
            },
            remove(key) {
                console.log('remove', this.items[key]);
            }
        },
        mounted() {
            // axios
            //     .get('https://api.coindesk.com/v1/bpi/currentprice.json')
            //     .then(response => (this.info = response));
        }
    }
</script>
