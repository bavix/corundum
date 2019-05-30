
import axios from 'axios'
import { API_BUCKET } from "../consts";

export default {

    async all() {
        let results = [];
        let next = API_BUCKET;

        do {
            await axios.get(next)
                .then(res => res.data)
                .then(res => {
                    next = res.links.next;
                    results.push(...res.data);
                });
        } while (next !== null);

        return Promise.resolve(results);
    }

};
