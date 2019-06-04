import Errors from './Errors';

class Form {

    /**
     *
     * Create a new From instance.
     *
     * @param {object} data
     *
     */
    constructor(data) {

        this.originalData = data;

        for(let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();

    }

    /**
     *
     * Fetch all relevant data fo the Form.
     *
     */
    data() {

        let data = {};

        for (let property in this.originalData) {

            data[property] = this[property];
        }

        return data;

    }

    /**
     *
     * Reset the form fields.
     *
     */
    reset() {

        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();

    }

    /**
     *
     * Create the form data
     *
     * @returns {FormData}
     */
    formData() {

        let formData = new FormData();
        for (let field in this.data()) {
            formData.append(field, this.data()[field]);
        }

        return formData;

    }

    post(url) {

        this.submit('POST', url); // @TODO: I'm gonna make it

    }

    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {

        let formData = this.formData();

        return new Promise((resolve, reject) => {

            axios[requestType](url, formData, { headers: { 'Content-Type': 'multipart/form-data'}})

                .then(response => {
                    this.onSuccess(response.data);
                    resolve(response.data);
                })

                .catch(error => {
                    this.onFail(error.response.data);
                    reject(error.response.data)
                });

        });

    }

    /**
     * Handle a succesful form submission.
     *
     * @param data
     */
    onSuccess(data) {

        this.reset();

    }

    /**
     * Handle a failed form submission.
     * @param errors
     */
    onFail(errors) {

        this.errors.record(errors);
    }
}

export default Form;
