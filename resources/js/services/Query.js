import axios from "axios";

export default class {
    constructor() {
        this.queries = [];
    }

    query() {
        let query = '?' + this.queries.join('&');
        this.queries = [];
        return query;
    }

    filter(value) {
        if (value) {
            this.queries.push(`searches=${value}`);
        }
        return this;
    }

    fields(fields) {
        this.queries.push(`fields=${fields.join(',')}`);
        return this;
    }

    include(relations) {
        this.queries.push(`include=${relations.join(',')}`);
        return this;
    }

    parameter(key, value) {
        this.queries.push(`${key}${value ? '='+ value : ''}`);
        return this;
    }

    sort(field, sortBy = 'asc') {
        if (field) {
            this.queries.push(`orderBy=${field}`);
            this.queries.push(`sortedBy=${sortBy}`);
        }
        return this;
    }

    paginate(page = 1, perPage = 10) {
        this.queries.push(`paginate=${perPage}`);
        this.queries.push(`page=${page}`);
        return this;
    }

    all() {
        return axios.get(`${this.resource}${this.query()}`);
    }

    show(id) {
        return axios.get(`${this.resource}/${id}${this.query()}`);
    }

    store(params) {
        return axios.post(`${this.resource}${this.query()}`, params);
    }

    update(id, params) {
        return axios.put(`${this.resource}/${id}${this.query()}`, params);
    }

    destroy(id) {
        return axios.delete(`${this.resource}/${id}${this.query()}`);
    }
}
