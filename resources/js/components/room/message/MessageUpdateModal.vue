<template>
<div>
<!--https://getbootstrap.com/docs/5.0/components/modal/-->
<!-- Button trigger modal -->
<button type="button" class="badge rounded-pill bg-primary btn-primary" 
data-bs-toggle="modal" :data-bs-target="'#messageUpdate_'+message.id">
  Edit Message
</button>

<!-- Modal -->
<div class="modal fade" :id="'messageUpdate_'+message.id" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Message Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" v-model="message_body">
        <div v-if="error.body.message != null" class="text-danger">
          {{error.body.message}}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="editMessage">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
</template>
<script>
export default {
    data:function(){
        return {
            message_body:"",
            error:{
              body:{
                message:null,
              }
            },
        };
    },
    props:{
        message:Object,
        getMessages:Function,
        room_token:String,
        
    },
    created(){
        this.message_body = this.message.body;
    },
    methods:{
        setErrorMessage:function(errors){
          if (errors != undefined){
             this.error.body.message = errors.body[0];
          }
          else{
            this.error.body.message = null;
            
          }
        },
        editMessage:function(){
            axios.get('/sanctum/csrf-cookie').then(response =>{
                let data = {
                    'room_token':this.room_token,
                    'body':this.message_body,
                };
                axios.patch(`api/messages/${this.message.id}`,data).then(response => {
                    this.getMessages();
                    this.setErrorMessage();
                    //console.log(response.data.error);
                })
                .catch(
                    error => {
                      this.setErrorMessage(error.response.data.errors);
                    }
                )
                ;

            })
        }
    },
}
</script>