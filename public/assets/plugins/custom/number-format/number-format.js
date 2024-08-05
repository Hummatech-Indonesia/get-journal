// If you want to using this library, you must install jquery first


/**
 * to format number to indonesian format (ex: 1.123,12312)
 * 
 * @param {string|number} number -> data that wanna be formatted
 * @param {boolean} isNumber -> is data from calculation (true) [ex: 1231.1211] or input (false) [ex: 1.231,1211]
 * @returns {string|number}
 */
function formatNum(number, isNumber = false) {
    if(number) {
        number = ( isNumber ? parseFloat(number).toFixed(2) : number.toString() )
        var negate = (number.charAt(0) == '-' ? '-' : '');
        if(isNumber) {
            var angka = number.replace(/[^.\d]/g, '').toString()
            var split = angka.split('.')
            var intl = new Intl.NumberFormat('id-ID').format(split[0])
            var dec = split[1] && split[1] != '00' ? ','+split[1] : ''
        } else {
            var angka = number.replace(/[^,\d]/g, '').toString()
            var split = angka.split(',')
            var intl = new Intl.NumberFormat('id-ID').format(split[0])
            var dec = split[1] != undefined && split[1] != '00' ? ','+split[1] : ''
        }

        if(negate+intl+dec == '-0') return 0
        return negate+intl+dec
    } else return 0;
}

/**
 * to unformating data from formatNum function
 * 
 * @param {string|number} number 
 * @returns {number}
 */
function unformatNum(number) {
    if(number) {
        number = number.toString()
        var negate = (number.charAt(0) == '-' ? '-' : '');
        var angka = number.replace(/[^,\d]/g, '').toString()
        var angka = angka.replace(',', '.').toString()
        var angka_string = negate+angka

        return parseFloat(angka_string);
    } else return 0;
}

/**
 * auto formatted number by adding class format-number
 * 
 * # you can add custom attribute
 * - data-min -> set minimum of number : int | float
 * - data-max -> set maximum of number : int | float
 * - data-target -> input element that you want save the unformatted number
 */
$(document).on('change input', '.format-number', function() {
    if($(this).val() !== '') {
        $(this).val(formatNum($(this).val()))
    }

    let unformat_number = unformatNum($(this).val())

    if($(this).attr('data-min') !== undefined) {
        const data_min = parseFloat($(this).attr('data-min'))
        unformat_number = ( unformat_number < data_min ? data_min : unformat_number )
        $(this).val(formatNum(unformat_number, true))
    }
    if($(this).attr('data-max') !== undefined) {
        const data_max = parseFloat($(this).attr('data-max'))
        unformat_number = ( unformat_number > data_max ? data_max : unformat_number )
        $(this).val(formatNum(unformat_number, true))
    }

    if($(this).attr('data-target') !== undefined) {
        const data_target = $(this).attr('data-target')
        $(data_target).val(unformat_number)
    }
})