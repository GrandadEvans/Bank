import {globalConfig} from '../../resources/js/includes/config';
import {
    blackOrWhite,
    currency,
    randomColour,
    formatDate,
} from '@/../includes/helpers.js'

describe('Check the COLOUR helper', () => {
    it('if background colour is white, we should get a black foreground', () => {
        const blackBackgroundResult = blackOrWhite('#000000');
        expect(blackBackgroundResult).toMatch(/white/);

        const whiteBackgroundResult = blackOrWhite('#FFFFFF');
        expect(whiteBackgroundResult).toMatch(/black/);
    });

    test('we should be able to get a random hex colour code', () => {
        const result1 = randomColour();
        const result2 = randomColour();
        expect(result1).toMatch(/^#[0123456789ABCDEF]{6}$/);
        expect(result2).toMatch(/^#[0123456789ABCDEF]{6}$/);
        expect(result1).not.toBe(result2)
    })
});

describe('Check the CURRENCY helpers', () => {
    test('we should be able to get a currency amount in the default currency', () => {
        const result = currency(1234.56);
        expect(result).toBe('£1,234.56');
    })

    test('we should be able to get a currency amount in a different currency', () => {
        const result = currency(1234.56, "USD");
        expect(result).toBe('US$1,234.56');
    })
});

describe('Make sure the date formats according to the config', () => {
    it('returns the correct format', () => {
        globalConfig.preferredDateFormat = 'YYYY-MM-DD';
        const date1In = '2017-05-26';
        const date1ExpectOut = '2017-05-26';
        const date1ActualOut = formatDate(date1In);
        expect(date1ActualOut).toEqual(date1ExpectOut);

        globalConfig.preferredDateFormat = 'DD-MM-YYYY';
        const date2In = '2016-01-31';
        const date2ExpectOut = '31-01-2016';
        const date2ActualOut = formatDate(date2In);
        expect(date2ActualOut).toEqual(date2ExpectOut);
    })
})
