<template>
    <div>
        <h2 class="text-primary mb-4">Available Columns</h2>
        <button @click="fetchContactFields" class="btn btn-primary">Fetch Columns</button>
        <div v-if="tableColumns.length" class="mt-4">
            <h3 class="text-primary">Table Columns</h3>
            <ul>
                <li v-for="column in tableColumns" :key="column.value">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="selectedColumns" :value="column.value"
                            :id="`column-${column.value}`">
                        <label class="form-check-label" :for="`column-${column.value}`">{{ column.text }}</label>
                    </div>
                </li>
            </ul>
            <button @click="fetchContactData" class="btn btn-success" v-if="selectedColumns.length">Get Contact
                Data</button>
        </div>

        <div v-if="contactData.length" class="mt-4">
            <h3 class="text-primary">Contact Data</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th v-for="column in selectedColumns" :key="column">{{ getColumnLabel(column) }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(contact, index) in displayedContacts" :key="index">
                        <td v-for="column in selectedColumns" :key="column">{{ contact[column] }}</td>
                    </tr>
                </tbody>
            </table>

            <p>In the table we display only a small amount of data but once you export you will get the full list.</p>
            <button @click="exportToCSV" class="btn btn-info">Export to CSV</button>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            tableColumns: [], // Initialize as empty array
            selectedColumns: [], // Initialize as empty array to store selected columns
            contactData: [], // Initialize as empty array to store contact data
            fullContactData: [] // Initialize as empty array to store full contact data
        };
    },
    computed: {
        displayedContacts() {
            return this.contactData.slice(0, 5);
        }
    },
    methods: {
        async fetchContactFields() {
            try {
                const response = await apiService.getContactFields();
                this.tableColumns = response.data[0];
            } catch (error) {
                console.error('Error fetching contact fields:', error);
            }
        },
        async fetchContactData() {
            try {
                const response = await apiService.getFilteredContacts(this.selectedColumns);
                this.fullContactData = response.data;
                this.contactData = response.data; // Display the first 5 contacts
            } catch (error) {
                console.error('Error fetching contact data:', error);
            }
        },
        getColumnLabel(columnValue) {
            const column = this.tableColumns.find(col => col.value === columnValue);
            return column ? column.text : columnValue;
        },
        exportToCSV() {
            const csvContent = [
                this.selectedColumns.join(','), // Header row
                ...this.fullContactData.map(contact =>
                    this.selectedColumns.map(column => contact[column]).join(',')
                ) // Data rows
            ].join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'contact_data.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
};
</script>