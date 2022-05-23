<template>
    <button type="button" @click="joinRoomByRandom"
                class="btn text-white ms-5" style="background-color:#9ADCFF">I am lucky</button>
</template>
<script>
export default {
    methods:{
        joinRoomByRandom:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                //call api to redirect check and get room
                axios.post(`api/rooms/random`).then(response => {
                    this.$router.push({
                                name:"room",
                                params:{room_token:response.data.room.token,
                                /*room:response.data.room*/},
                            });
                });
            })
        },
    }
}
</script>