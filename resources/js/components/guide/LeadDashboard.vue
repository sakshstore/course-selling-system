<template>
    <div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Leads</h5>
                        <p class="card-text">{{ dashboardData.totalLeads }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Leads by Tag</h5>
                        <ul>
                            <li v-for="tag in dashboardData.leadsByTag" :key="tag.id">
                                {{ tag.name }}: {{ tag.leads_count }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Leads by Status</h5>
                        <ul>
                            <li v-for="status in dashboardData.leadsByStatus" :key="status.status">
                                {{ status.status }}: {{ status.total }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Leads by Date</h5>
                        <ul>
                            <li v-for="date in dashboardData.leadsByDate" :key="date.date">
                                {{ date.date }}: {{ date.total }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import apiService from '@/apiService';
export default {
    data() {
        return {
            dashboardData: {
                totalLeads: 0,
                leadsByTag: [],
                leadsByStatus: [],
                leadsByDate: []
            }
        };
    },
    mounted() {
        this.fetchDashboardData();
    },
    methods: {
        async fetchDashboardData() {


            const response = await apiService.leaddashboarddata();


            this.dashboardData = response.data;
        }
    }
};
</script>
 