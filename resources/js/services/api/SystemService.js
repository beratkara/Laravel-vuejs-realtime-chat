import axios from 'axios'
import Query from "../Query";

export default class extends Query {
    constructor() {
        super();
        this.resource = '/auth/system';
    }

    getRoleAndPermissions() {
        let resource = this.resource + '/getRoleAndPermissions';
        return axios.get(`${resource}`);
    }

}
