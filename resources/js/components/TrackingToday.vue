<template>
    <div class="container text-center my-3"> 

        <transition name="fade" 
            appear
            v-on:after-leave="emitTodayWeightEnteredEvent"> 

            <form @submit.prevent="create" @keydown="form.onKeydown($event)" v-if="!todayWeightEntered">

                <!-- Choose type  -->
                <div class="form-group">
                
                    <label id="type">Enter today's weight</label>
                    <weight-input name="weight" :focus="true" @change="updateWeight($event)"></weight-input>

                </div>

                <div class="form-group">
                    <button :disabled="form.busy" type="submit" class="btn btn-primary form-control">Submit</button>
                </div>

            </form>

        </transition>

    </div>
</template>

<script>

    export default {
        props: ['tracking_period_id'],
        data() {
            return {
                todayWeightEntered: true,
                form: new Form({
                    tracking_period_id: this.tracking_period_id,
                    weight: 0
                })
            }
        },
        methods: {
            updateWeight(val) {
                this.form.weight = parseFloat(val.replace(',', '.'));
            },
            create() {
                this.form.post('/newWeight')
                .then(( data ) => { 
                    this.onCompleted();
                    console.log(data)
                })
                .catch(( error ) => {
                    if(error.response.data.errorCode == '23000') {
                        sweetalert({
                            position: 'top-end',
                            type: 'warning',
                            title: "You have already entered today's weight, please try again tomorrow.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            },
            onCompleted() {
                this.todayWeightEntered = true;
                sweetalert({
                    position: 'top-end',
                    type: 'success',
                    title: "Today's weight entered successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            emitTodayWeightEnteredEvent() {
                EventBus.$emit('todayWeightEntered', true);
            },
            isTodayWeightEntered() {
                axios.get('/checkTodayEntry')
                .then(( response ) => { 
                    if(response.data) {
                        this.todayWeightEntered = response.data.dayExists ? true : false;
                    }
                })
                .catch(( error ) => {
                    console.log(error.response)
                });
            }
        },
        mounted() {
            this.isTodayWeightEntered();
        }
        
    }

</script>

<style scoped>
    
    .fade-enter {
        opacity: 0;
    }

    .fade-enter-active {
        transition: opacity 1s;
    }   

    .fade-leave-active {
        transition: opacity 2s;
        opacity: 0;
    }
    
</style>