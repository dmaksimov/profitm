<template>
    <div class="upload-recipient-component">
        <form-wizard ref="wizard" :title="''" :subtitle="''" :step-size="'sm'" :color="'#572E8D'" @on-complete="saveRecipients">
            <tab-content title="Upload File" icon="fas fa-list-ul" :before-change="validateFileTab">
                <resumable :target-url="this.targetUrl" ref="resumable" @file-added="onFileAdded"
                           @file-success="onFileSuccess"></resumable>
            </tab-content>
            <tab-content title="Recipient List" icon="fas fa-list-ul" :before-change="validateRecipientList">
                <div class="form-row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="pm_list_name">List Name</label>
                            <input type="text" name="pm_list_name" id="pm_list_name" class="form-control" v-model="fileForm.pm_list_name" @change="clearError(fileForm, 'pm_list_name')" :class="{'is-invalid': fileForm.errors.has('pm_list_name')}">
                            <input-errors :error-bag="fileForm.errors" :field="'pm_list_name'"></input-errors>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6 mb-3">
                        <div v-if="textToValueEnabled">
                            <p-check color="primary" class="p-default display-block" name="enable_text_to_value" value="enable_text_to_value" v-model="fileForm.enable_text_to_value">
                                Contains Text-to-value fields
                            </p-check>
                        </div>
                        <label>Type</label>
                        <div>
                            <p-radio color="primary" class="p-default display-block" name="pm_list_type" value="all_conquest" v-model="fileForm.pm_list_type">All
                                Conquest
                            </p-radio>
                        </div>
                        <div>
                            <p-radio color="primary" class="p-default display-block" name="pm_list_type" value="all_database" v-model="fileForm.pm_list_type">All
                                Database
                            </p-radio>
                        </div>
                        <div>
                            <p-radio color="primary" class="p-default display-block" name="pm_list_type" value="use_recipient_field" v-model="fileForm.pm_list_type">Mix - Use
                                CSV Field
                            </p-radio>
                        </div>
                    </div>
                </div>
            </tab-content>
            <tab-content title="Map Your Fields" icon="fas fa-list-ul">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th width="200px">PM Field</th>
                            <th>File Field</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(pmField, index) in pmFields" v-bind:value="index" v-bind:key="pmField">
                            <td>{{pmField}}</td>
                            <td>
                                <v-select :options="fileHeaders" v-model="fileForm.uploaded_file_fieldmap[index]" class="filter--v-select"></v-select>
                            </td>
                    </tr>
                    </tbody>
                </table>
            </tab-content>
            <template slot="finish">
                <button type="button" class="wizard-btn" :disabled="loading">
                    <span v-if="!loading" @click.once="loading = true">Finish</span>
                    <spinner-icon :size="'sm'" class="white" v-if="loading"></spinner-icon>
                </button>
            </template>
        </form-wizard>
    </div>
</template>
<script>
    import Vue from 'vue';
    import Form from './../../../common/form';
    import VueFormWizard from 'vue-form-wizard';
    import {each} from 'lodash';

    Vue.use(VueFormWizard);

    export default {
        components: {
            'resumable': require('./../../../components/resumable/resumable').default,
            'spinner-icon': require('./../../../components/spinner-icon/spinner-icon').default,
            'input-errors': require('./../../../components/input-errors/input-errors').default,
        },
        computed: {
            fileHeaders() {
                const headers = [];
                this.fileForm.uploaded_file_headers.forEach(header => {
                    let find = false;
                    each(this.fileForm.uploaded_file_fieldmap, val => {
                        if (val === header) {
                            find = true;
                        }
                    });
                    if (!find) {
                        headers.push(header);
                    }
                });
                return headers;
            }
        },
        data() {
            return {
                fileForm: new Form({
                    pm_list_name: null,
                    pm_list_type: 'all_conquest',
                    uploaded_file_name: null,
                    uploaded_file_headers: [],
                    enable_text_to_value: false,
                    uploaded_file_fieldmap: {}
                }),
                headers: [],
                pmFields : [],
                loading: false,
                textToValueEnabled: window.enableTextToValue
            };
        },
        props: ['targetUrl'],
        mounted () {
            this.pmFields = window.pmFields;
            console.log(pmFields);
        },
        methods: {
            clearError: function (form, field) {
                form.errors.clear(field);
            },
            onFileAdded() {
                this.$refs.resumable.startUpload();
            },
            onFileSuccess(event) {
                const response = JSON.parse(event.message);
                this.fileForm.uploaded_file_name = response.name;
                this.fileForm.uploaded_file_headers = response.headers;
                this.$refs.wizard.nextTab();
                this.matchHeadersWithFields();
            },
            matchHeadersWithFields() {
                this.fileForm.uploaded_file_headers.forEach(header => {
                    if (Object.keys(this.fileForm.uploaded_file_fieldmap).indexOf(header) !== -1) {
                        this.fileForm.uploaded_file_fieldmap[header] = header;
                    }
                });
            },
            saveRecipients() {
                this.loading = true;
                this.fileForm
                    .post(window.saveRecipientsUrl)
                    .then(() => {
                        window.location.replace(window.recipientsIndexUrl);
                    }).catch(e => {
                        window.PmEvent.fire('errors.api', getRequestError(e));
                        this.loading = false;
                    });
            },
            validateFileTab() {
                return this.fileForm.uploaded_file_headers.length > 0;
            },
            validateRecipientList() {
                let valid = true;
                this.fileForm.errors.clear();
                if (!this.fileForm.pm_list_name) {
                    valid = false;
                    this.fileForm.errors.add('pm_list_name', 'This field is required.');
                }
                return valid;
            }
        }
    };
</script>
