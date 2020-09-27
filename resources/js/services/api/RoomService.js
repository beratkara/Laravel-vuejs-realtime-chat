import axios from 'axios'
import Query from "../Query";

export default class extends Query {
    constructor() {
        super();
        this.resource = '/auth/rooms';
    }

    messageStore(id,params) {
        return axios.post(`${this.resource}/messageStore/${id}${this.query()}`, params);
    }

}
