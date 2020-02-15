
if(document.readyState ==='loading')
{
    document.addEventListener('DOMContentLoaded', ready)
}else {
    ready()
}


function ready() {

    var quantityInputs = document.getElementsByClassName('qty')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)

    }
}

function quantityChanged(event) {

    var cartRows = document.getElementsByClassName('product-name')
        for ( i = 0; i < cartRows.length; i++)
    {
        var price = document.getElementsByClassName('price')[i].innerText.replace('DT', '');
        var qty = document.getElementsByClassName('qty')[i].value;
        var total0 = document.getElementsByClassName('totalParProduit')[i].innerText.replace('DT', '');
        var total=qty*parseFloat(price);
        document.getElementsByClassName('totalParProduit')[i].innerText=total+"DT";
    }
}