var util = new Utilities();

function Utilities(){
    
}

/***********************/
/**** Formatting *******/
/***********************/

// Format the date as human-readable string
Utilities.prototype.dateToString = function (date) {
    var now = new Date();
    var newDate;
    var month = new Array( "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" );
    var day = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

    if (typeof date == "undefined" || !date || !Date.parse(date))
        return 'Not Specified';

    date = new Date(date);

    if (now.getFullYear() == date.getFullYear()) { // If year is same as the current year
        newDate = month[date.getMonth()] + ' ' + date.getDate();
        
        if (now.getMonth() == date.getMonth() && (now.getDate() - date.getDate() < 7)) { // If less than a week, format as '[day of week] h:i:s a'
            newDate = day[date.getDay()] + ' ' + ((date.getHours() % 12) == 0 ? 12 : (date.getHours() % 12)) + ':' + ( '0' + date.getMinutes()).slice(-2) + ' ' + ((date.getHours() < 12) ? 'AM' : 'PM');
            
            if (now.getMonth() == date.getMonth() && (now.getDate() - date.getDate() == 1)) { // If one-day difference, format as 'Yesterday h:i:s a'
                newDate = 'Yesterday ' + ((date.getHours() % 12) == 0 ? 12 : (date.getHours() % 12)) + ':' + ( '0' + date.getMinutes()).slice(-2) + ' ' + ((date.getHours() < 12) ? 'AM' : 'PM');
            }
            else if (now.getMonth() == date.getMonth() && now.getDate() == date.getDate()) { // If within the day, format as '[hours] hours ago'
                newDate = (now.getHours() - date.getHours()) + ' hours ago';
                
                if (now.getHours() - date.getHours() == 1) { // If one-hour difference ,format as '1 hour ago'
                    newDate = '1 hour ago';
                }
                else if (now.getHours() == date.getHours()) { // If within the same hour, format as '[minutes] minutes ago'
                    newDate = (now.getMinutes() - date.getMinutes()) + ' minutes ago';
                    
                    if (now.getMinutes() - date.getMinutes() == 1) { // If one-minute difference, format as '1 minute ago'
                        newDate = '1 minute ago';
                    }
                    else { // If within the same minute, fomat as '[seconds] seconds ago'
                        newDate = (now.getSeconds() - date.getSeconds()) + ' seconds ago';
                        
                        if (now.getSeconds() - date.getSeconds() == 1) { // If one-second difference, format as '1 second ago'
                            newDate = '1 second ago';
                        }
                        else if ( (now.getSeconds() - date.getSeconds()) == 0) { // If within the same second, format as 'Just now'
                            newDate = 'Just now';
                        }
                    }
                }
                else {
                  newDate = 'Just now';
                }
            }
        }
    }
    else { // If year is not the same as the current year, format as 'M d Y'
        newDate = month[date.getMonth()] + ' ' + date.getDate() + ', '  + date.getFullYear();
    }

    return newDate;
}

/***********************/
/**** Validations ******/
/***********************/

// Validate email
Utilities.prototype.validateEmail = function (email) {
    var expression = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return expression.test(email);
}

// Generate a unique temporary ID
Utilities.prototype.generateID = function() {
	return Math.floor(Math.random()*1E16)
}