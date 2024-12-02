<template>
    <div  >
        <h2 class="mb-4">Login History</h2>
         
        <table class="table table-bordered">


            <tr v-for="login in logins" :key="login.id">
               <td> {{ login.ip_address }} </td>
               <td> {{ formatTimeAgo(login.created_at) }} </td>
            </tr>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';

export default {
    data() {
        return {
            logins: []
        };
    },
    created() {
        this.fetchLoginHistory();
    },
    methods: {
        fetchLoginHistory() {
            axios.get('/v1/login-history')
                .then(response => {
                    this.logins = response.data;
                });
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>