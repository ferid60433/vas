const BASIC = [
    '@', '£', '$', '¥', 'è', 'é', 'ù', 'ì', 'ò', 'Ç', '\n', 'Ø', 'ø', '\r', 'Å', 'å',
    'Δ', '_', 'Φ', 'Γ', 'Λ', 'Ω', 'Π', 'Ψ', 'Σ', 'Θ', 'Ξ', 'Æ', 'æ', 'ß', 'É',
    ' ', '!', '"', '#', '¤', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/',
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', '>', '?',
    '¡', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
    'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ä', 'Ö', 'Ñ', 'Ü', '§',
    '¿', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
    'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'ä', 'ö', 'ñ', 'ü', 'à',
].join('');

const EXTENSION = [
    '\f', '^', '{', '}', '\\', '[', '~', ']', '|', '€'
].join('');
const BASIC_STRING = BASIC + EXTENSION;

export class SmsLength {

    constructor(message = '') {
        this._message = message;
    }

    get message() {
        return this._message;
    }

    set message(value) {
        this._message = ('string' === typeof value) ? value : '';
    }

    is7Bit() {
        for (let ch of this.message) {
            if (!BASIC_STRING.includes(ch)) {
                return false;
            }
        }

        return true;
    }

    isUnicode() {
        return !this.is7Bit();
    }

    length() {
        if (this.isUnicode()) {
            return this.message.length;
        }

        let extensionCount = 0;

        for (let ch of this.message) {
            if (EXTENSION.includes(ch)) {
                extensionCount++;
            }
        }

        return this.message.length + extensionCount;
    }

    parts() {
        let length = this.length();

        if (this.isUnicode()) {
            if (length <= 70) return 1;
            else return Math.ceil(length / 67);
        }

        if (length <= 160) return 1;
        else return Math.ceil(length / 153);
    }

    left() {
        let length = this.length();
        let parts = this.parts();

        if (this.isUnicode()) {
            if (parts === 1) return 70 - length;
            else return (parts * 67) - length;
        }

        if (parts === 1) return 160 - length;
        else return (parts * 153) - length;
    }

}
