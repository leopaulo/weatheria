export function kelvinToCelsius(value) {
    return Math.round(value - 273.1);
}

export function weatherIcon(icon, size = 4) {
    let sizeText = size != 1 ? `@${size}x` : "";
    return `http://openweathermap.org/img/wn/${icon}${sizeText}.png`;
}
