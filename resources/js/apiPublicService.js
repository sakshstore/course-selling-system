import axios from "axios";

const apiClient = axios.create({
    baseURL: "/v1",
    headers: {
        "Content-Type": "application/json",
    },
});

export default {
   

    getSettings() {

     
        return apiClient.get("/settings/brand-settings");
    },


    sendOtp(email) {
        return apiClient.post("/auth/send-otp", { email });
    },
    verifyOtp(email, otp) {
        return apiClient.post("/auth/verify-otp", { email, otp });
    },
     


    sendGuideOTP(email) {
        return apiClient.post("/guide/send-otp", { email });
    },
    verifyGuideOTP(email, otp) {
        return apiClient.post("/guide/verify-otp", { email, otp });
    },


  
   
    // Add other API methods here
};
