<template>
    <div class="container my-3"> 

        <transition
            appear
            enter-active-class="animated bounceInUp"> 

            <div class="stats" v-if="show" style="background-color: #eee ;">
                <div>
                   <img width="64" src="/images/scale.png" alt="">
                </div>

                <div v-if="period_type == 'timed'">
                   <img width="64" src="/images/date.png" alt="">
                </div>

                <div v-if="period_type == 'to_weight'">
                    <img width="64" src="/images/scale.png" alt="">
                </div>

                <div>
                   <img width="64" src="/images/improvement.png" alt="">
                </div>

                <div> <h1> {{ period.initial_weight }} </h1> </div>

                <div v-if="period_type == 'timed'"> <h1> {{ period.tracking_end_date }} </h1>  </div>

                <div v-if="period_type == 'to_weight'"> <h1> {{ period.desired_weight }} </h1>  </div>

                <div> <h1> 200g/d </h1> </div>

            </div>
            
        </transition>

        <div v-if="show">
            <tracking-days :tracking_period_id="period.id"></tracking-days>
        </div>
        

    </div>
</template>

<script>

    export default {
        data() {
            return {
                show: false,
                period_type: 'timed',
                period: null
            }
        },
        methods: {
            checkActivePeriod() {
                 // Show Stats if active period exists

                axios.get('/checkActivePeriod')
                .then((response) => {
                    
                    if(response.data.message === true) {
                        this.period = response.data.period;
                        this.period_type = this.period.desired_weight === null ? 'timed' : 'to_weight';
                        this.show = true;
                    }
                        
                })
                .catch((error) => console.log(error));
            }
        },
        mounted() {

            this.checkActivePeriod();
            
            EventBus.$on('trackingPeriodCreated', (trackingPeriodCreated) => {
                if(trackingPeriodCreated)
                    this.checkActivePeriod();
            });
        }
        
    }
</script>

<style scoped>

.stats {
    
    padding: 1em;
    width: 100%;
    box-sizing: border-box;
    font-size: 1vh;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    text-align: center;
}
    
</style>