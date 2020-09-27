import axios from 'axios'
import Query from "../Query";

export default class extends Query {
    constructor() {
        super();
        this.resource = '/auth/persons';
    }

    test() {
        let resource = this.resource + '/test/';
        return axios.get(`${resource}`);
    }
}
