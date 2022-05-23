<template>
<div>
    <div class="h5">
         {{message.user.nickname}}
    </div>
    <div>
    {{message.body}}
    </div>
    <div v-if="laravel.user.id == message.user.id">
        <!--Only author of message  can delete/edit his/her message-->
        <MessageUpdateModal v-bind:message="message" v-bind:getMessages="getMessages" v-bind:room_token="room_token" />
        <div>
            
            <button @click="deleteMessage(message.id)" class="badge rounded-pill bg-danger btn-danger" type="button">delete</button>
        </div>
                    
    </div>
</div>
</template>
<script>
import MessageUpdateModal from "./MessageUpdateModal.vue"
export default {
    components:{
     MessageUpdateModal
    },
    props:{
        message:Object,
        laravel:Object,
        getMessages:Function,
        room_token:String,
    },
    methods:{
        deleteMessage:function(message_id){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                
                axios.delete(`api/messages/${message_id}`).then(response => {
                    this.getMessages();
                    //console.log(response.data);
                })
                .catch(error => console.log(error))
                ;

            })
        },
        
    },
}
</script>