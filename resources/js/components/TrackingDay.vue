<template>
    <div class="container my-3"> 

        <transition
            appear
            enter-active-class="animated slideInUp">

            <div class="card" :style="animationDuration">
                <div class="card-header" :style="progressColor">
                    <span class="float-left toggle"><h2>{{ day.measure_date }}</h2></span>
                    <span class="float-right toggle" @click="toggle"><h2>{{ toggleText }}</h2></span>
                </div>
                <div class="card-header grid-header" v-if="show">
                    <div> Measured today (kg) </div>
                    <div> Compared to yesterday (kg) </div>
                    <div> Progress (%) </div>
                </div>
                <div class="card-body" v-if="show">
                    
                    <div>
                    <img width="32" src="/images/scale.png" alt="">
                    </div>

                    <div>
                    <img width="32" src="/images/plusminus.png" alt="">
                    </div>

                    <div>
                        <img width="32" src="/images/progress.png" alt="">
                    </div>

                    <div> <h2> {{ day.weight | toFixed }} </h2> </div>

                    <div> <h2> {{ kgDiff | toFixed | toUnits }} </h2> </div>

                    <div> <h2> {{ day.progress }} % </h2> </div>
                    
                </div>
            </div>
        </transition>

        

    </div>
</template>

<script>

    export default {
        props: ['day', 'kgDiff', 'slideDuration'],
        data() {
            return {
                show: true,
                toggleText: 'hide',
                progressColor: {
                    'background-color': `rgb(${this.getProgressColor()[0]}, ${this.getProgressColor()[1]}, ${this.getProgressColor()[2]})`
                },
                animationDuration: {
                    'animation-duration': this.slideDuration + 's'
                }
            }
        },
        methods: {
            toggle() {
                !this.show ? this.display() : this.hide();
            },
            display() {
                this.show = true;
                this.toggleText = 'hide';
            },
            hide() {
                this.show = false;
                this.toggleText = 'show';
            },
            getProgressColor() {
                return progressRYG(this.day.progress);
            }
        },
        filters: {
            toFixed(value) {
                if((value > 0 || value < 0))
                    return Number.parseFloat(value).toFixed(1);
                return Number.parseInt(value);
            },
            withSign(value) {
                if(Math.sign(value) > 0)
                    return `+${value}`;
                else if(Math.sign(value) < 0)
                    return `-${value * -1}`;
                else
                    return `${value}`;
            },
            toUnits(value) {
                if(value > 0) {
                    if(value >= 1)
                        return `+${value} kg`;
                    return `+${value * 1000} g`;
                } else if(value < 0) {
                    if(value <= -1)
                        return `${value} kg`;
                    return `${value * 1000} g`;
                } else {
                    return `${value} g`;
                }     
            }
        },
        mounted() {
        }
        
    }
</script>

<style scoped>

    .toggle {
        cursor: pointer;
    }

    .card-body {
        padding: 1em;
        width: 100%;
        box-sizing: border-box;
        font-size: 1vh;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        text-align: center;
    }
    
    .grid-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        text-align: center;
        padding: 0;
    }

    .grid-header > div {
        border: .1px solid black;
    }


</style>