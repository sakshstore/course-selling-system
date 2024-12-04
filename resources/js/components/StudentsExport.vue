<template>
    <div>
        <h2 class="text-primary mb-4">Available Columns</h2>
        <button @click="fetchImportFields" class="btn btn-primary">Fetch Columns</button>
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
            <button @click="fetchStudentData" class="btn btn-success" v-if="selectedColumns.length">Get Student
                Data</button>
        </div>

        <div v-if="studentData.length" class="mt-4">
            <h3 class="text-primary">Student Data</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th v-for="column in selectedColumns" :key="column">{{ getColumnLabel(column) }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(student, index) in displayedStudents" :key="index">
                        <td v-for="column in selectedColumns" :key="column">{{ student[column] }}</td>
                    </tr>
                </tbody>
            </table>

            <p>In the table we display only a small amount of data but once you export you will get the full list.</p>
            <button @click="exportToCSV" class="btn btn-info">Export to CSV</button>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiservice';

export default {
    data() {
        return {
            tableColumns: [], // Initialize as empty array
            tableFields: [], // Initialize as empty array
            selectedColumns: [], // Initialize as empty array to store selected columns
            studentData: [], // Initialize as empty array to store student data
            fullStudentData: [] // Initialize as empty array to store full student data
        };
    },
    computed: {
        displayedStudents() {
            return this.studentData.slice(0, 5);
        }
    },
    methods: {
        async fetchImportFields() {
            try {
                const response = await apiService.getImportFields();
                this.tableColumns = response.data[0];
                this.tableFields = response.data[1];
            } catch (error) {
                console.error('Error fetching import fields:', error);
            }
        },
        async fetchStudentData() {
            try {
                const response = await apiService.getFilteredStudents(this.selectedColumns);
                this.fullStudentData = response.data;
                this.studentData = response.data; // Display the first 5 students
            } catch (error) {
                console.error('Error fetching student data:', error);
            }
        },
        getColumnLabel(columnValue) {
            const column = this.tableColumns.find(col => col.value === columnValue);
            return column ? column.text : columnValue;
        },
        exportToCSV() {
            const csvContent = [
                this.selectedColumns.join(','), // Header row
                ...this.fullStudentData.map(student =>
                    this.selectedColumns.map(column => student[column]).join(',')
                ) // Data rows
            ].join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'student_data.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
};
</script>