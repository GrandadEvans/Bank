import {blackOrWhite, currency, randomColour} from '@/helpers.js'

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
