<template>
<div>
<NavBar />
<div class="container">
    <div class="mt-5" >
        <h1 class="text-center">Home page</h1>
    </div>
    <div class="mt-5">
        <RoomJoinBtn />
    </div>
</div>
</div>

</template>
<script>
import NavBar from "./NavBar.vue"
import RoomJoinBtn from "./room/RoomJoinBtn.vue"
export default {
    components:{
        NavBar,RoomJoinBtn
    }
}
</script>