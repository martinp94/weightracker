<template>
    <div class="container my-3"> 
        <transition name="fade" 
            appear
            v-on:after-leave="emitTrackingPeriodCreatedEvent"> 
            <form @submit.prevent="create" @keydown="form.onKeydown($event)" v-if="!periodCreated" >
                <!-- Choose type  -->
                <div class="form-group">
                
                <label id="type">Select tracking type</label>

                <select name="type" 
                        id="type" 
                        class="form-control" 
                        v-model="form.type"
                        :class="{ 'is-invalid': form.errors.has('type') }"
                        @change="typeSelected = form.type === 'select' ? false : true">


                    <option value="select">Select Tracking Type</option>
                    <option value="timed">Until a certain date</option>
                    <option value="to_weight">To the desired weight</option>


                </select>
                
                <has-error :form="form" field="type"></has-error>

                </div>

                <div class="form-group" v-if="typeSelected">

                    <label for="initial_weight">Enter your weight</label>
                    <weight-input name="initial_weight" :focus="true" @change="updateInitialWeight($event)"></weight-input>

                </div>

                <div class="form-group" v-if="typeSelected && form.type === 'to_weight'">

                    <label for="desired_weight">Enter desired weight</label>
                    <weight-input name="desired_weight" :focus="false" @change="updateDesiredWeight($event)"></weight-input>
                    
                </div>

                <div class="form-group" v-if="typeSelected && form.type === 'timed'">
                    <label for="end_date">Enter date</label>
                    <vuejs-datepicker
                        @selected="updateEndDate"
                        :value="form.endDate"
                        :disabledDates="disabledDates"
                        name="end_date"
                        calendar-class="calendar-header-size"
                        inline
                        :class="{ 'is-invalid': form.errors.has('end_date') }">
                    </vuejs-datepicker>
                        
                    <has-error :form="form" field="end_date"></has-error>
                </div>

                <div class="form-group" v-if="typeSelected">
                    <button :disabled="form.busy" type="submit" class="btn btn-primary form-control">CREATE</button>
                </div>

            </form>
        </transition>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                periodCreated: false,
                typeSelected: false,
                disabledDates: {
                    to: new Date()
                },
                form: new Form({
                    type: 'select',
                    initialWeight: 0,
                    desiredWeight: 0,
                    endDate: null
                })
            }
            
        },
        watch: {
            'form.initialWeight': (val) => {
                console.log(val)
            }
        },
        methods: {
            updateInitialWeight(val) {
                if(val) 
                    this.form.initialWeight = parseFloat(val.replace(',', '.'));
            },
            updateDesiredWeight(val) {
                if(val) 
                    this.form.desiredWeight = parseFloat(val.replace(',', '.'));
            },
            updateEndDate(event) {
                this.form.endDate = event;
            },
            create() {
                this.form.post('/create')
                    .then(( data ) => { 
                        console.log(data)
                        this.onCompleted();
                    })
                    .catch(( error ) => {
                        console.log(error.response.data.message)
                    });
            },
            onCompleted() {
                this.periodCreated = true;
                sweetalert({
                    position: 'top-end',
                    type: 'success',
                    title: 'Tracking period created successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            emitTrackingPeriodCreatedEvent() {
                
                EventBus.$emit('trackingPeriodCreated', true);
            }
        }
        
    }
</script>

<style>
    .calendar-header-size > header {
        height: 3rem;
        background: rgba(12, 231, 247, 0.685);
    }
</style>


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