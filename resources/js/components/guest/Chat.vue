<template>
    <div class=" ">
        <h2 class="mb-4">Chat</h2>
        <div class="chat-history mb-3" ref="chatHistory">
            <ul class="list-group">
                <li v-for="chat in chats" :key="chat.id" class="list-group-item   border-2    "
                    :class="{ 'user-chat': chat.user, 'bot-chat': !chat.user }">
                    <strong v-if="chat.user">{{ chat.user.name }}:</strong> {{ chat.chat }}

                </li>
            </ul>
        </div>
        <form @submit.prevent="postChat">
            <div class="mb-3">
                <textarea v-model="newChat" class="form-control" rows="3" placeholder="Type your chat..."
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</template>

<script>



import apiService from '@/apiGuestService.js';

export default {
    data() {
        return {
            chats: [],
            newChat: '',
            loading: false
        };
    },
    created() {
        this.fetchChats();
    },
    methods: {
        async fetchChats() {
            this.loading = true;
            try {
                const response = await apiService.getChats();
                this.chats = response.data;
            } catch (error) {
                console.error('Error fetching chats:', error);
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        },
        async postChat() {
            try {
                const response = await apiService.postChat(this.newChat);
                this.chats.push(response.data);
                this.newChat = '';
                this.scrollToBottom();
            } catch (error) {
                console.error('Error posting chat:', error);
            }
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatHistory = this.$refs.chatHistory;
                chatHistory.scrollTop = chatHistory.scrollHeight;
            });
        }
    }
};

</script>

<style>
.user-chat {
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 5px;
}

.bot-chat {

    border-radius: 10px;
    padding: 10px;
    margin-bottom: 5px;
}

.chat-history {
    max-height: 400px;
    overflow-y: auto;
}
</style>