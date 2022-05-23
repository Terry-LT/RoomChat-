<template>
<div>
<div class="container mt-5">
    <div class="mt-5 mb-5">
        <MessageAlert :message="error_message" />
    </div>
    <div>
        <form>
            <legend>Login</legend>
            <div class="mb-3">
                <label 
                 class="form-label">Email <span class="text-danger">*</span></label>
                <input 
                  v-model="email" name="email" class="form-control" type="email">
                
            </div>
            <div class="mb-3">
                <label 
                 class="form-label">Password <span class="text-danger">*</span></label>
                <input 
                  v-model="password" name="password" class="form-control" type="password">
                  
            </div>
            <div class="mb-3 form-check">
                <input name="remember_me" v-model="remember_me" type="checkbox" class="form-check-input">
                <label for="remember_me" class="form-check-label">Remember me</label>
            </div>
            <div class="mb-3">
                <button @click="login" class="btn btn-primary" type="button">Login</button>
            </div>
        </form>
    </div>
</div>

</div>
</template>
<script>
import MessageAlert from "./MessageAlert.vue"
export default {
    data:function(){
        return {
            email:'',
            password:'',
            remember_me:false,
            laravel:window.Laravel,
            error_message:'',
            

        }
    },
    components:{
        MessageAlert,//NavBar
    },
    created(){
        //console.log(this.laravel.user);
        //console.log(this.laravel.isLoggedin);
        if (this.laravel.isLoggedin){
           this.$router.push({name:'home'});
        }
        
    },
    mounted(){

    },
    methods:{
        updateErrorMessage:function(updatedMessage){
            this.error_message = updatedMessage;
        },
        login:function(){
            
            let updateErrorMessage = this.updateErrorMessage;
            axios.get('/sanctum/csrf-cookie').then(response => {
            let data = {
                'email':this.email,
                'password':this.password,
                'remember_me':this.remember_me,
            };

            //call api to login user
            axios.post("/api/login",data)
            .then(response => {
                if (response.data.success) {

                    
                    this.laravel.isLoggedin = true;
                    this.laravel.user = response.data.user;

                    this.$router.push({name:'home'});
                }
                else{
                    updateErrorMessage(response.data.message);
                }
            })
            .catch(function(error){
                console.log(error);
                console.log(error.response.data);
                if (error.response.status == 422){
                    console.log(error.response.data.errors);
                    //showError(error.response.data.errors);
                }
               
            });
            });
        }
    }
}
</script>