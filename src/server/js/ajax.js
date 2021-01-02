'use strict';

/**
 * The class implements methods for calling communicating with the server API
 */
export default class ajax {
    /**
     * @param {string} method HTTP Method to use
     * @param {string} path Path to send the query to
     * @param {Object} body Body of the query (will be serialized as json)
     * @return {Promise} Promise for the HTTP request
     * @private
     */
    static _ajax({method, path, body}) {
        const headers = new Headers();
        if (body) {
            headers.append('Content-Type', 'application/json; charset=utf-8');
            body = JSON.stringify(body);
        }

        const init = {headers, method};
        if (body) {
            init.body = body;
        }
        return fetch(path, init);
    }

    /**
     * @param {string} path Path to send the query to
     * @param {Object} body Body of the query (will be serialized as json)
     * @return {Promise} Promise for the HTTP request
     */
    static doGet({path = '/', body = null}) {
        return this._ajax({path, body, method: 'GET'});
    }

    /**
     * @param {string} path Path to send the query to
     * @param {Object} body Body of the query (will be serialized as json)
     * @return {Promise} Promise for the HTTP request
     */
    static doPost({path = '/', body = null}) {
        return this._ajax({path, body, method: 'POST'});
    }

    /**
     * @param {string} path Path to send the query to
     * @param {Object} body Body of the query (will be serialized as json)
     * @return {Promise} Promise for the HTTP request
     */
    static doPut({path = '/', body = null}) {
        return this._ajax({path, body, method: 'PUT'});
    }
}
