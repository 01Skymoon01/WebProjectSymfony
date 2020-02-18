
if(document.readyState =='loading')
{
    document.addEventListener('DOMContentLoaded', ready)
}else {
    ready()
}

function ready(){
    console.log("here")

    var addItemButton = document.getElementsByClassName("addcart")

    for (var i=0 ; i < addItemButton.length ; i++ )
    {
        var button = addItemButton[i]
        button.addEventListener("click", Addtocart )

    }





}

function Addtocart(event)
{
    var buttonClicked = event.target
    var  shopItem = buttonClicked.parentElement.parentElement.parentElement
    var priceItem = shopItem.getElementsByClassName('price')[0].innerText
    var nameItem = shopItem.getElementsByClassName('name')[0].innerText
    var imgItem = shopItem.getElementsByClassName('imgItem')[0].value





    var cartItems = document.getElementById('ItemCart')

    var cartItemNames = cartItems.getElementsByClassName('cart-name')
    for (var i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].innerText == nameItem) {
            alert('This item is already added to the cart')
            return
        }
    }
    var contentsRow= `

   	<tr class="cart-row">
           <td data-th="Product">
             <div class="row">
               <div class="col-sm-2 hidden-xs"><img src="${imgItem}" alt="..." class="img-responsive"/></div>
               <div class="col-sm-10">
                 <h4 class="nomargin cart-name">${nameItem}</h4>
               </div>
             </div>
           </td>
           <td data-th="Price"  class="cart-price">${priceItem}</td>
           
        
         </tr>
         
         `
    cartItems.innerHTML+=contentsRow

}

