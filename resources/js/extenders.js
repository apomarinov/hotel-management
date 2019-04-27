/**
 * Add days to a date
 *
 * @param days
 * @returns {Date}
 */
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}
