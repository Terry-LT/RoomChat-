<template>
<div>
    <NavBar />
    <div class="container">
        <div v-if="chat_messages.length == 0" class="mt-5">
            <div class="alert alert-primary" role="alert">
                Nothing is here. Write something
            </div>
        </div>
        <div class="mt-5" v-else v-for="message in chat_messages">
            <MessageDetail v-bind:message="message" v-bind:laravel="laravel"
            v-bind:getMessages="getMessages" v-bind:room_token="room_token"
             />

        </div>

        <div v-if="roomExists">
            <form class=" position-absolute bottom-0 start-50 translate-middle-x">
                <div class="d-flex flex-row ">
                    <div class="mb-3">
                    <input v-model="message_body" type="text" class="form-control form-control-lg " >
                    </div>
                    <div class="mb-3 ms-3">
                    <!--https://icons.getbootstrap.com/icons/send/--->
                    <button @click="sendMessage" type="button" class="btn btn-outline-primary ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                         <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg></button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
</template>
<script>
import MessageDetail from "./message/MessageDetail.vue"
import NavBar from "../NavBar.vue"
export default {
    data:function(){
        return {
            room_token:this.$route.params.room_token,
            chat_messages:[],
            laravel:window.Laravel,

            message_body:"",
            roomExists:false,
            
            show_update_form:false,
        }
    },
    components:{
        NavBar,MessageDetail,
    },
    created(){
        this.checkRoomForExisting();
        this.getMessages();

        this.checkForNewMessages();
        
       
    },
    methods:{
        redirectIfRoomDoesNotExist:function(){

           alert("Such room does not exist");
           setTimeout(() => {
            //redirect to home page
            this.$router.push({name:'home'});

            }, "2000")
        },
        checkRoomForExisting:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    'token':this.room_token,
                };
                if (this.room_token.length != 0){
                    //call api to get room object
                    axios.post(`api/rooms/`,data).then(response => {
                        
                        //if such room does not exist
                        if (response.data.room == null){
                            this.redirectIfRoomDoesNotExist();
                        }
                        else{
                            this.roomExists = true;
                            
                        }
                    });

                }
                else{
                   this.redirectIfRoomDoesNotExist();
                }
  
            })
        },
        //Message Functions
        
        getMessages:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    params: {
                        'room_token':this.room_token,
                    }
                };

                axios.get(`api/messages/`,data).then(response => {
                    this.chat_messages = response.data.data;
                    //console.log(response.data.data);
                });

            })
        },
        checkForNewMessages:function(){
            // check for new messages each 5 seconds
            let get_new_messages = this.getMessages;
            setInterval(function(){
                get_new_messages();
            }, 5000);
        },
        sendMessage:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    'room_token':this.room_token,
                    'body':this.message_body,
                    'user_id':this.laravel.user.id,
                };

                axios.post(`api/messages/`,data).then(response => {
                    //console.log(response.data);
                    //to get new message
                    this.getMessages();
                    //to clear message input
                    this.message_body = ""; 

                });

            })
        },
        /*deleteMessage:function(message_id){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                
                axios.delete(`api/messages/${message_id}`).then(response => {
                    this.getMessages();
                    //console.log(response.data);
                })
                .catch(error => console.log(error))
                ;

            })
        },
        editMessage:function(message_id){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    'room_token':this.room_token,
                    'body':this.message_body,
                };
                axios.patch(`api/messages/${message_id}`,data).then(response => {
                    this.getMessages();
                    //console.log(response.data);
                })
                .catch(error => console.log(error))
                ;

            })
        }*/
    }
    
}
</script>