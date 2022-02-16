import {globalConfig} from './config';
import moment from 'moment';

/**
 * Set the currency field format
 *
 * @param value
 * @returns {currency | never}
 * @constructor
 */
window.GBP = value => {
    return currency(value, {
        precision: 2,
        symbol: '£',
        formatWithSymbol: true,
        separator: ',',
        decimal: '.',
        pattern: `!   #`,
        negativePattern: `! - #`
    }).format();
}

export const blackOrWhite = hexcolor => {
    hexcolor = hexcolor.replace('#', '');
    const r = parseInt(hexcolor.substr(0, 2), 16);
    const g = parseInt(hexcolor.substr(2, 2), 16);
    const b = parseInt(hexcolor.substr(4, 2), 16);
    const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    return (yiq >= 128) ? 'black' : 'white';
}

export const randomColour = () => {
    const makeColorCode = '0123456789ABCDEF';
    let code = '#';
    for (let count = 0; count < 6; count++) {
        code =code+ makeColorCode[Math.floor(Math.random() * 16)];
    }
    return code;
}

export const currency = (amount, currency = null) => {
    const internationalFormat = new Intl.NumberFormat(
        globalConfig.locale,
        {style: "currency", currency: currency || globalConfig.currency});

    return internationalFormat.format(amount);
}

export function formatDate(date) {
    return moment(date).format(globalConfig.preferredDateFormat);
}
