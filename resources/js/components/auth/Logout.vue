<template>
    <div>
        <a @click="logout" class="nav-link" role="button">Logout</a>
 
    </div>
</template>
<script>
export default {
    props:{
        laravel:Object
    },
    methods:{
        logout:function(){
            axios.get('/sanctum/csrf-cookie').then(response => {
            let success = false;
            //call api to logout
            axios.post("api/logout",)
            .then(response => {
               //console.log(response.data);
               if (response.data.success) {
                    //this.$router.push("app");
                    success = true;
                    this.laravel.isLoggedin = false;
                    this.laravel.user = null;
                }
                else{
                    alert(response.data.message);
                    console.log(response.data.message);
                }
            })
            .catch(function(error){
                console.log(error);
            });
            if (success){
                this.laravel.isLoggedin = false;
            }
            });
        }
    }
}
</script>