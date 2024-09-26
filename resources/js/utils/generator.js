import { isEmpty } from "resources/js/utils/dataType";

export function randomNumber(digits) {
    return Math.floor(
        Math.random() * Math.pow(10, digits) + Math.pow(10, digits),
    )
        .toString()
        .slice(-digits);
}

export function uniqid(delimeter) {
    delimeter = delimeter || "-";

    var _padLeft = function (paddingString, width, replacementChar) {
        if (paddingString.length >= width) {
            return paddingString;
        } else {
            return _padLeft(
                replacementChar + paddingString,
                width,
                replacementChar || " ",
            );
        }
    };

    var _s4 = function (number) {
        var hexadecimalResult = number.toString(16);
        return _padLeft(hexadecimalResult, 4, "0");
    };

    var _cryptoGuid = function (delimeter) {
        var buffer = new window.Uint16Array(8);
        window.crypto.getRandomValues(buffer);

        return [
            _s4(buffer[0]) + _s4(buffer[1]),
            _s4(buffer[2]),
            _s4(buffer[3]),
            _s4(buffer[4]),
            _s4(buffer[5]) + _s4(buffer[6]) + _s4(buffer[7]),
        ].join(delimeter);
    };

    var _guid = function (delimeter) {
        var currentDateMilliseconds = new Date().getTime();
        var pattern =
            "xxxxxxxx" +
            delimeter +
            "xxxx" +
            delimeter +
            "4xxx" +
            delimeter +
            "yxxx" +
            delimeter +
            "xxxxxxxxxxxx";

        return pattern.replace(/[xy]/g, function (currentChar) {
            var randomChar =
                (currentDateMilliseconds + Math.random() * 16) % 16 | 0;
            currentDateMilliseconds = Math.floor(currentDateMilliseconds / 16);
            return (
                currentChar === "x" ? randomChar : (randomChar & 0x7) | 0x8
            ).toString(16);
        });
    };

    var create = function (delimeter) {
        if (!isEmpty(window.crypto)) {
            if (!isEmpty(window.crypto.getRandomValues)) {
                return _cryptoGuid(delimeter);
            }
        }

        return _guid(delimeter);
    };

    return create(delimeter);
}

export function generateRandomLetter() {
    const alphabet = "abcdefghijklmnopqrstuvwxyz";

    return alphabet[Math.floor(Math.random() * alphabet.length)];
}

export function generateRandomSpecialChar() {
    const alphabet = "!@#$%^&*()_+";

    return alphabet[Math.floor(Math.random() * alphabet.length)];
}

export function randomPass() {
    let genRandomString = Math.random().toString(36).substring(2, 7);
    let genRandomNumber = randomNumber(1);
    let genRandomUpperCase = generateRandomLetter().toUpperCase();
    let genRandomSpecialChar = generateRandomSpecialChar();

    return (
        genRandomString +
        genRandomNumber +
        genRandomUpperCase +
        genRandomSpecialChar
    );
}
