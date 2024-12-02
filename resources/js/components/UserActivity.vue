
<template>
<div  >
<h2 class="mb-4">User Activities</h2>
<ul class="list-group">
<li class="list-group-item" v-for="activity in activities" :key="activity.id">
{{ activity.action }} - {{ formatTimeAgo(activity.created_at) }}
</li>
</ul>
</div>
</template>

<script>
import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';

export default {
data() {
return {
activities: []
};
},
created() {
this.fetchActivities();
},
methods: {
fetchActivities() {
axios.get('/v1/activities')
.then(response => {
this.activities = response.data;
});
},
formatTimeAgo(date) {
return formatDistanceToNow(new Date(date), { addSuffix: true });
}
}
};
</script>