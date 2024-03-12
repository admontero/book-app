import Datepicker from 'flowbite-datepicker/Datepicker';

export class CustomDatepicker extends Datepicker {
    update(options = undefined) {
        if (this.isValidDateAdvanced(this.inputField.value)) {
            super.update(options);
        } else {
            this.setDate({clear: true});
        }
    }

    isValidDateAdvanced(dateString) {
        const parts = dateString.split('/');
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const year = parseInt(parts[2], 10);

        if (! day || ! month || ! year) {
            return false;
        }

        if (month < 1 || month > 12 || day < 1 || day > 31) {
            return false;
        }

        if ((month === 4 || month === 6 || month === 9 || month === 11) && day === 31) {
            return false;
        }

        if (month === 2) {
            const isLeap = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0));
            if (day > 29 || (day === 29 && ! isLeap)) {
                return false;
            }
        }

        return true;
    }
}
