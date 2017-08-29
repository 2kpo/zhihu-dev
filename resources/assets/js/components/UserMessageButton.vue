<template>
    <div>
        <button
            class="btn btn-default pull-right"
            style="margin-top: -36px;"
            @click="show"
    >发送私信</button>
<div class="modal fade" id="send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            发送私信
                        </h4>
                    </div>

                    <div class="modal-body">
                        <textarea class="form-control" v-model="body" name="body" v-if="!status"></textarea>
                        <div class="alert alert-success" v-if="status">
                            <strong>私信发送成功</strong>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="send">发送私信</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user'],
        data() {
            return {
                status: false,
                body: ''
            }
        },
        methods:{
            send() {
                axios.post('/api/message/store',{'body':this.body,'user':this.user}).then(response => {
                    this.status = response.data.status;
                    console.log(response.data);
                    setTimeout(()=>{
                        $('#send-message').modal('hide');
                        this.status = false;
                    },2000);
                    // setTimeout((function(){
                    //     this.status = false
                    // }).bind(this),2000);
                    this.body = ''
                })
            },
            show() {
                $('#send-message').modal('show')
            }
        }
    }
</script>
