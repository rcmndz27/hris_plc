$('#dateFrom').change(function()
{
    $('#dateFrom').attr('value', this.value);
    $('#dateTo').attr('min', this.value);

    if(new Date($('#dateFrom').attr('value')) > new Date($('#dateTo').attr('value')))
    {
        $('#dateTo').attr('value', this.value);
    }
});

$('#dateTo').change(function()
{
    $('#dateTo').attr('value', this.value);

    if(new Date($('#dateFrom').attr('value')) > new Date($('#dateTo').attr('value')))
    {
        $('#dateFrom').attr('value', this.value);
        $('#dateTo').attr('min', this.value);
    }
});