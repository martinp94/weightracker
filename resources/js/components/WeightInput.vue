<template>
    <div class="weightInput">
        <input focus
            type="text"
            v-model="weight" 
            :name="name"
            :style="{width: `${inputWidth}px`}"
            @keyup="inputHandler"/> kg

        <div class="input-error">{{ error.message }}</div>
    </div>
</template>

<script>

    export default {
        props: ['name', 'focus'],
        data() {
            return {
                inputWidth: 24,
                weight: '0',
                error: {
                    message: ''
                }
            }
        },
        methods: {
            inputHandler() {
                if(this.validateInput()) {
                    this.formatInput();
                    this.$emit('change', this.weight);
                }
                    
                    
            },
            formatInput() {

                // if input length is 0, set value to 0
                // We check if current lenght is 1 and user presses backspace(keycode 8)

                if(this.weight.length === 0)
                    this.weight = 0;

                // if length is greater than 1, put comma before last number
                // and change first value if it is 0 (ex. 045 -> 45)

                if(this.weight.length > 1) {
                    this.weight = this.weight.replace(',', '');

                    if(this.weight.charAt(0) == '0') {
                        this.weight = this.weight.replace('0', '');
                    }
                    
                    // check for length again if replacing changed length to 1
                    if(this.weight.length > 1) {
                        let curr = this.weight.split('');
                        curr.splice(this.weight.length - 1, 0, ',');
                        this.weight = curr.join('');
                    }
                }
                this.updateInputWidth();
            },
            updateInputWidth() {
                const inputLength = this.weight.length;
                let newWidth = this.weight.length <= 1 ? 24 : 19 * (inputLength - 1);
                this.inputWidth = newWidth;
            },
            validateInput() {
                

                if(!Number(this.weight.replace(",", ".")) && this.weight != 0) {
                    this.error.message = 'Invalid input: only numeric characters supported!';
                    return false;
                }
                
                if(this.weight.length > 8) {
                    this.error.message = 'Max value: 999999,9';
                    return false;
                }
                
                this.error.message = '';
                return true;
            }
        },
        mounted() {
            if(this.focus)
                this.$el.children[0].focus()

        }
        
    }
</script>

<style lang="scss" scoped>

@font-face {
    font-family: "Digital";
    src: url("/fonts/digital-7.ttf");
}
    
.weightInput {

  outline: none;
  font-size: 2rem;

  input {
    box-sizing: border-box;
    
    font-size: inherit;
    border-radius: .6em;
    outline: none;
    font-family: 'Digital', 'Nunito', sans-serif;
  }
  
  .input-error {
      
    margin-left: 1rem;
    display: inline;
    color: red;
    font-size: .7rem;
  }

}

</style>
