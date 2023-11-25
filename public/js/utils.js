function formatCurrency(input) {
    let value = input.value;
    value = value.replace(/[^0-9]/g, '');
    const formattedValue = Intl.NumberFormat('en-ID').format(value);
    input.value = formattedValue;
}