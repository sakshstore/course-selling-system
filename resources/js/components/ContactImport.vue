<template>
    <div>
        <h2>Paste Your CSV Data</h2>
        <form @submit.prevent="handleSubmit">
            <div class="mb-3">
                <label for="textarea" class="form-label">Your Data</label>
                <textarea id="textarea" v-model="textData" class="form-control"
                    placeholder="Paste your CSV data here..." rows="10" max-rows="15"></textarea>
            </div>
            <button type="submit" class="btn btn-info btn-sm">Submit</button>
        </form>

        <div v-if="csvData.length">
            <h3 class="text-primary mt-4">Map CSV Columns to Table Columns</h3>
            <form @submit.prevent="mapColumns">
                <div v-for="(column, index) in csvColumns" :key="index" class="mb-3">
                    <label :for="`column-${index}`" class="form-label">CSV Column: {{ column }}</label>
                    <select v-model="columnMappings[column]" class="form-select" @change="updateMappedData">
                        <option v-for="option in availableTableColumns(column)" :key="option.value"
                            :value="option.value">{{ option.text }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-info btn-sm">Map Columns</button>
            </form>
        </div>

        <div v-if="csvData.length">
            <h3 class="text-primary mt-4">Mapped Data</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th v-for="field in tableFields" :key="field.key">{{ field.label }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in mappedData" :key="index">
                        <td v-for="field in tableFields" :key="field.key">{{ row[field.key] }}</td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-info btn-sm" @click="importData" :disabled="!mappedData.length">Import Data</button>
        </div>

        <!-- New section to display import result -->
        <div v-if="importResult">
            <h3 class="text-primary mt-4">Import Result</h3>
            <p>{{ importResult.message }}</p>
            <p>Total New Contacts: {{ importResult.total_new_contacts }}</p>
            <ul>
                <li v-for="email in importResult.new_contacts_emails" :key="email">{{ email }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
import Papa from 'papaparse';
import axios from 'axios';

export default {
    data() {
        return {
            textData: '',
            csvData: [],
            csvColumns: [],
            columnMappings: {},
            mappedData: [],
            importResult: null, // New data property to store import result
            tableColumns: [], // Initialize as empty array
            tableFields: [] // Initialize as empty array
        };
    },
    created() {
        this.fetchImportFields();
    },
    methods: {
        async fetchImportFields() {
            try {
                const response = await axios.get('/v1/getContactfields');
                this.tableColumns = response.data[0];
                this.tableFields = response.data[1];
            } catch (error) {
                console.error('Error fetching import fields:', error);
            }
        },
        handleSubmit() {
            Papa.parse(this.textData, {
                header: true,
                complete: (results) => {
                    this.csvData = results.data;
                    this.csvColumns = results.meta.fields;
                    this.initializeColumnMappings();
                }
            });
        },
        initializeColumnMappings() {
            this.columnMappings = {};
            this.csvColumns.forEach(column => {
                this.columnMappings[column] = '';
            });
        },
        availableTableColumns(currentColumn) {
            const selectedColumns = Object.values(this.columnMappings).filter(value => value !== '' && value !== this.columnMappings[currentColumn]);
            return this.tableColumns.filter(option => !selectedColumns.includes(option.value));
        },
        mapColumns() {
            this.updateMappedData();
        },
        updateMappedData() {
            this.mappedData = this.csvData.map(row => {
                const mappedRow = {};
                for (const [csvColumn, tableColumn] of Object.entries(this.columnMappings)) {
                    if (tableColumn) {
                        mappedRow[tableColumn] = row[csvColumn];
                    }
                }
                return mappedRow;
            });
        },
        async importData() {
            try {
                const response = await axios.post('/v1/importContacts', this.mappedData);
                this.importResult = response.data; // Store the import result
                console.log('Import successful:', response.data);
            } catch (error) {
                console.error('Error importing data:', error);
            }
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here */
</style>