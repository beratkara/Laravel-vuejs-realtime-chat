import axios from 'axios'
import Query from "../Query";

export default class extends Query {
    constructor() {
        super();
        this.resource = '/auth/profile';
    }

}
