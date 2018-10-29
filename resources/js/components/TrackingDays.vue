<template>
    <div> 

        <add-tracking-today :tracking_period_id="tracking_period_id"></add-tracking-today>
    
        <tracking-day class="container my-3"  v-for="(day, key) in days" 
                                            :key="key" 
                                            :day="day" 
                                            :kgDiff="calculateWeightDifference(key)"
                                            :slideDuration="key + 1">
        </tracking-day>
        

    </div>
</template>

<script>

    export default {
        props: ['tracking_period_id'],
        data() {
            return {
               days: {}
            }
        },
        methods: {
            loadDays() {
                axios.get(`/trackingdays/${this.tracking_period_id}`)
                    .then((response) => {
                        this.days = response.data.days;
                    })
                    .catch((error) => {
                        console.log(error.response)
                    });
            },
            calculateWeightDifference(key) {
                if(key === 0)
                    return 0;
                
                return this.days[key].weight - this.days[key - 1].weight;
            }
        },
        mounted() {
            this.loadDays();
        }
        
    }
</script>

<style scoped>
    .header {
        transition: background-color 0.5s ease;
        background-color: red;
    }
    .header:hover {
        background-color: green;
    }
</style>