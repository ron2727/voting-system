export class DateFormat { 
    static getDateWithMonthName(dateString) {
        const date = new Date(dateString);
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        
        return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`
    }
    
    static getTimeOfDate(dateString) {
        const date = new Date(dateString);
        const hours = date.getHours();
        let time = '';

        if (hours < 12) {
            time = `${hours}:${date.getMinutes()} AM`;
        }else{
            time = `${hours-12}:${date.getMinutes()} PM`;
        }

        return time;
    }

    static getDateTime(dateString) {
       return dateString.split('T').join(' ');
    }
}
         