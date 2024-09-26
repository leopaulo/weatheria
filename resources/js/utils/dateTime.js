export function formatTimeString(timeString, format) {
    let dateObj = new Date("2024-09-26 " + timeString);
    return dateObj.toLocaleTimeString("en-US", format);
}
