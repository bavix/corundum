
import api from '../../api/bucket'
import { MUTATION_ADD_BUCKET } from "./mutations";

export const ACTION_GET_BUCKETS = 'ACTION_GET_BUCKETS';

export default {
    [ACTION_GET_BUCKETS]({ commit }) {
        api.all().then(buckets => {
            for (const bucket of buckets) {
                commit(MUTATION_ADD_BUCKET, bucket)
            }
        })
    }
}
