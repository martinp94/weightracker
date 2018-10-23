export const progressRYG = function(progress) {
    let red = 255;
    let green = 0;
    let blue = 0;
        
    if(progress <= 50) {
        green = Math.ceil(510 * (progress/100)) 
    } else {
        green = 255;
        red = Math.ceil(510 * (1 - (progress/100))) 
    }

    return [red, green, blue];
}