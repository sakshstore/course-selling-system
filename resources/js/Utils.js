import { formatDistanceToNow, format } from "date-fns";
import { useToast } from 'vue-toastification';


function formatTimeAgo(date) {
    return formatDistanceToNow(new Date(date), { addSuffix: true });
}

function formatDate(date) {
    return format(new Date(date), "yyyy-MM-dd HH:mm:ss");
}

function printtoast(text) {

    const toast = useToast();

    toast.success(text);
    
}

export default {
    install(app) {
        app.config.globalProperties.$formatTimeAgo = formatTimeAgo;
        app.config.globalProperties.$formatDate = formatDate;

        app.config.globalProperties.$printtoast = printtoast;



    },
};
