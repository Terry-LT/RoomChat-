<template>
    <div>
        <form>
            <div class="mb-3 me-5 ms-5 pe-5 ps-5" >
                <input v-model="token" :class="{'form-control form-control-sm border-danger':error.token.message}"
                placeholder="type token"
                type="text" class="form-control form-control-sm ">
                <div v-if="error.token.message" class="text-danger">
                    {{error.token.message}}
                </div>
            </div>
            <div class="mb-3 text-center">
                <button type="button" @click="joinRoomByToken"
                class="btn text-white me-5" style="background-color:#FF8AAE">Join Room by Token</button>
                <RoomJoinRandomBtn />
            </div>
        </form>
        
    </div>
</template>
<script>
import RoomJoinRandomBtn from "./RoomJoinRandomBtn.vue"
export default {
    data:function(){
        return {
            token:"",
            error:{
                token:{
                    message:null,
                }
            }
        }
    },
    components:{
RoomJoinRandomBtn
    },
    methods:{
        joinRoomByToken:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    'token':this.token,
                };
                if (this.token.length != 0){
                    this.error.token.message = "";
                    //call api to redirect check and get room
                    axios.post(`api/rooms/`,data).then(response => {
                        console.log(response.data.room);
                        //redirect to the room page if room exists
                        if (response.data.room != null){

                            this.$router.push({
                                name:"room",
                                params:{room_token:this.token,
                                room:response.data.room},
                            });
                        }

                        else{
                            this.error.token.message = "Such room does not exist";
                        }
                    });

                }
                else{
                   this.error.token.message = "The token cannot be empty";
                }
  
            })
        },
    }
}
</script>