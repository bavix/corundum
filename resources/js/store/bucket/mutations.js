
export const MUTATION_ADD_BUCKET = 'MUTATION_ADD_BUCKET';

export default {
    [MUTATION_ADD_BUCKET](state, bucket) {
        const rows = state.items.filter(row => row.id === bucket.id);

        if (rows.length === 0) {
            state.items.push(bucket);
        }
    }
}
