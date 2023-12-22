/**
 * This will track all the images and fonts for publishing.
 */
import.meta.glob(["../images/**"]);


/**
 * We are defining all the global rules here and configuring
 * all the `vee-validate` settings.
 */
import { configure, defineRule } from "vee-validate";
import { localize } from "@vee-validate/i18n";
import en from "@vee-validate/i18n/dist/locale/en.json";
import * as AllRules from '@vee-validate/rules';

/**
 * Registration of all global validators.
 */
Object.keys(AllRules).forEach(rule => {
    defineRule(rule, AllRules[rule]);
});

/**
 * This regular expression allows phone numbers with the following conditions:
 * - The phone number can start with an optional "+" sign.
 * - After the "+" sign, there should be one or more digits.
 *
 * This validation is sufficient for global-level phone number validation. If
 * someone wants to customize it, they can override this rule.
 */

defineRule("required_if", (value, { condition = true } = {}) => {
    if (condition) {
        if (value === null || value === undefined || value === '') {
            return false;
        }
    }

    return true;
});

defineRule('after', (value, [target]) => {
    if (! value || ! target) {
        return false;
    }
  
    const valueDate = new Date(value);
    const targetDate = new Date(target);
  
    return valueDate > targetDate;
});

defineRule("", () => true);

configure({
    /**
     * Built-in error messages and custom error messages are available. Multiple
     * locales can be added in the same way.
     */
    generateMessage: localize({
        en: {
            ...en,
            messages: {
                ...en.messages,
                phone: "This {field} must be a valid phone number",
            },
        },
    }),

    validateOnBlur: true,
    validateOnInput: true,
    validateOnChange: true,
});


/**
 * Global plugins registration.
 */
import Flatpickr from "./plugins/flatpickr";

[
    Flatpickr,
].forEach((plugin) => window.app.use(plugin));